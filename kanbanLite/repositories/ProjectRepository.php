<?php

include("../entities/project.php");
include("GenericRepository.php");

class ProjectRepository extends GenericRepository {

   function __construct()
   {
	   parent::__construct();
   }
   
   function getAll()
   {
		//return
		$projectsGotten = array();
		$numprojects = 0;

		{
			$db = new SQLite3('../db/projects.db');
			include("../db/init.php");

			//SELECT PROJECTS
			$res = $db->query("SELECT id, name FROM projects");

			while ($row = $res->fetchArray()) {
				$current_project = new project;
				$current_project->id = "{$row['id']}";
				$current_project->name = $this->decode("{$row['name']}");
				$projectsGotten[$numprojects] = $current_project;
				$numprojects++;
			}
		}
		
		return $projectsGotten;
   }
   
   function createProject($projectName)
   {
		$db = new SQLite3('../db/projects.db');
		include("../db/init.php");

		$sentences = array();
		$sentences[0] = "INSERT INTO projects(name) VALUES (?)";
		$sentences[1] = "INSERT INTO statuses(name, type, project_id) values ('To do', 'alert-primary', (select max(id) from projects))";
		$sentences[2] = "INSERT INTO statuses(name, type, project_id) values ('In progress', 'alert-secondary', (select max(id) from projects))";
		$sentences[3] = "INSERT INTO statuses(name, type, project_id) values ('Testing', 'alert-secondary', (select max(id) from projects))";
		$sentences[4] = "INSERT INTO statuses(name, type, project_id) values ('Done', 'alert-success', (select max(id) from projects))";

		$i = 0;
		while($i < 5)
		{
			$stm = $db->prepare($sentences[$i]);
			$stm->bindParam(1, $newProjectName);
			
			$newProjectName = $this->encode($projectName);
			$stm->execute();
			
			$i++;
		}
   }

   function deleteProject($projectId)
   {
		$db = new SQLite3('../db/projects.db');
		include("../db/init.php");

		$myQuery = "delete from tasks ";
		$myQuery .= " and tasks.sprint_id in (select id from sprints where project_id=".$projectId.")";

		$result = $db->exec($myQuery);

		$myQuery = "delete from sprints where project_id=".$projectId."";

		$result = $db->exec($myQuery);

		$myQuery = "delete from statuses where project_id=".$projectId."";

		$result = $db->exec($myQuery);
		
		$myQuery = "delete from projects where id=".$projectId."";

		$result = $db->exec($myQuery);
		
		return $result;
   }

}

?>