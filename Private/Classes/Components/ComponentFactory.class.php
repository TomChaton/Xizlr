<?php
/*
* @author Ken Lalobo
*
*/

namespace Xizlr\Components;

abstract class ComponentFactory{
	
	public function NewComponent($strApplicationHandle,$strSection, $strComponentHandle, $strComponentId){
		$strBaseName = '\\Components\\'.$strSection.'\\'.$strComponentHandle;
		
		$strApplicationClassName = $strApplicationHandle.$strBaseName;
		$strXizlrClassName       = 'Xizlr'.$strBaseName;
		
		if(\Xizlr\System\Autoloader::ClassExists($strApplicationClassName)){
			$objComponent = new $strApplicationClassName;
			\Xizlr\System\Logger::Log('debug','xizlr','Instantiate object '.$strApplicationClassName);
		}elseif(\Xizlr\System\Autoloader::ClassExists($strXizlrClassName)){
			$objComponent = new $strXizlrClassName;
			\Xizlr\System\Logger::Log('debug','xizlr','Instantiate object '.$strXizlrClassName);
		}else{
			throw new \Exception("Cannot instantiate class");
		}
		
		$objComponent->LoadConfig($strComponentId);
		return $objComponent;
	}
	
}
