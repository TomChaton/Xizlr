<?php
/*
* @author Ken Lalobo
*
*/

namespace Xizlr\Models;

class AbstractMongoDBMapper extends \Xizlr\Models\AbstractModelMapper{
  
  protected $objResults;
  
  public function __construct(){  	
      $this->strPrimaryKeyName = '_id';	
		$this->objDBDriver = new \Xizlr\Database\Drivers\MongoDBDriver;  			
  }
      
  protected function SetCollectionName($strCollectionName){
		$this->SetContainerName($strCollectionName);
  }
  
	public function Search(){		
		$this->objDBDriver->SetDatabaseName($this->strDatabaseName);
		$this->objDBDriver->SetCollectionName($this->strContainerName);
		$arrQuery = array(
			'strType'  => 'find',
			'arrQuery' => $this->arrSearchFields
		);
		$this->objResults = $this->objDBDriver->Query($this->arrSearchFields,null,$this->intLimit);
	}
	
	public function GetRecord(){
		$objResult = $this->objResults->getNext();
		return $objResult;
	}
	
	
}
