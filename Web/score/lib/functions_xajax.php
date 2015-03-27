<?php

require_once("lib/xajax/xajax.inc.php");
	
	function jalert()
	{ 
		$response = new xajaxResponse();
		$response->alert("SSSS");
		return $response;
	}
		
?>