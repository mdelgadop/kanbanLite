<?php
include("../entities/note.php");
include("GenericRepository.php");

class NoteRepository extends GenericRepository {

   function __construct()
   {
	   parent::__construct();
   }
   
   function getAll($projectId, $sprintId, $taskId)
   {
		$notesGotten = array();
		$numnotes = 0;
		
		$db = new SQLite3('../db/projects.db');
		include("../db/init.php");

		//SELECT PROJECTS
		$myquery = "select id, note from notes where task_id in ( ";
		$myquery .= "SELECT id FROM tasks where id=".$taskId." and tasks.sprint_id=".$sprintId." and tasks.sprint_id in (select id from sprints where project_id=".$projectId.")";
		$myquery .= ") order by 1 desc";
		$res = $db->query($myquery);

		while ($row = $res->fetchArray()) {
			$current_note = new note;
			//$current_note->id = "{$row['id']}";
			$current_note->note = $this->decode("{$row['note']}");
			//$current_note->task_id = "{$row['task_id']}";
			$notesGotten[$numnotes] = $current_note;
			$numnotes++;
		}

		return $notesGotten;
	}
  
	function createNote($projectId, $sprintId, $taskId, $note)
	{
		$db = new SQLite3('../db/projects.db');
		include("../db/init.php");

		$stm = $db->prepare("INSERT INTO notes(note, task_id) VALUES (? ,(SELECT max(id) FROM tasks where id=".$taskId." and tasks.sprint_id=".$sprintId." and tasks.sprint_id in (select id from sprints where project_id=".$projectId.")))");
		$stm->bindParam(1, $newNote);
		
		$newNote = $this->encode($note);

		$stm->execute();
	}
	
	function deleteNote($projectId, $sprintId, $taskId, $noteId)
	{
		$db = new SQLite3('../db/projects.db');
		include("../db/init.php");

		//SELECT PROJECTS
		$myQuery = "delete from notes ";
		$myQuery .= " where id = ".$noteId." ";
		$myQuery .= " and task_id in  ";
		$myQuery .= " (SELECT max(id) FROM tasks where id=".$taskId." and tasks.sprint_id=".$sprintId." and tasks.sprint_id in (select id from sprints where project_id=".$projectId.")) ";

		$result = $db->exec($myQuery);
		
		return $result;
	}
	
}

?>