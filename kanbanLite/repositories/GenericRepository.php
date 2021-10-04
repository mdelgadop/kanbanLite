<?php

class GenericRepository {

   function __construct()
   {
	   
   }
   
   function encode($stringToEncode)
   {
		$stringEncoded = str_replace(" ","&nbsp;",$stringToEncode);
		
		return $stringEncoded;
   }

   function decode($stringEncoded)
   {
		$stringToEncode = str_replace("&nbsp;"," ",$stringEncoded);
		
		return $stringToEncode;
   }
	
}

?>