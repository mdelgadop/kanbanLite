<?php
	include("../services/TaskService.php");

	$service = new TaskService();
	$myresponse = $service->createTask($_POST["ip"], $_POST['is'], $_POST['t'], $_POST['c'], $_POST['q'], $_POST['p']);

	echo json_encode($myresponse);
?>