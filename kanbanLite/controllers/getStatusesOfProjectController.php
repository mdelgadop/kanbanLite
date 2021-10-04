<?php
	include("../entities/status.php");
	include("../responses/responseStatuses.php");

	$myresponse = new responseStatuses;
	$myresponse->statuses = array();
	$myresponse->numstatuses=0;
	
	$project_id = $_POST["i"]=="" ? $_GET["i"] : $_POST["i"];
	//$project_id = $_GET["i"];
	
	if($project_id=="")
	{
		$myresponse->code = '501';
		$myresponse->message = "El proyecto no puede estar vacío";
	}
	else
	{
		try {
			$db = new SQLite3('../db/projects.db');
			include("../db/init.php");

			//SELECT PROJECTS
			$res = $db->query("SELECT id, name, type FROM statuses where project_id=".$project_id);

			$i=0;
			while ($row = $res->fetchArray()) {
				$current_status = new status;
				$current_status->id = "{$row['id']}";
				$current_status->publicid = "status{$row['id']}";
				$current_status->name = "{$row['name']}";
				$current_status->type = "{$row['type']}";
				$myresponse->statuses[$current_status->id] = $current_status;
				$i++;
			}

			$myresponse->code = '200';
			$myresponse->message = '';
			$myresponse->numstatuses=$i;
			
		} catch (Exception $e) {
			$myresponse->code = '401';
			$myresponse->message = "Excepción capturada: ".$e->getMessage()."";
		}
	}
	
	echo json_encode($myresponse);
?>