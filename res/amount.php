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

    $minutes -= 30; //For initial half hours, Rs. 10
    $parts = (int) ($minutes / 30);
    $overhead = $minutes % 30;

    $send["overhead"] = $overhead;

    if($overhead >= 5) {
        $parts++;
    }
    $send["amount"] = $parts * 5;//Rs. 5 per part [= half hour]
    echo json_encode($send);
?>
