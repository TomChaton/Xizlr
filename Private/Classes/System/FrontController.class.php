<?php
/*
* @author Ken Odoki-Olam
*
*/

namespace Xizlr\System;

class FrontController{
	
	public static function GetInvalidCharacters(){
		$arrInvalidCharacters = array('.','\\',',',')','(','"','\'',';','$','*','/');
		return $arrInvalidCharacters;
	}
	
	private function ActionTypeAllowed($strActionType){
		$srrAllowedActionTypes = array('Event','Method');
		return in_array($strActionType,$srrAllowedActionTypes);
	}
	
	public function Run(){
		
		$arrInvalidCharacters = self::GetInvalidCharacters();
		
		$strActionType	= str_replace($arrInvalidCharacters,'',$_GET['ActionType']);
		$strApplication = str_replace($arrInvalidCharacters,'',$_GET['Application']);
		$strSection     = str_replace($arrInvalidCharacters,'',$_GET['Section']);
		$strController  = str_replace($arrInvalidCharacters,'',$_GET['Controller']);
		$strAction      = str_replace($arrInvalidCharacters,'',$_GET['Action']);
		$arrArguments   = explode('/',$_GET['Arguments']);
		
		$strClassName = '\\'.$strApplication.'\\Controllers\\'.$strSection.'\\'.$strController;	
		$objController = new $strClassName;
		$strFunction = $strActionType.'_'.$strAction;
		
		if(!$this->ActionTypeAllowed($strActionType)){
			throw new Exception('Uknown Action type');
		}
		
		if($strActionType == 'Event'){
			$objResource = new \Xizlr\Models\Resources\ResourceFactory::GetResource($_GET['ResourceId']);
			array_unshift($objResource,$arrArguments);
		}
		
		if(is_callable(array($objController, $strFunction))){
				call_user_func_array(array($objController,$strFunction), $arrArguments);
		}else{
			throw new Exception('Cannot call that function');
		}
		
		//$objSession = \Xizlr\System\Session::GetInstance();
		//$intApplicationId  = \Xizlr\Models\Applications\Application::GetApplicationIdFromHandle($strApplication);
		
	}

}
