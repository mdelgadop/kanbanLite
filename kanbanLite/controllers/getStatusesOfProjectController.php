<?php

	include("../services/StatusService.php");

	$projectId = $_POST["i"]=="" ? $_GET["i"] : $_POST["i"];
	
	$service = new StatusService();
	$myresponse = $service->getByProject($projectId);

	echo json_encode($myresponse);
?>
