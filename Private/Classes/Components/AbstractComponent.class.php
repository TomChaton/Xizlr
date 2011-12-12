<?php
/*
* @author Ken Odoki-Olam
*
*/

namespace Xizlr\Components;

abstract class AbstractComponent{
	var $strComponentId;
	
	public function LoadConfig($strComponentId){
		$this->strComponentId;
		echo $strComponentId;
	}
}
