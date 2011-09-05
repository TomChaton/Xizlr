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
		
	public function Run(){
		
		$arrInvalidCharacters = self::GetInvalidCharacters();
	
		$strApplication = str_replace($arrInvalidCharacters,'',$_GET['Application']);
		$strSreen       = str_replace($arrInvalidCharacters,'',$_GET['Sreen']);
		$strContext     = str_replace($arrInvalidCharacters,'',$_GET['Context']);
		$streSection    = str_replace($arrInvalidCharacters,'',$_GET['Section']);
		$strResource    = str_replace($arrInvalidCharacters,'',$_GET['Resource']);
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

		//$strResourcePath = $GLOBALS['strBaseDir'].'/Applications/'.$strApplication.'/Private/Classes/Resources/'.$strModule.'/'.$strSection.'/'.$strResource.'.class.php';

		if(!file_exists($strResourcePath)){
			header($strHTTPVersion.' 404 Not Found');
			echo "Resource Not Found";
			exit;
		}

		
	}

}
