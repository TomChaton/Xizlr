<?php
/*
* @author Ken Lalobo
*
*/

namespace Xizlr\Database\Drivers;

class MongoDBDriver extends \Xizlr\Database\Drivers\AbstractDBDriver{
	
	private $objMongo;
	
	private $strCollectionName;
		
	private static $strSettingsFile = '/var/lib/xizlr/Mongo.conf.js';
	private static $objMongoSettings;
	
	public function Connect(){		
		if(is_object($this->objMongo) && $this->objMongo->connected){
			return $this->objMongo;
		}else{
			if($objMongoSettings = $this->GetMongoSettings()){
				$strHost = $objMongoSettings->arrMasterHostDB->strHostName;	
			}else{
				$strHost = 'localhost';
			}
			$this->objMongo = new \Mongo('mongodb://'.$strHost, array("persist" => "==CHANGE-THIS==="));
			if($this->objMongo->connected){
				return $this->objMongo;
			}else{
				return null;
			}
		}
	}
	
	private function GetMongoSettings(){
		$strSettingsFile = self::$strSettingsFile;
		if(is_object(self::$objMongoSettings)){
			return self::$objMongoSettings;
		}elseif(is_readable($strSettingsFile)){
			self::$objMongoSettings = json_decode(file_get_contents($strSettingsFile));		
			return self::$objMongoSettings;
		}else{
			return null;
		}		
	}
	
	public function SetCollectionName($strCollectionName){
		$this->strCollectionName = $strCollectionName;
	}
	
	public function Query($arrQuery){
		if($this->Connect()){		    
			$objDatabase = $this->objMongo->selectDB($this->strDatabaseName); 
			error_log($this->strDatabaseName.'-'.print_r($objDatabase,1));
			$objCollection = $objDatabase->selectCollection($this->strCollectionName);
			error_log($this->strCollectionName.'-'.print_r($objCollection,1));
			switch($arrQuery['strType']){
				case 'find':
					return $objCollection->find($arrQuery);		
				break;
				case 'findOne':
					return $objCollection->findOne($arrQuery);		
				break;
				case '':
					return $objCollection->find($arrQuery);		
				break;
			}
			
		}else{
			return null;
		}
	}
}
