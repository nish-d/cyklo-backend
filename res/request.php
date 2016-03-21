<?php

    /*
    lock_state(0) = unlock request
    lock_state(1) = lock request
    */
    require("functions.php");
    $name = (isset($_GET["name"]))? $_GET["name"]: NULL;
    $college = (isset($_GET["college"]))? $_GET["college"]: NULL;
    $number = (isset($_GET["number"]))? $_GET["number"]: NULL;
    $email = (isset($_GET["email"]))? $_GET["email"]: NULL;
    $cycle_number = (isset($_GET["cycle_number"]))? $_GET["cycle_number"]: 0;
    $lock_state = (isset($_GET["lock_state"]))? $_GET["lock_state"]: NULL;
    $cycle_type = (isset($_GET["cycle_type"]))? $_GET["cycle_type"]: NULL;


    //stands data
    $stand_name = "alpha";

    $type = ($cycle_type == 0) ? "stands_normal" : "stands_premium";
    $sql_stands = "SELECT * FROM " . $type . " WHERE name=?";
    $data_stands = query($sql_stands, $stand_name)[0];

    $cycles = $data_stands["cycles"];
    $cycles_available = $data_stands["cycles_available"];

    $send = array("name" => $data_stands["name"],
                "cycle_strength" => $data_stands["cycle_strength"],
                "cycles_available" => $cycles_available,
                "cycles" => $cycles,
                "cycle_type" => $cycle_type,
                "error" => 0 /* default no error*/ );

    //request data
    if ($name === NULL || $college === NULL
        || $number === NULL || $email === NULL || $lock_state === NULL) {
        $send["error"] = 1;//error(1) = Missing Details
    }
    elseif ($send["cycles_available"] == 0 && $lock_state == 0) {
        $send["error"] = 2;//error(2) = No Cycles
    }
    elseif ($send["cycles_available"] >= $send["cycle_strength"] && $lock_state == 1) {
        $send["error"] = 3;//error(3) = Strength se jyada available?
    }
    else {
        if($lock_state == 0) {
            $cycle_number = stripos($cycles, "1") + 1;
            $cycles_available -= 1;
            $cycles[$cycle_number - 1] = "0";
            $sql_stands = "UPDATE " . $type . " SET cycles_available=?, cycles=? WHERE name=?";
            $data_stands = query($sql_stands, $cycles_available, $cycles, $stand_name);
            $send["cycles_available"] = $cycles_available;
            $send["cycles"] = $cycles;
            if($cycle_type == 1) $cycle_number += 5;
        }

        $send["cycle_number"] = $cycle_number;

        $sql_request = "INSERT INTO request (name, college, number, email, request_done, lock_state, cycle_number, cycle_type) VALUES (?,?,?,?,?,?,?,?)";
        $data_request = query($sql_request, $name, $college, $number, $email, 0, $lock_state, $cycle_number, $cycle_type);
    }

    echo json_encode($send);
?>
