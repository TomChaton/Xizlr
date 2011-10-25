<?php
/*
* @author Ken Lalobo
*
*/

namespace Xizlr\Models;

abstract class AbstractModel{
    
	protected $strIdFieldName;
	protected $mxdID;
	
	protected $arrData   = array();
	private   $strCurrentDriver;
	
	private $objModelMapper;	
	
	public function __get($strFiledName){
	   return $this->arrData[$strFiledName];
	}
	
	public function SetDBDriver($strDriver){
		$this->strCurrentDriver = $strDriver;
	}
	
	public function Load($mxdID){
		return $this->LoadBy($this->strIdFieldName,$mxdID);
	}
	
	public function LoadBy($strFieldName,$mxdFieldValue){		
		$objDataMapper = $this->GetModelMapper();
		$objDataMapper->SetSearchField($strFieldName,$mxdFieldValue);
		$objDataMapper->SetLimit(1);
		$objDataMapper->Search();
		$this->arrData = $objDataMapper->GetRecord();	
	}
	
	private function GetModelMapper(){
		if($this->objModelMapper){
			return $this->objModelMapper;
		}elseif($this->strCurrentDriver){
			$strMapperClassName = '\\'.get_class($this).$this->strCurrentDriver.'Mapper';
			\Xizlr\System\Logger::Log('debug','xizlr','Mapper is '.$strMapperClassName);			
			$this->objModelMapper = new $strMapperClassName;
			return $this->objModelMapper;
		}else{
			$strError = 'cannot get model mapper to driver set ';
			\Xizlr\System\Logger::Log('critical','xizlr',$strError);
			throw new Exception($strError);
		}
	}
	
}
