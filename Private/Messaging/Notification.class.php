<?php

namespace \Xilzr\Messaging\

class Notification {
    
    public function SetMessage($strMessage,$strLinktext='',$strLinkValue='',$strType='General'){
		$this->arrSystemMessage = array(
			'strMessage'   => $strMessage,
			'strLinktext'  => $strLinktext,
			'strLinkValue' => $strLinkValue,
			'strType'      => $strType
		);
	}
	
	public function GetSystemMessage(){
		return $this->arrSystemMessage;
	}
	
	public function ClearSystemMessage(){
		return $this->arrSystemMessage;
	}
}
