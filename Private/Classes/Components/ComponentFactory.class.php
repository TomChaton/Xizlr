<?php
/*
* @author Ken Lalobo
*
*/

namespace Xizlr\Components;

abstract class ComponentFactory{
	
	public function NewComponent($strApplicationHandle,$strSection, $strComponentName, $strComponentId){
		$strBaseName = '\\Components\\'.$strSection.'\\'.$strComponentName;
		
		$strApplicationClassName = $strApplicationHandle.$strBaseName;
		$strXizlrClassName       = 'Xizlr'.$strBaseName;
		
		if(\Xizlr\System\Autoloader::ClassExists($strApplicationClassName)){
			$objComponent = new $strXizlrClassName;
			echo "YAY!";
		}elseif(\Xizlr\System\Autoloader::ClassExists($strXizlrClassName)){
			$objComponent = new $strXizlrClassName;
			echo "YO!!";
		}else{
			throw new \Exception("Cannot run that event");
		}
		
		//$objComponentConfig = new $strApplicationHandle.'\\Components\
		$objComponent->LoadConfig($strComponentId);
		return $objComponent;
	}
	
	public function GetConfig(){
	}
	
}
