<?php
/*
* @author Ken Lalobo
*
*/

namespace Xizlr\Models\Config;

class ApplicationConfig extends \Xizlr\Models\AbstractModel{
	public function __construct(){
		$this->SetDBDriver('MongoDB');
	}

	public static function GetInstance($strApplicationDomainName){	
		\Xizlr\System\Logger::Log('debug','xizlr','Get config for '.$strApplicationDomainName);
		if(!is_object(self::$ApplicationConfig)){
			$objConfigInstance = new ApplicationConfig;
			$objConfigInstance->Load($strApplicationDomainName);
			self::$objConfigInstance = $objConfigInstance; 
		}
		return self::$objConfigInstance ;
	}
	
	public function Load($strApplicationDomainName){
		return $this->LoadBy('strApplicationDomainName',$strApplicationDomainName);
	}
	
	public function LoadBy($strFieldName,$mxdFieldValue){
		$objDataMapper = new ApplicationConfigMongoMapper();
		$objDataMapper->SetSearchField($strFieldName,$mxdFieldValue);
		$objDataMapper->SetLimit(1);
		$this->arrData = $objDataMapper->Search();
	}
}
