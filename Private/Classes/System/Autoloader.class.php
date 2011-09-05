<?php
/*
* @author Ken Odoki-Olam
*
*/

namespace Xizlr;

class Autoloader{
	
	public static function Register(){
		$objAutoloader = new Autoloader;
		spl_autoload_register(array($objAutoloader, 'Load'));
		return objAutoloader;
	}
	
	private function Load($strClassName){
echo "hello!";		
exit;
	}
}


