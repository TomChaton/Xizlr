<?php

/**
 *
 * Database Wrapper Class.
 * @author Ken Lalobo
 *
 */

/**
 * Class MySQLDBDriver
 */
class MySQLDBDriver extends \Xizlr\Database\Drivers\RelationalDBDriver{

	public function __construct($objConfig = null){
		parent::_construct(self::MySQL, $objConfig);
	}
	
}
