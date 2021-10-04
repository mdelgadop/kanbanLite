<?php
	include("../services/TaskService.php");

	$projectId = $_POST["ip"];
	$sprintId = $_POST["is"];
	$taskId = $_POST["it"];
	$statusId = $_POST["ie"];
	
	$service = new TaskService();
	$myresponse = $service->changeStatus($projectId, $sprintId, $taskId, $statusId);

	echo json_encode($myresponse);
?>