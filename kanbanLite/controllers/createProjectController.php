<?php
	include("../services/ProjectService.php");

	$service = new ProjectService();
	$myresponse = $service->createProject($_POST['n']);

	echo json_encode($myresponse);
	
?>