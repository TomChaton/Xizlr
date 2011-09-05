<?php
/*
* @author Ken Odoki-Olam
*
*/

namespace Xizlr\System;

class Autoloader{
	private static $objAutoloaderInstance = null;
	
	public static function Register(){
		if(self::$objAutoloaderInstance === null) {
			self::$objAutoloaderInstance = new Autoloader();
			spl_autoload_register(array(self::$objAutoloaderInstance, 'Load'));		
		} 
		
		return self::$objAutoloaderInstance;
	}
	
	private function Load($strClassName){
		$arrClassParts = explode('\\',$strClassName);
		$strNamespace = array_shift($arrClassParts);
	
		if($strNamespace == 'Xizlr'){
			$strFilepath = __DIR__.'/../'.implode('/',$arrClassParts).'.class.php';
			require_once($strFilepath);
		}else{
			return null;
		}
	}
}


