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
	
	public function GetControllerPath($strApplication, $strSection, $strController){
		$objXilzrConfig        = \Xizlr\Models\Config::GetInstance('Xizlr');
		$objApplicationConfig  = \Xizlr\Models\Config::GetInstance($strApplication);
		
		$strControllerPath =  $objApplicationConfig->arrEnvironment['strBaseDir'].'/Private/Classes/Controllers/'.$strSection.'/'.$strController.'.class.php';
		if(is_file($strControllerPath)){
			return $strControllerPath;
		}
		
		$strControllerPath =  $objXilzrConfig->arrEnvironment['strBaseDir'].'/Private/Classes/Controllers/'.$strSection.'/'.$strController.'.class.php';			
		if(is_file($strControllerPath)){
			return $strControllerPath;
		}			
	}	
	
	public function Run($strApplication){
		
		$arrInvalidCharacters = self::GetInvalidCharacters();
	
		$strSreen       = str_replace($arrInvalidCharacters,'',$_GET['Sreen']);
		$strContext     = str_replace($arrInvalidCharacters,'',$_GET['Context']);
		$streSection    = str_replace($arrInvalidCharacters,'',$_GET['Section']);
		$strController    = str_replace($arrInvalidCharacters,'',$_GET['Controller']);
		$strAction      = str_replace($arrInvalidCharacters,'',$_GET['Action']);
		$arrArguments   = explode('/',$_GET['Arguments']);
		
		if(!$strApplication){
			echo "This web application is misconfigured, please contact your administrator in order to fix it";
			\Xizlr\System\Log::LogError('You need to set up the global variable $strApplication in the application\'s conf file');
			exit;
		}
		$strFunctionPrefix = 'HTTPAction';
		$strFunction    = $strFunctionPrefix.$strAction;
		$strHTTPVersion = 'HTTP/1.1';
		if(!isset($strContext)){
			$strContext = 'HTML';
		}
		
		$strControllerPath = $this->GetControllerPath($strApplication, $strSection, $strController);
		
		if(!$strControllerPath){
			header($strHTTPVersion.' 404 Not Found');
			echo "File Not Found";
			exit;
		}
		
		$objSession = \Xizlr\System\Session::GetInstance();
		$intApplicationId  = \Xizlr\Models\Applications\Application::GetApplicationIdFromHandle($strApplication);
		
	}

}
