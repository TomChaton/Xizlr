<?php
/*
* @author Ken Lalobo
*
*/

namespace Xizlr\System;

class Logger{
	public static function Log($strLogLevel,$strModule,$strMessage){
		/*
			log levels are 'warn', 'debug', 'critical', 'log'
		*/
		error_log($strLogLevel.' -- '.$strModule.' -- '.$strMessage);
	}
}
