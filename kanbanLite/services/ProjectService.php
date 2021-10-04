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

}

?>