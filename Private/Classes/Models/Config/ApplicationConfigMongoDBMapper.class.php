<?php
/*
* @author Ken Lalobo
*
*/

namespace Xizlr\Models\Config;

class ApplicationConfigMongoDBMapper extends \Xizlr\Models\AbstractMongoDBMapper{
	public function __construct(){  	
		$this->SetDatabaseName('dbXizlr');
		$this->SetCollectionName('arrApplicationsConfig');
		parent::__construct();
	}	
}
