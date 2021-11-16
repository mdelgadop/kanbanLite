<?php
	include("../services/ProjectService.php");

	$projectId = $_POST["ip"];
	$statusId = $_POST["st"];
	$typeId = $_POST["ty"];
	
	$service = new ProjectService();
	$myresponse = $service->changeTypeOfStatus($projectId, $statusId, $typeId);

	echo json_encode($myresponse);
?>