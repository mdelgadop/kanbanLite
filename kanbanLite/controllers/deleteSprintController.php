<?php
	include("../services/SprintService.php");

	$service = new SprintService();
	$myresponse = $service->deleteSprint($_POST['ip'], $_POST['is']);

	echo json_encode($myresponse);
?>