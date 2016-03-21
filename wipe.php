<?php
    require("res/functions.php");

    $sql = "UPDATE stands_normal SET cycle_strength=5, cycles_available=5, cycles='11111' WHERE 1";
    $data = query($sql);

    $sql = "UPDATE stands_premium SET cycle_strength=2, cycles_available=2, cycles='11' WHERE 1";
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
