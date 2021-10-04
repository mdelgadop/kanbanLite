<?php

include("../responses/response.php");
include("../responses/responseTask.php");
include("../responses/responseTasks.php");
include("../repositories/TaskRepository.php");

class TaskService {

   function __construct()
   {
	   
   }
   
   function getAll($projectId, $sprintId)
   {
		$myresponse = new responseTasks;
		$myresponse->tasks = array();
		$myresponse->numtasks=0;
		$myresponse->code = '500';
		$myresponse->message = "Server Error";
		
		if($projectId=="")
		{
			$myresponse->code = '501';
			$myresponse->message = "El proyecto no puede estar vacío";
		}
		else if($sprintId=="")
		{
			$myresponse->code = '502';
			$myresponse->message = "El sprint no puede estar vacío";
		}
		else
		{
			try {
				$repository = new TaskRepository();
				$tasksGotten = $repository->getAll($projectId, $sprintId);

				$myresponse->code = '200';
				$myresponse->message = "";
				$myresponse->tasks=$tasksGotten;
				$myresponse->numtasks=count($tasksGotten);
				
			} catch (Exception $e) {
				$myresponse->code = '401';
				$myresponse->message = "Excepción capturada: ".$e->getMessage().".";
				$myresponse->tasks = array();
				$myresponse->numtasks=0;
			}
		}
		
		return $myresponse;
	}
	
	function getTask($projectId, $sprintId, $taskId)
	{
		$myresponse = new responseTask;
		$myresponse->code = '500';
		$myresponse->message = "Server Error";
		
		if($projectId=="")
		{
			$myresponse->code = '501';
			$myresponse->message = "El proyecto no puede estar vacío";
		}
		else if($sprintId=="")
		{
			$myresponse->code = '502';
			$myresponse->message = "El sprint no puede estar vacío";
		}
		else if($taskId=="" or substr($taskId, 0, 4) != "task")
		{
			$myresponse->code = '503';
			$myresponse->message = "La tarea no puede estar vacía";
		}
		else
		{
			$taskId = substr($taskId, 4);
			
			try {
				$repository = new TaskRepository();
				$tasksGotten = $repository->getTask($projectId, $sprintId, $taskId);

				if(count($tasksGotten) != 1)
				{
					$myresponse->code = '201';
					$myresponse->message = "Not found";
				}
				else
				{
					$myresponse->code = '200';
					$myresponse->message = "";
					$myresponse->task=$tasksGotten[0];
				}
			} catch (Exception $e) {
				$myresponse->code = '401';
				$myresponse->message = "Excepción capturada: ".$e->getMessage().".";
				$myresponse->tasks = array();
				$myresponse->numtasks=0;
			}
		}
		
		return $myresponse;
	}
  
	function createTask($projectId, $sprintId, $title, $role, $request, $purpose)
	{
		$myresponse = new response;
		 
		if($projectId=="")
		{
			$myresponse->code = '501';
			$myresponse->message = "El proyecto no puede estar vacío";
		}
		else if($sprintId=="")
		{
			$myresponse->code = '502';
			$myresponse->message = "El sprint no puede estar vacío";
		}
		else if($title=='')
		{
			$myresponse->code = '503';
			$myresponse->message = 'El título no puede estar vacío';
		}
		else if($role=='')
		{
			$myresponse->code = '504';
			$myresponse->message = 'El role no puede estar vacío';
		}
		else if($request=='')
		{
			$myresponse->code = '505';
			$myresponse->message = 'La petición no puede estar vacía';
		}
		else if($purpose=='')
		{
			$myresponse->code = '506';
			$myresponse->message = 'La justificación no puede estar vacía';
		}
		else
		{
			try {
				$repository = new TaskRepository();
				$result = $repository->createTask($projectId, $sprintId, $title, $role, $request, $purpose);
				
				$myresponse->code = '200';
				$myresponse->message = '';
			} catch (Exception $e) {
				$myresponse->code = '401';
				$myresponse->message = "Excepción capturada: ".$e->getMessage()."";
			}
		}
		
		return $myresponse;
	}
	
	function deleteTask($projectId, $sprintId, $taskId)
	{
		$myresponse = new response;
		$myresponse->code = '500';
		$myresponse->message = "Server Error";
		
		if($projectId=="")
		{
			$myresponse->code = '501';
			$myresponse->message = "El proyecto no puede estar vacío";
		}
		else if($sprintId=="")
		{
			$myresponse->code = '502';
			$myresponse->message = "El sprint no puede estar vacío";
		}
		else if($taskId=="" or substr($taskId, 0, 4) != "task")
		{
			$myresponse->code = '503';
			$myresponse->message = "La tarea no puede estar vacía";
		}
		else
		{
			$taskId = substr($taskId, 4);
			
			try {
				$repository = new TaskRepository();
				$result = $repository->deleteTask($projectId, $sprintId, $taskId);
				
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
	
	function changeStatus($projectId, $sprintId, $taskId, $statusId)
	{
		$myresponse = new response;
		$myresponse->code = '500';
		$myresponse->message = "Server Error";
		
		if($projectId=="")
		{
			$myresponse->code = '501';
			$myresponse->message = "El proyecto no puede estar vacío";
		}
		else if($sprintId=="")
		{
			$myresponse->code = '502';
			$myresponse->message = "El sprint no puede estar vacío";
		}
		else if($taskId=="" or substr($taskId, 0, 4) != "task")
		{
			$myresponse->code = '503';
			$myresponse->message = "La tarea no puede estar vacía";
		}
		else if($statusId=="" or substr($statusId, 0, 6) != "status")
		{
			$myresponse->code = '504';
			$myresponse->message = "El estado no puede estar vacío";
		}
		else
		{
			$taskId = substr($taskId, 4);
			$statusId = substr($statusId, 6);
			
			try {
				$repository = new TaskRepository();
				$result = $repository->changeStatus($projectId, $sprintId, $taskId, $statusId);
				
				if($result)
				{
					$myresponse->code = '200';
					$myresponse->message = '';
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