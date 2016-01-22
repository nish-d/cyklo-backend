<?php
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');

    require("res/functions.php");

    /*
    lock_state(0) = unlock request
    lock_state(1) = lock request
    */

    $sql = "SELECT * FROM REQUEST WHERE request_done=0";
    $data = query($sql);
    foreach ($data as $data_sub) {
        //send unlock request
        if ($data_sub["lock_state"] == 0) {
            echo "event: request_unlock\n";
            $json = json_encode($data_sub);
            echo "data: {$json}\n\n";
            $request_done = "UPDATE request SET request_done=1 WHERE number=?";
            query($request_done, $data_sub["number"]);
        }

        //send lock request
        else {
            echo "event: request_lock\n";
            $json = json_encode($data_sub);
            echo "data: {$json}\n\n";
            $request_done = "UPDATE request SET request_done=1 WHERE number=?";
            query($request_done, $data_sub["number"]);
        }
    }
    echo "\n";
?>
