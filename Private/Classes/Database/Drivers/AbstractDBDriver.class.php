<?php
/*
* @author Ken Lalobo
*
*/

namespace Xizlr\Database\Drivers;

abstract class AbstractDBDriver{
	
	protected $strDatabaseName;
	protected $strHost;
	protected $strUsername;
	protected $strPassword;

	abstract function Connect();
	abstract function Query($mxdQuery);

	public function SetHost($strHost){
		$this->strHost = $strHost;
	}

	public function SetUser($strUsername){
		$this->strUsername = $strUsername;
	}

	public function SetPass($strPassword){
		$this->strPassword = $strPassword;
	}

	public function SetDatabaseName($strDatabaseName){
		$this->strDatabaseName = $strDatabaseName;
	}
}
