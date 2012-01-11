<?php
/*
* @author Ken Lalobo
*
*/

namespace Xizlr\Models\Config;

class ComponentConfig extends \Xizlr\Models\AbstractModel{

	
	public function __construct(){
		$this->SetDBDriver('MongoDB');
	}
	
	
	public function Load($strComponentHandle, $strComponentId){	
		$objDataMapper = $this->GetModelMapper();
		$objDataMapper->SetSearchField('strComponentHandle',$strComponentHandle);
		$objDataMapper->SetSearchField('strComponentId',$strComponentId);
		$objDataMapper->SetLimit(1);
		$objDataMapper->Search();
		$this->arrData = $objDataMapper->GetRecord();	
	}	  	
}
