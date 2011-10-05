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
	 
	private $intLimit = 1;
	
	abstract function Search();
	
	public function SetSearchField($strFieldName,$mxdFieldValue){
		$this->arrSearchFields[$strFieldName] = $mxdFieldValue;
	}
	
	public function SetLimit($intLimit){
		$this->intLimit = $intLimit;
	}
	
	
}
