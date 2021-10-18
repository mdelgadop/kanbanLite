<?php
	include("../services/NoteService.php");

	$service = new NoteService();
	$myresponse = $service->createNote($_POST["ip"], $_POST['is'], $_POST['it'], $_POST['n']);

	echo json_encode($myresponse);
?>