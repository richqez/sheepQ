<?php 
	
	require 'lib/DB.php';

	$data = DB::getConn()->find_by('employee',array("emp_id"=>"E0001"),true);

	var_dump($data);
 ?>