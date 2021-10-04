<?php

	include("../services/ProjectService.php");

	$service = new ProjectService();
	$myresponse = $service->getAll();

	echo json_encode($myresponse);
?>