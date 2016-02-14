<?php
    require("functions.php");

    $name = $_GET["name"];
    $college = $_GET["college"];
    $number = $_GET["number"];
    $email = $_GET["email"];


    $sql_service = "SELECT start FROM service WHERE name=? AND college=? AND number=? AND email=? AND ongoing=1";
    $data_service = query($sql_service, $name, $college, $number, $email)[0];

    $start = new DateTime($data_service["start"], new DateTimeZone('Asia/Kolkata'));
    $end = new DateTime(NULL, new DateTimeZone('Asia/Kolkata'));
    $diff = $end->diff($start);//end - start

    $minutes = intval($diff->format("%i")) + (60 * intval($diff->format("%H")));//total minutes

    $send = array("minutes" => $minutes);

    $parts = (int) ($minutes / 15);
    $amount = ($parts * 5) + 5;//Rs. 5 per part [= 15 mins] + 5 (for first 15 mins)

    $send["amount"] =$amount;
    echo json_encode($send);
?>
