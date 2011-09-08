<?php

/*
* @author Ken Odoki-Olam
*
*/

namespace \Xizlr\Controllers

abstract class Base{

	abstract public function GenerateData($arrArguments);
		
	//This is the data that gets generated and passed onto the view
	protected $arrData    = array();

	// This lets us know wich contexts we can call on this resource
	// e.g HTML,XML,JSON,CSV
	protected $arrAllowedContexts = array();
	
	public function ContextAllowed($strContext){
		return $this->arrAllowedContexts[$strContext];
	}
	
	

	
	
}

?>
