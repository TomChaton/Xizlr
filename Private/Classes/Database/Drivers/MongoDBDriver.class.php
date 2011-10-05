<?php
/*
* @author Ken Lalobo
*
*/

namespace Xizlr\Database\Drivers;

class MongoDBDriver extends \Xizlr\Database\Drivers\AbstractDBDriver{
	
	private $objMongo;
		
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
	
	public function SetDatabase($strDatabaseName){
		$this->strDatabaseName = $strDatabaseName;
	}
	
	public function SetCollection($strCollectionNAme){
		$this->strContainerName = $strCollectionNAme;
	}
	
	public function Query($arrQuery){
		if($this->Connect()){		    
			$objDatabase = $this->objMongo->selectDB($this->strDatabaseName); 
			error_log($this->strDatabaseName.'-'.print_r($objDatabase,1));
			$objCollection = $objDatabase->selectCollection($this->strContainerName);
			error_log($this->strContainerName.'-'.print_r($objCollection,1));
			return $objCollection->find($arrQuery);
		}else{
			return null;
		}
	}
}
