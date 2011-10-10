<?php
/*
* @author Ken Lalobo
*
*/

namespace Xizlr\Models\Config;

class ApplicationConfigMongoDBMapper extends \Xizlr\Models\AbstractMongoDBMapper{
	public function __construct(){  	
		$this->SetDatabaseName('Xizlr');
		$this->SetCollectionName('arrApplicationsConfig');
		parent::__construct();
	}	
}
