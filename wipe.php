<?php
    require("res/functions.php");

    $sql = "UPDATE stands SET cycles_available=10, cycles='1111111111' WHERE 1";
    $data = query($sql);

    $sql = "DELETE FROM request WHERE 1";
    $data = query($sql);

    $sql = "DELETE FROM service WHERE 1";
    $data = query($sql);

    $sql = "ALTER TABLE request AUTO_INCREMENT = 1";
    $data = query($sql);

    $sql = "ALTER TABLE service AUTO_INCREMENT = 1";
    $data = query($sql);

    echo "true";
?>
