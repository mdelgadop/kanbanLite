<?php
include("../entities/status.php");
include("GenericRepository.php");

class StatusRepository extends GenericRepository {

   private $_typesOfStatuses = array();
   
   function __construct()
   {
	   parent::__construct();
	   
	   $this->$_typesOfStatuses[0] = "alert-primary";
	   $this->$_typesOfStatuses[1] = "alert-secondary";
	   $this->$_typesOfStatuses[2] = "alert-success";
	   $this->$_typesOfStatuses[3] = "alert-warning";
	   $this->$_typesOfStatuses[4] = "alert-danger";
   }
   
   function getByProject($projectId)
   {
		//return
		$statusesGotten = array();
		$numstatuses = 0;

		{
			$db = new SQLite3('../db/projects.db');
			include("../db/init.php");

			//SELECT PROJECTS
			//$myquery = "SELECT id, name, type FROM statuses where project_id=".$projectId;
			
			$queryTypesOfStatuses = "";
			$numTypesOfStatuses = 0;
			while($numTypesOfStatuses < count($this->$_typesOfStatuses))
			{
				$queryTypesOfStatuses .= " when type='".$this->$_typesOfStatuses[$numTypesOfStatuses]."' then ".$numTypesOfStatuses." ";
				$numTypesOfStatuses++;
			}
			
			$queryTypesOfStatuses = "case ".$queryTypesOfStatuses." else ".$numTypesOfStatuses." end";;
			
			$myquery = "select * from (SELECT id, name, type, ".$queryTypesOfStatuses." as myorder FROM statuses where project_id=".$projectId.") mytable order by myorder asc, name asc";

			$res = $db->query($myquery);

			while ($row = $res->fetchArray()) {
				$current_status = new status;
				$current_status->id = "{$row['id']}";
				$current_status->publicid = "status{$row['id']}";
				$current_status->name = "{$row['name']}";
				$current_status->type = "{$row['type']}";
				$statusesGotten[$numstatuses] = $current_status;
				$numstatuses++;
			}
			
		}
		
		return $statusesGotten;
	}
	
	function changeTypeOfStatus($projectId, $statusId, $newTypeOfStatus)
	{

	}

}

?>