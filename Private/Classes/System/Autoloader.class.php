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
	
	private static function GetClassFilepath($strClassName){
		$arrClassParts = explode('\\',str_replace(array('.',' '),'',$strClassName));
		$strNamespace = array_shift($arrClassParts);

		if($strNamespace == 'Xizlr'){		
			$strFilepath = __DIR__.'/../'.implode('/',$arrClassParts).'.class.php';
		}else{
			$strFilepath = __DIR__.'/../../../../'.$strNamespace.'/Private/Classes/'.implode('/',$arrClassParts).'.class.php';
		}
		if(file_exists($strFilepath)){
			return $strFilepath;
		}
	}
	
	public static function ClassExists($strClassName){
		if($strClassFilepath = self::GetClassFilepath($strClassName)){
			require_once($strClassFilepath);
			return class_exists($strClassName);
		}else{
			return false;
		}
	}
	
	private function Load($strClassName){
		if($strClassFilePath = self::GetClassFilepath($strClassName)){
			require_once($strClassFilePath);
		}else{
			throw new \Exception('class '.$strClassName.' Not found');
		}
	}
}


