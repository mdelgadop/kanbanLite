<?php
include("../entities/sprint.php");
include("GenericRepository.php");

class SprintRepository extends GenericRepository {

   function __construct()
   {
	   parent::__construct();
   }
   
   function getAll($projectId)
   {
		$sprintsGotten = array();
		$numsprints = 0;
		
		$db = new SQLite3('../db/projects.db');
		include("../db/init.php");

		//SELECT PROJECTS
		$res = $db->query("SELECT id, name FROM sprints where project_id=".$projectId);

		while ($row = $res->fetchArray()) {
			$current_sprint = new sprint;
			$current_sprint->id = "{$row['id']}";
			$current_sprint->name = $this->decode("{$row['name']}");
			$sprintsGotten[$numsprints] = $current_sprint;
			$numsprints++;
		}
		
		return $sprintsGotten;
   }
   
   function createSprint($projectId, $sprintName)
   {
		$db = new SQLite3('../db/projects.db');
		include("../db/init.php");

		$stm = $db->prepare("INSERT INTO sprints(name, project_id) VALUES (?, ?)");
		$stm->bindParam(1, $newSprintName);
		$stm->bindParam(2, $newProjectId);
		
		$newSprintName = $this->encode($sprintName);
		$newProjectId = $projectId;
		$stm->execute();

		$myresponse->code = '200';
		$myresponse->message = '';
   }
   
   function deleteSprint($projectId, $sprintId)
   {
		$db = new SQLite3('../db/projects.db');
		include("../db/init.php");

		$myQuery = "delete from tasks ";
		$myQuery .= " where tasks.sprint_id in (select id from sprints where id=".$sprintId." and project_id=".$projectId.")";

		$result = $db->exec($myQuery);

		if($result)
		{
			$myQuery = "delete from sprints where id=".$sprintId." and project_id=".$projectId."";
			$result = $db->exec($myQuery);
		}
		
		return $result;
   }
   
}
?>