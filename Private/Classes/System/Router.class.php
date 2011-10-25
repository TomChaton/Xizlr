<?php
/*
* @author Ken Odoki-Olam
*
*/

namespace Xizlr\System;

class Router{

	public function Route($strURL){	
		
		$arrURL = $arrURL = explode('/',$strURL);
		
		if($arrURL[1]=='Xi'){
		   $arrAction = array(
            $strActionType	= str_replace($arrInvalidCharacters,'',$_GET['ActionType']);
		      $strApplication = str_replace($arrInvalidCharacters,'',$_GET['Application']);
		      $strSection     = str_replace($arrInvalidCharacters,'',$_GET['Section']);
		      $strController  = str_replace($arrInvalidCharacters,'',$_GET['Controller']);
		      $strAction      = str_replace($arrInvalidCharacters,'',$_GET['Action']);
		      $arrArguments   = explode('/',$_GET['Arguments']);
		   );
		}else{
		
		   if($strURL == '/'){
			   $objConfig = \Xizlr\Models\Config\ApplicationConfig::GetInstance();
		   }else{
		   }
				
		}
		
		/*
RewriteRule ^/Xi/Method/([^/]+)/([^/]+)/([^/]+)/([^/]+)/(.*) /Index.php?ActionType=Method&Application=$1&Section=$2&Controller=$3&Action=$4&ArgumentList=$5 [L]
RewriteRule ^/Xi/Event/([^/]+)/([^/]+)/([^/]+)/([^/]+)/([^/]+)/(.*) /Index.php?ActionType=Event&Application=$1&Section=$2&Controller=$3&ResourceId=$4&Action=$5&ArgumentList=$5 [L]
/Xi/Method/Memster/Users/Account/Save/1234
/Xi/Event/Pages/Page/Acount/View/456
/Xi/View/Memster/Users/AccountHeader/1/Edit/lalobo
*/
		//$objFrontController = new \Xizlr\System\FrontController;
		//$objFrontController->Run();


	}

}
