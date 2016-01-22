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


    //stands data
    $stand_name = "alpha";

    $sql_stands = "SELECT * FROM stands WHERE name=?";
    $data_stands = query($sql_stands, $stand_name)[0];

    $send = array("name" => $data_stands["name"],
                "cycle_strength" => $data_stands["cycle_strength"],
                "cycles_available" => $data_stands["cycles_available"],
                "cycles" => $data_stands["cycles"],
                "error" => 0 /* default no error*/ );

    $cycles = $send["cycles"];
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
        }

        $send["cycle_number"] = $cycle_number;

        $sql_request = "INSERT INTO request (name, college, number, email, request_done, lock_state, cycle_number) VALUES (?,?,?,?,?,?,?)";
        $data_request = query($sql_request, $name, $college, $number, $email, 0, $lock_state, $cycle_number);
    }

    echo json_encode($send);
?>
