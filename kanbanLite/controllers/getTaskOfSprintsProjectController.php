<?php
	include("../services/TaskService.php");

	$service = new TaskService();
	$myresponse = $service->getTask($_POST['ip'], $_POST['is'], $_POST['it']);

	echo json_encode($myresponse);
?>