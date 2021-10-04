<?php
	include("../services/SprintService.php");

	$service = new SprintService();
	$myresponse = $service->createSprint($_POST['i'], $_POST['n']);

	echo json_encode($myresponse);
?>