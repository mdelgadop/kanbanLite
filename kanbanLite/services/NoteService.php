<?php

include("../responses/response.php");
include("../responses/responseNotes.php");
include("../repositories/NoteRepository.php");

class NoteService {

   function __construct()
   {
	   
   }
   
   function getAll($projectId, $sprintId, $taskId)
   {
		$myresponse = new responseNotes;
		$myresponse->notes = array();
		$myresponse->numnotes=0;
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
			try {
				$taskId = substr($taskId, 4);
				
				$repository = new NoteRepository();
				$notesGotten = $repository->getAll($projectId, $sprintId, $taskId);

				$myresponse->code = '200';
				$myresponse->message = "";
				$myresponse->notes=$notesGotten;
				$myresponse->numnotes=count($myresponse->notes);
				
			} catch (Exception $e) {
				$myresponse->code = '401';
				$myresponse->message = "Excepción capturada: ".$e->getMessage().".";
				$myresponse->notes = array();
				$myresponse->numnotes=0;
			}
		}
		
		return $myresponse;
	}
  
	function createNote($projectId, $sprintId, $taskId, $note)
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
		else if($taskId=="" or substr($taskId, 0, 4) != "task")
		{
			$myresponse->code = '503';
			$myresponse->message = "La tarea no puede estar vacía";
		}
		else if($note=='')
		{
			$myresponse->code = '504';
			$myresponse->message = "El texto no puede estar vacío";
		}
		else
		{
			try {
				$taskId = substr($taskId, 4);
				
				$repository = new NoteRepository();
				$result = $repository->createNote($projectId, $sprintId, $taskId, $note);
				
				$myresponse->code = '200';
				$myresponse->message = '';
			} catch (Exception $e) {
				$myresponse->code = '401';
				$myresponse->message = "Excepción capturada: ".$e->getMessage()."";
			}
		}
		
		return $myresponse;
	}
	
	function deleteTask($projectId, $sprintId, $taskId, $noteId)
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
		else if($noteId=="")
		{
			$myresponse->code = '504';
			$myresponse->message = "La tarea no puede estar vacía";
		}
		else
		{
			$taskId = substr($taskId, 4);
			
			try {
				$repository = new NoteRepository();
				$result = $repository->deleteNote($projectId, $sprintId, $taskId, $noteId);
				
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