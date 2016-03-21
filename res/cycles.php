<?php
	//Displays the cycles String from database

	require("functions.php");
	$stand_name = "alpha"; //Take as input when going multiple stands

	$sql_stands = "SELECT cycles FROM stands_normal WHERE name=?";
	$data_stands = query($sql_stands, $stand_name)[0];
	echo $data_stands["cycles"];

	$sql_stands = "SELECT cycles FROM stands_premium WHERE name=?";
	$data_stands = query($sql_stands, $stand_name)[0];
	echo $data_stands["cycles"];
?>
