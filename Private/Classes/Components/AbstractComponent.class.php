<?php
/*
* @author Ken Odoki-Olam
*
*/

namespace Xizlr\Components;

abstract class AbstractComponent{
	private $strComponentId;
	private $strComponentHandle;
	
	abstract function LoadConfig($strComponentId);
	
	/* 
	TO DO: WORK OUT THE NAMESPACE AND THEN USE THAT TO LOAD THE CONFIG!!!
	*/
	
	/*public function LoadConfig($strComponentId){
		$this->strComponentHandle = get_class($this);
		$this->strComponentId     = $strComponentId;
		
	}*/
}
