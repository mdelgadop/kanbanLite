<?php
	include("../services/ProjectService.php");

	$service = new ProjectService();
	$myresponse = $service->deleteProject($_POST['ip']);

	echo json_encode($myresponse);
?>