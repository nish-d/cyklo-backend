<?php
    require("functions.php");
    
    $name = $_GET["name"];
    $college = $_GET["college"];
    $number = $_GET["number"];
    $email = $_GET["email"];
    $cycle_number = $_GET["cycle_number"];
    //  $lock_state = $_GET["lock_state"];
    //  $accepted = $_GET["accepted"];
    $cycle_type = $_GET["cycle_type"];

    //stand details
    $stand_name = "alpha";
    $type = ($cycle_type == 0) ? "stands_normal" : "stands_premium";

    // retreiving the data
    $sql_cycles = "SELECT cycles_available, cycles FROM ".$type." WHERE name=?";
    $data_cycles = query($sql_cycles, $stand_name)[0];
    $cycles_available = $data_cycles["cycles_available"];
    $cycles = $data_cycles["cycles"];


    // updating the respective cycle table
    if($cycles[$cycle_number - 1] == "9"){  // error handling
        $sql_stands = "UPDATE ".$type." SET cycles_available=?, cycles=? WHERE name=?";
        $cycles_available += 1;     //cycles_available is incremented by 1
        $cycles[$cycle_number - 1] = "1";  // 1 is the code for enable
        $data_cycles = query($sql_stands, $cycles_available, $cycles, $stand_name);    
    }

    echo "<SCRIPT> window.history.back() </SCRIPT>"
?>