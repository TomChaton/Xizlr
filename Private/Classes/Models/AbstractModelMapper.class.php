<?php
/*
* @author Ken Lalobo
*
*/

namespace Xizlr\Models;

abstract class AbstractModelMapper{
    
	protected $strPrimaryKeyName;	
	protected $strContainerName;	
	protected $strDatabaseName;	
	
	protected $arrSearchFields = array();
	
	protected $objDBDriver;
	 
	protected $intLimit = 1;
	
	abstract function Search();
	abstract function GetRecord();
	
	protected function SetPrimaryKeyName($strPrimaryKeyName){
		$this->strPrimaryKeyName = $strPrimaryKeyName;
  }
  
	protected function SetDatabaseName($strDatabaseName){
		$this->strDatabaseName = $strDatabaseName;
	}
	
	protected function SetContainerName($strContainerName){
		$this->strContainerName = $strContainerName;
  }
	
	public function SetSearchField($strFieldName,$mxdFieldValue){
		$this->arrSearchFields[$strFieldName] = $mxdFieldValue;
	}
	
	public function SetLimit($intLimit){
		$this->intLimit = $intLimit;
	}
	
	
}
