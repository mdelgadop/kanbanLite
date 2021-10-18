<?php
include("../entities/task.php");
include("GenericRepository.php");

class TaskRepository extends GenericRepository {

   function __construct()
   {
	   parent::__construct();
   }
   
   function getAll($projectId, $sprintId)
   {
		$tasksGotten = array();
		$numtasks = 0;
		
		$db = new SQLite3('../db/projects.db');
		include("../db/init.php");

		//SELECT PROJECTS
		$res = $db->query("SELECT tasks.id as id, title, request, status_id FROM tasks where tasks.sprint_id=".$sprintId." and tasks.sprint_id in (select id from sprints where project_id=".$projectId.")");

		while ($row = $res->fetchArray()) {
			$current_task = new task;
			$current_task->id = "{$row['id']}";
			$current_task->publicid = "task{$row['id']}";
			$current_task->title = $this->decode("{$row['title']}");
			$current_task->request = $this->decode("{$row['request']}");
			$current_task->status = "{$row['status_id']}";
			$tasksGotten[$numtasks] = $current_task;
			$numtasks++;
		}
		
		return $tasksGotten;
	}
  
   function getTask($projectId, $sprintId, $taskId)
   {
		$tasksGotten = array();
		$numtasks = 0;
		
		$db = new SQLite3('../db/projects.db');
		include("../db/init.php");

		//SELECT PROJECTS
		$myQuery = "SELECT id, title, role, request, purpose, status_id from tasks ";
		$myQuery .= " where tasks.id=".$taskId." ";
		$myQuery .= " and tasks.sprint_id=".$sprintId." ";
		$myQuery .= " and tasks.sprint_id in (select id from sprints where project_id=".$projectId.")";
		
		$res = $db->query($myQuery);

		while ($row = $res->fetchArray()) {
			$current_task = new task;
			$current_task->id = "{$row['id']}";
			$current_task->publicid = "task{$row['id']}";
			$current_task->title = $this->decode("{$row['title']}");
			$current_task->request = $this->decode("{$row['request']}");
			$current_task->role = $this->decode("{$row['role']}");
			$current_task->purpose = $this->decode("{$row['purpose']}");
			$current_task->status = "{$row['status_id']}";
			
			$current_task->notes = array();
			
			$tasksGotten[$numtasks] = $current_task;
			$numtasks++;
		}
		
		return $tasksGotten;
	}
	
	function createTask($projectId, $sprintId, $title, $role, $request, $purpose)
	{
		$db = new SQLite3('../db/projects.db');
		include("../db/init.php");

		$stm = $db->prepare("INSERT INTO tasks(title, role, request, purpose, sprint_id, status_id) VALUES (?, ?, ?, ?, ?, (select min(id) from statuses where project_id=".$projectId."))");
		$stm->bindParam(1, $newTitle);
		$stm->bindParam(2, $newRole);
		$stm->bindParam(3, $newRequest);
		$stm->bindParam(4, $newPurpose);
		$stm->bindParam(5, $sprint_id);
		
		$newTitle = $this->encode($title);
		$newRole = $this->encode($role);
		$newRequest = $this->encode($request);
		$newPurpose = $this->encode($purpose);
		$sprint_id = $sprintId;
		$project_id = $projectId;
		$stm->execute();
	}
	
	function deleteTask($projectId, $sprintId, $taskId)
	{
		$db = new SQLite3('../db/projects.db');
		include("../db/init.php");

		//SELECT PROJECTS
		$myQuery = "delete from tasks ";
		$myQuery .= " where tasks.id=".$taskId." ";
		$myQuery .= " and tasks.sprint_id=".$sprintId." ";
		$myQuery .= " and tasks.sprint_id in (select id from sprints where project_id=".$projectId.")";

		$result = $db->exec($myQuery);
		
		return $result;
	}
	
	function changeStatus($projectId, $sprintId, $taskId, $statusId)
	{
		$db = new SQLite3('../db/projects.db');
		include("../db/init.php");

		//SELECT PROJECTS
		$myQuery = "update tasks set status_id=".$statusId." ";
		$myQuery .= "where tasks.id=".$taskId." ";
		$myQuery .= " and tasks.sprint_id=".$sprintId." ";
		$myQuery .= " and tasks.sprint_id in (select id from sprints where project_id=".$projectId.")";
		$myQuery .= " and ".$statusId." in (select id from statuses where project_id=".$projectId.")";
		
		$result = $db->exec($myQuery);
		
		return $result;
	}
	
}

?>