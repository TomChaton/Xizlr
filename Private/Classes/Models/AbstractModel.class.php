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
	
	public function GetData($strFieldName){
	   return $this->arrData[$strFieldName];
	}
	
	public function SetData($strFieldName, $mxdFielValue){
		\Xizlr\System\Logger::Log('debug','xizlr','Set data in model -> NAME: '.print_r($strFieldName,1).', VALUE: '.print_r($mxdFielValue,1));
	}
	
	public function SetDBDriver($strDriver){
		$this->strCurrentDriver = $strDriver;
	}
	
	public function Load($mxdID){
		return $this->LoadBy($this->strIdFieldName,$mxdID);
	}
	
	public function LoadBy($strFieldName,$mxdFieldValue){		
		\Xizlr\System\Logger::Log('debug','xizlr','Call load by function with arguments -> Field name: '.$strFieldName.', Field Value: '.$mxdFieldValue);
		$objDataMapper = $this->GetModelMapper();
		$objDataMapper->SetSearchField($strFieldName,$mxdFieldValue);
		$objDataMapper->SetLimit(1);
		$objDataMapper->Search();		
		$this->arrData = $objDataMapper->GetRecord();	
	}
	
	protected function GetModelMapper(){
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
