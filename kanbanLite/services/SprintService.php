<?php
	include("../responses/response.php");
	include("../responses/responseSprints.php");
	include("../repositories/SprintRepository.php");

class SprintService {

   function __construct()
   {
	   
   }
   
   function getAll($projectId)
   {
		$myresponse = new responseSprints;
		$myresponse->sprints = array();
		$myresponse->numsprints=0;

		if($projectId=="")
		{
			$myresponse->code = '501';
			$myresponse->message = "El proyecto no puede estar vacío";
		}
		else
		{
			try {
				$repository = new SprintRepository();
				$sprintsGotten = $repository->getAll($projectId);

				$myresponse->code = '200';
				$myresponse->message = '';
				$myresponse->sprints = $sprintsGotten;
				$myresponse->numsprints=count($sprintsGotten);
				
			} catch (Exception $e) {
				$myresponse->code = '401';
				$myresponse->message = "Excepción capturada: ".$e->getMessage()."";
			}
		}
		
		return $myresponse;
   }
   
   function createSprint($projectId, $sprintName)
   {
		$myresponse = new response;
		 
		if($sprintName=='')
		{
			$myresponse->code = '501';
			$myresponse->message = 'El nombre no puede estar vacío';
		}
		else if($projectId=='')
		{
			$myresponse->code = '502';
			$myresponse->message = 'El proyecto no puede estar vacío';
		}
		else
		{
			$repository = new SprintRepository();
			$result = $repository->createSprint($projectId, $sprintName);

			$myresponse->code = '200';
			$myresponse->message = '';
		}
		
		return $myresponse;
   }
   
   function deleteSprint($projectId, $sprintId)
   {
		$myresponseTask = new response;
		$myresponseTask->code = '500';
		$myresponseTask->message = "Server Error";
		
		if($projectId=="")
		{
			$myresponseTask->code = '501';
			$myresponseTask->message = "El proyecto no puede estar vacío";
		}
		else if($sprintId=="")
		{
			$myresponseTask->code = '502';
			$myresponseTask->message = "El sprint no puede estar vacío";
		}
		else
		{
			try {
				$repository = new SprintRepository();
				$result = $repository->deleteSprint($projectId, $sprintId);

				if($result)
				{
					$myresponseTask->code = '200';
					$myresponseTask->message = $result;
				}
			} catch (Exception $e) {
				$myresponseTask->code = '401';
				$myresponseTask->message = "Excepción capturada: ".$e->getMessage().".";
			}
		}
		
		return $myresponseTask;
   }
   
}
?>