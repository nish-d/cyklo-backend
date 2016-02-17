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
    $lock_state = (isset($_GET["lock_state"]))? $_GET["lock_state"]: NULL;

    $sql_request = "SELECT * FROM request WHERE name=? AND college=? AND number=? AND email=? AND lock_state=?";
    //echo $sql_request;
    $data_request = query($sql_request, $name, $college, $number, $email, $lock_state);
    $latest = $data_request[count($data_request) - 1];

    //var_dump($data_request);

    $send = array("accepted" => $latest["accepted"]);

    if($send["accepted"] == 1) {
        $sql_service = "SELECT start,end FROM service WHERE name=? AND college=? AND number=? AND email=?";
        $data_service = query($sql_service, $name, $college, $number, $email);
        $send["start"] = $data_service[count($data_service) - 1]["start"];
        $send["end"] = $data_service[count($data_service) - 1]["end"];
    }

    echo json_encode($send);
?>
