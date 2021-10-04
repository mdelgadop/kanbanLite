<?php
	include("../services/SprintService.php");

	$service = new SprintService();
	$myresponse = $service->getAll($_POST['i']);

	echo json_encode($myresponse);
?>