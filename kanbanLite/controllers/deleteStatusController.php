<?php
	include("../services/ProjectService.php");

	$projectId = $_POST["ip"];
	$statusId = $_POST["st"];
	
	$service = new ProjectService();
	$myresponse = $service->deleteStatus($projectId, $statusId);

	echo json_encode($myresponse);
?>