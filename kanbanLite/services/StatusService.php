<?php
include("../responses/responseStatuses.php");
include("../repositories/StatusRepository.php");

class StatusService {

   function __construct()
   {
	   
   }
   
   function getByProject($projectId)
   {
		$myresponse = new responseStatuses;
		$myresponse->statuses = array();
		$myresponse->numstatuses=0;
		$myresponse->code = '500';
		$myresponse->message = "Server Error";
		
		try {
		
			if($projectId=="")
			{
				$myresponse->code = '501';
				$myresponse->message = "El proyecto no puede estar vacío";
			}
			else
			{
				$repository = new StatusRepository();
				$statusesGotten = $repository->getByProject($projectId);
				
				$myresponse->code = '200';
				$myresponse->message = '';
				$myresponse->numstatuses=count($statusesGotten);
				$myresponse->statuses = $statusesGotten;
			}

		} catch (Exception $e) {
			$myresponse->code = '401';
			$myresponse->message = "Excepción capturada: ".$e->getMessage()."";
		}
		
		return $myresponse;
	}
	
	
}

?>