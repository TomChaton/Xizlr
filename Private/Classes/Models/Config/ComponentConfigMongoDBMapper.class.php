<?php
/*
* @author Ken Lalobo
*
*/

namespace Xizlr\Models\Config;

class ComponentConfigMongoDBMapper extends \Xizlr\Models\AbstractMongoDBMapper{
	public function __construct(){  	
		$this->SetDatabaseName('dbXizlr');
		$this->SetCollectionName('arrComponentsConfig');
		parent::__construct();
	}	
}
