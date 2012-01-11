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
	
	/* TO DO: USE THIS TO LOAD THE CONFIG */
	
/*	public function Load($mxdFieldValue){		
		$objDataMapper = $this->GetModelMapper();
		$objDataMapper->SetSearchField($strFieldName,$mxdFieldValue);
		$objDataMapper->SetLimit(1);
		$objDataMapper->Search();
		$this->arrData = $objDataMapper->GetRecord();	
	}	  	
	*/
}
