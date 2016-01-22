<?php
    require("functions.php");

    $stand_name = (isset($_GET["stand_name"]))? $_GET["stand_name"]: "alpha";

    $sql_stand = "SELECT * FROM stands WHERE name=?";
    $data_stand = query($sql_stand, $stand_name)[0];

    echo json_encode($data_stand);
?>
