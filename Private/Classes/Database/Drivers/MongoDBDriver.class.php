<?php
/*
* @author Ken Lalobo
*
*/

namespace Xizlr\Database\Drivers;

class MongoDBDriver extends AbstractDBDriver{
	private static $strSettingsFile = '/var/lib/xizlr/Mongo.conf.js';
	public function Connect($mxdHostName=null){
		if(file_exists($strSettingsFile)){
			file_get_contents($strSettingsFile);
		}else{
			$strHost = 'localhost';
		}
	}
}
