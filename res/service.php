<?php

    /*
    lock_state(0) = unlock request
    lock_state(1) = lock request
    */
    require("functions.php");

    $name = $_GET["name"];
    $college = $_GET["college"];
    $number = $_GET["number"];
    $email = $_GET["email"];
    $cycle_number = $_GET["cycle_number"];
    $lock_state = $_GET["lock_state"];
    $accepted = $_GET["accepted"];

    $stand_name = "alpha";
    $sql_cycles = "SELECT cycles_available, cycles FROM stands WHERE name=?";
    $data_cycles = query($sql_cycles, $stand_name)[0];
    $cycles_available = $data_cycles["cycles_available"];
    $cycles = $data_cycles["cycles"];

    if($accepted == -1) {
        $sql_request = "UPDATE request SET accepted=-1 WHERE name=? AND college=? AND number=? AND email=? AND lock_state=? AND accepted=0";
        $data_request = query($sql_request, $name, $college, $number, $email, $lock_state);

        $sql_stands = "UPDATE stands SET cycles_available=?, cycles=? WHERE name=?";
        $cycles_available += 1;
        $cycles[$cycle_number - 1] = "1";
        $data_cycles = query($sql_stands, $cycles_available, $cycles, $stand_name);

    }

    //If accepted
    else {

    $sql_request = "UPDATE request SET accepted=1 WHERE name=? AND college=? AND number=? AND email=? AND lock_state=? AND accepted=0";
    $data_request = query($sql_request, $name, $college, $number, $email, $lock_state);

    $error = 0;

    $time = new DateTime(NULL, new DateTimeZone('Asia/Kolkata'));
    $send = array("time" => $time->format("Y-m-d H:i:s"), "error" => $error);

    //unlocking service
    if($cycles_available != 0 && $lock_state == 0) {
        $start = $time;//this time is start time

        $sql_service = "INSERT INTO service (name, college, number, email, start, ongoing, cycle_number) VALUES (?,?,?,?,?,1,?)";
        $data_service = query($sql_service, $name, $college, $number, $email, $start->format("Y-m-d H:i:s"), $cycle_number);

        $send["error"] = ($data_service || $data_stands)? 1: 0;//if either are NULL
    }

    //locking service
    elseif ($lock_state == 1) {
        $end = $time;//this time is end time

        $sql_service = "UPDATE service SET end=?, ongoing=0 WHERE name=? AND college=? AND number=? AND email=?";
        $data_service = query($sql_service, $end->format("Y-m-d H:i:s"), $name, $college, $number, $email);

        $cycles[$cycle_number - 1] = "1";
        $sql_stands = "UPDATE stands SET cycles_available=?, cycles=? WHERE name=?";
        $data_stands = query($sql_stands, $cycles_available + 1, $cycles, $stand_name);

        $send["error"] = ($data_service || $data_stands)? 1: 0;//if data is NULL or false
    }

    $send["cycles"] = $cycles;
    echo json_encode($send);
    }
?>
