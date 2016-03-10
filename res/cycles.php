<?php
	//Displays the cycles String from database
	
	require("functions.php");
	$stand_name = "alpha"; //Take as input when going multiple stands

	$sql_stands = "SELECT cycles FROM stands WHERE name=?";
	$data_stands = query($sql_stands, $stand_name);

	echo $data_stands[0]["cycles"];
?>
