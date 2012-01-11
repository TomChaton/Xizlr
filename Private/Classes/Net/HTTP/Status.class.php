<?php
/*
* @author Ken Odoki-Olam
*
*/

namespace Xizlr\Net\HTTP;

class Status{
	public $intHTTPCode;
	public $strHTTPVersion;
	public $strHTTPValue;
	
	public function __construct($intReturnCode){
		/*TO DO:
			The following should go into a model but I can't be arsed to do that right now
		*/
		
		$arrHTTPCodes = array(
			'200' => array('1.1','OK')
		);
		$this->intHTTPCode = $intReturnCode;
		$this->strHTTPVersion = '1.1';
		$this->strHTTPValue = 'OK';
	}
}
