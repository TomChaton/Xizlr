<?php
/*
* @author Ken Lalobo
*
*/

namespace Xizlr\Models;

class AbstractMongoDBMapper extends \Xizlr\Models\AbstractModelMapper{
  
  public function __construct(){  	
  	$this->strPrimaryKeyName = '_id';	
		$this->objDBDriver = new \Xizlr\Database\Drivers\MongoDBDriver;  			
  }
  
  protected function SetPrimaryKeyName($strPrimaryKeyName){
		$this->strPrimaryKeyName = $strPrimaryKeyName;
  }
  
  protected function SetDatabaseName($strDatabaseName){
		$this->strDatabaseName = $strDatabaseName;
  }
    
  protected function SetCollectionName($strCollectionName){
		$this->strContainerName = $strCollectionName;
  }
  
	public function Search(){		
		$this->objDBDriver->SetDatabase($this->strDatabaseName);
		$this->objDBDriver->SetCollection($this->strContainerName);
		$curReturn = $this->objDBDriver->Query(array('strApplicationDomainName' => 'www.helloworld.local'));
print_r($this->arrSearchFields);		
echo "<BR/>";		
print_r($curReturn);		
foreach ($curReturn as $obj) {
		print_r($obj);
}

exit;
	}
	
	
}
