<?php
	include("../services/NoteService.php");

	$service = new NoteService();
	$myresponse = $service->getAll($_POST['ip'], $_POST['is'], $_POST['it']);

	echo json_encode($myresponse);
?>