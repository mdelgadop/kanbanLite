<?php
	include("../services/TaskService.php");

	$service = new TaskService();
	$myresponse = $service->getAll($_POST['ip'], $_POST['is']);

	echo json_encode($myresponse);
?>