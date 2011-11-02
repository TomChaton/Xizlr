<?php
/*
* @author Ken Odoki-Olam
*
*/

namespace Xizlr\System;

class Router{

	public function Route($strURL){	
		
		$arrMatches = null;
		$objApplicationConfig = \Xizlr\Models\Config\ApplicationConfig::GetInstance();
		$strApplicationHandle = $objApplicationConfig->GetData('strApplicationHandle');
		
		$objFrontController = new \Xizlr\System\FrontController;
			
		if($strURL=='/'){
			$strSection       = 'Pages';
			$strComponentName = 'Page';
			$strComponentId   = 'Index';
			$strAction        = 'View';
			$arrArguments     = array();
			
			$objFrontController->RunEvent($strApplicationHandle,$strSection,$strComponentName,$strComponentId, $strEvent,$arrArguments);
		}elseif(preg_match('/^\/Xi\/Method\/([^\/]+)\/([^\/]+)\/([^\/]+)\/([^\/]+)\/(.*)/', $strURL, $arrMatches)){
			// Are we calling a method?
			// e.g /Xi/Method/Users/Account/Save/1234

			$strSection        = $arrMatches[1];
			$strControllerName = $arrMatches[2];
			$strAction         = $arrMatches[3];
			$arrArguments      = explode('/',$arrMatches[4]);
			
			$objFrontController->RunMethod($strApplicationHandle,$strSection,$strControllerName,$strAction,$arrArguments);
		}elseif(preg_match('/^\/Xi\/Event\/([^\/]+)\/([^\/]+)\/([^\/]+)\/(.*)/', $strURL, $arrMatches)){
			// Are we calling an event?
			// e.g /Xi/Event/Pages/Page/Acount/View/456
			
			$strSection       = $arrMatches[1];
			$strComponentName = $arrMatches[2];
			$strComponentId   = $arrMatches[3];
			$strEvent         = $arrMatches[3];
			$arrArguments     = explode('/',$arrMatches[4]);
			
			$objFrontController->RunEvent($strApplicationHandle,$strSection,$strComponentName,$strComponentId, $strEvent,$arrArguments);
		}else{
			// We have found nothing so show a 404
			// We will add the ability to have custom routes for applications
			
			$strSection       = 'Pages';
			$strComponentName = 'Page';
			$strComponentId   = 'Status';
			$strEvent         = 'View';
			$arrArguments     = array('404');
			
			$objFrontController->RunEvent($strApplicationHandle,$strSection,$strComponentName,$strComponentId, $strEvent,$arrArguments);
		}
	}
}
