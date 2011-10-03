<?php
/*
* @author Ken Lalobo
*
*/

namespace Xizlr\Models;

abstract class AbstractModel{
	protected $strUniqueIdName;
	protected $arrData = array();
	private $strCurrentDriver;
	private $objModelMapper;
	
	protected static $objConfigInstance;
	
	abstract static function GetInstance($strKey);
	
	abstract function Load();
	
	public function SetDriver($strDriver){
		$this->strCurrentDriver = $strDriver;
	}
	
	private function GetModelMapper(){
		if($this->objModelMapper){
			return $this->objModelMapper;
		}elseif($this->strCurrentDriver){
			$strMapperClassName = get_class($this).$this->strCurrentDriver.'Mapper';
			\Xizlr\System\Logger::Log('debug','xizlr','Mapper is '.$strMapperClassName);
			exit;
			$this->objModelMapper = new $strMapperClassName;
			return $this->objModelMapper;
		}else{
			$strError = 'cannot get model mapper to driver set ';
			\Xizlr\System\Logger::Log('critical','xizlr',$strError);
			throw new Exception($strError);
		}
	}
	
}
