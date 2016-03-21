<?php
    require("functions.php");

    $name = $_GET["name"];
    $college = $_GET["college"];
    $number = $_GET["number"];
    $email = $_GET["email"];
    $cycle_type = $_GET["cycle_type"];


    $sql_service = "SELECT start FROM service WHERE name=? AND college=? AND number=? AND email=? AND ongoing=1";
    $data_service = query($sql_service, $name, $college, $number, $email)[0];

    $start = new DateTime($data_service["start"], new DateTimeZone('Asia/Kolkata'));
    $end = new DateTime(NULL, new DateTimeZone('Asia/Kolkata'));
    $diff = $end->diff($start);//end - start

    $minutes = intval($diff->format("%i")) + (60 * intval($diff->format("%H")));//total minutes

    $send = array("minutes" => $minutes);

    //rate card
    //normal(0)    |    Rs. 10 per 30 mins
    //premium(1)   |    Rs. 20 per 30 mins
    $rate = ($cycle_type == 0) ? 10 : 20;

    $parts = (int) ($minutes / 30);
    $amount = ($parts * $rate) + $rate;

    $send["amount"] =$amount;
    echo json_encode($send);
?>
