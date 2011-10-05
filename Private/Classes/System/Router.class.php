<?php
/*
* @author Ken Odoki-Olam
*
*/

namespace Xizlr\System;

class Router{

	public function Route($strURL){	
		
		if($strURL == '/'){
			$objConfig = \Xizlr\Models\Config\ApplicationConfig::GetInstance();
		}else{
			$arrURL = explode('/',$strURL);	
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
