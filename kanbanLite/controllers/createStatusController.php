<?php
	include("../services/ProjectService.php");

	$projectId = $_POST["ip"];
	$statusName = $_POST["st"];
	
	$service = new ProjectService();
	$myresponse = $service->createStatus($projectId, $statusName);

	echo json_encode($myresponse);
	
?>