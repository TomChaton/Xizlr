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
	
	public function RunEvent($strApplicationHandle,$strSection,$strComponentName,$strComponentId, $strEvent,$arrArguments){
		
		$objComponent = \Xizlr\Components\ComponentFactory::NewComponent($strApplicationHandle, $strSection, $strComponentName, $strComponentId);
		$intReturnCode = call_user_func_array(array($objComponent,'XiEvent_'.$strEvent),$arrArguments);
echo $intReturnCode;
exit;
		$objHTTPStatus = new \Xizlr\HTTP\Status($intReturnCode);
		header($objHTTPStatus->strHTTPVersion.' '.$objHTTPStatus->intHTTPCode.' '.$objHTTPStatus->strHTTPValue);
		
		if($intReturnCode == 200){
			$objView = $objComponent->GetGeneratedView();
			header('Content-Type: '.$objView->strMimeType.'; charset='.$objView->strCharacterSet);
			header('Content-Length: '.$objView->intContentLength);
			if($objView->CanVaryUserAgent()){
				header('Vary: User-Agent');	
			}
			if($objView->IsCacheable()){
				header("Expires: " . gmdate("D, d M Y H:i:s",time()+($objView->intCacheSeconds)) . " GMT");
				header("Cache-Control: ".($objView->bolUsePublicCache?'public':'private').", max-age=".$objView->intCacheSeconds);
			}
			echo $objView->GetContent();
		}else{
			echo " Error Running Event ".$strEvent;	
		}
	}
	
	public function RunMethod($strApplicationHandle,$strSection,$strControllerName,$strAction,$arrArguments){
		echo "HELLO TO THE WORLD METHOD";
	}
	
	public function Run(){
		
/*		$arrInvalidCharacters = self::GetInvalidCharacters();
		
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
	*/	
		//$objSession = \Xizlr\System\Session::GetInstance();
		//$intApplicationId  = \Xizlr\Models\Applications\Application::GetApplicationIdFromHandle($strApplication);
		
	}

}
