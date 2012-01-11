<?php
/*
* @author Ken Odoki-Olam
*
*/

namespace Xizlr\Components;

abstract class AbstractComponent{
	protected $objComponentConfig;
	
	public function LoadConfig($strComponentId){
		$strClassName = get_class($this);
		$arrClassNameParts = explode('\\',$strClassName);
		$strConfigClassName = $arrClassNameParts[0].'\\Models\\Config\\ComponentConfig';
		$objComponentConfig = new $strConfigClassName;
		
		$strComponentHandle = end($arrClassNameParts);
		$objComponentConfig->Load($strComponentHandle, $strComponentId);	
		$this->objComponentConfig = $objComponentConfig;
	}
}
