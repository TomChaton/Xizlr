<?php
/*
* @author Ken Lalobo
*
*/

namespace Xizlr\Models\Config;

class ApplicationConfig extends \Xizlr\Models\AbstractModel{

	private static $objApplicationConfigInstance;
	
	public function __construct(){
		$this->SetDBDriver('MongoDB');
	}	  
	
	public static function GetInstance(){
		if(!is_object(self::$objApplicationConfigInstance)){
			$strApplicationDomainName = $_SERVER['SERVER_NAME'];
			\Xizlr\System\Logger::Log('debug','xizlr','Get config for '.$strApplicationDomainName);
			$objApplicationConfigInstance = new ApplicationConfig;
			$objApplicationConfigInstance->LoadBy('strApplicationDomainName',$strApplicationDomainName);
			self::$objApplicationConfigInstance = $objApplicationConfigInstance; 
		}
		return self::$objApplicationConfigInstance ;
	}	
	
	public static function GetCurrentApplicationHandle(){
		$objApplicationConfigInstance = self::GetInstance();
		return $objApplicationConfigInstance->GetData('strApplicationName');
	}
	
}
