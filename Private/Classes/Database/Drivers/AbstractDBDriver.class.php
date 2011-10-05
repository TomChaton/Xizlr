<?php
/*
* @author Ken Lalobo
*
*/

namespace Xizlr\Database\Drivers;

abstract class AbstractDBDriver{
	protected $bolUseSlave = true;
	
	private $arrMasterDB =array();
	private $arrSlaveDBs =array();
	
	protected $strDatabaseName;
	protected $strContainerName;
	
	abstract function Connect();
	abstract function Query($mxdQuery);
	
	public function UseMaster(){
		$this->bolUseSlave = false;
	}
	
	public function UseSlave(){
		$this->bolUseSlave = true;
	}
}
