<?php
include("../responses/responseProjects.php");
include("../responses/response.php");
include("../repositories/ProjectRepository.php");
	
class ProjectService {

   function __construct()
   {
	   
   }
   
   function getAll()
   {
		$myresponse = new responseProjects;
		$myresponse->projects = array();
		$myresponse->numprojects=0;
			
		try {
		
			$repository = new ProjectRepository();
			$projectsGotten = $repository->getAll();
			
			$myresponse->code = '200';
			$myresponse->message = '';
			$myresponse->numprojects=count($projectsGotten);
			$myresponse->projects = $projectsGotten;

		} catch (Exception $e) {
			$myresponse->code = '401';
			$myresponse->message = "Excepción capturada: ".$e->getMessage()."";
		}
		
		return $myresponse;
   }
   
   function createProject($projectName)
   {
		$myresponse = new response;

		if($projectName=='')
		{
			$myresponse->code = '500';
			$myresponse->message = 'El nombre no puede estar vacío';
		}
		else
		{
			$repository = new ProjectRepository();
			$result = $repository->createProject($projectName);

			$myresponse->code = '200';
			$myresponse->message = '';
		}
		
		return $myresponse;
   }

   function deleteProject($projectId)
   {
		$myresponse = new response;
		$myresponse->code = '500';
		$myresponse->message = "Server Error";

		if($projectId=="")
		{
		$myresponse->code = '501';
		$myresponse->message = "El proyecto no puede estar vacío";
		}
		else
		{
			try {
				$repository = new ProjectRepository();
				$result = $repository->deleteProject($projectId);
				if($result)
				{
					$myresponse->code = '200';
					$myresponse->message = $result;
				}
			} catch (Exception $e) {
				$myresponse->code = '401';
				$myresponse->message = "Excepción capturada: ".$e->getMessage().".";
			}
		}
		
		return $myresponse;
   }

   function changeTypeOfStatus($projectId, $statusId, $typeId)
   {
		$myresponse = new response;
		$myresponse->code = '500';
		$myresponse->message = "Server Error";

		if($projectId=="")
		{
		$myresponse->code = '501';
		$myresponse->message = "El proyecto no puede estar vacío";
		}
		
		else if($statusId=="" or substr($statusId, 0, 6) != "status")
		{
			$myresponse->code = '502';
			$myresponse->message = "El estado no puede estar vacío";
		}
		else if(!($typeId=="alert-primary" or $typeId=="alert-secondary" or $typeId=="alert-success" or $typeId=="alert-warning" or $typeId=="alert-danger"))
		{
			$myresponse->code = '503';
			$myresponse->message = "El nuevo tipo no está permitido";
		}
		else
		{
			$statusId = substr($statusId, 6);
			
			try {
				$repository = new ProjectRepository();
				$result = $repository->changeTypeOfStatus($projectId, $statusId, $typeId);
				if($result)
				{
					$myresponse->code = '200';
					$myresponse->message = $result;
				}
			} catch (Exception $e) {
				$myresponse->code = '401';
				$myresponse->message = "Excepción capturada: ".$e->getMessage().".";
			}

		}
		
		return $myresponse;
   }
   
   function deleteStatus($projectId, $statusId)
   {
		$myresponse = new response;
		$myresponse->code = '500';
		$myresponse->message = "Server Error";

		if($projectId=="")
		{
		$myresponse->code = '501';
		$myresponse->message = "El proyecto no puede estar vacío";
		}
		
		else if($statusId=="" or substr($statusId, 0, 6) != "status")
		{
			$myresponse->code = '502';
			$myresponse->message = "El estado no puede estar vacío";
		}
		else
		{
			$statusId = substr($statusId, 6);
			
			try {
				$repository = new ProjectRepository();
				$result = $repository->deleteStatus($projectId, $statusId);
				if($result)
				{
					$myresponse->code = '200';
					$myresponse->message = $result;
				}
			} catch (Exception $e) {
				$myresponse->code = '401';
				$myresponse->message = "Excepción capturada: ".$e->getMessage().".";
			}

		}
		
		return $myresponse;
   }
   
   function createStatus($projectId, $statusName)
   {
		$myresponse = new response;
		$myresponse->code = '500';
		$myresponse->message = "Server Error";

		if($projectId=="")
		{
		$myresponse->code = '501';
		$myresponse->message = "El proyecto no puede estar vacío";
		}
		
		else if($statusName=="")
		{
			$myresponse->code = '502';
			$myresponse->message = "El estado no puede estar vacío";
		}
		else
		{			
			try {
				$repository = new ProjectRepository();
				$result = $repository->createStatus($projectId, $statusName);
				if($result)
				{
					$myresponse->code = '200';
					$myresponse->message = $result;
				}
			} catch (Exception $e) {
				$myresponse->code = '401';
				$myresponse->message = "Excepción capturada: ".$e->getMessage().".";
			}

		}
		
		return $myresponse;
   }

}

?>