<?php
/*
* @author Ken Odoki-Olam
*
*/

namespace Xizlr;
require_once('Autoloader.class.php');

echo "here";
/*
XiSystem::RemoveMagicQuotes();
require_once($GLOBALS['strBaseDir'].'/Lib/Common/Classes/XML/XMLCommon.class.php');
require_once($GLOBALS['strBaseDir'].'/Lib/Common/Classes/Resources/Pages/Page.class.php');
require_once($GLOBALS['strBaseDir'].'/Lib/Common/Classes/Resources/Base.class.php');
require_once($GLOBALS['strBaseDir'].'/Lib/Common/Classes/System/XiPermissions.class.php');

class MVController{

	private $bolResourceVariablesSet = false;
		
	public function SetResourceVariables($strModule,$strSection,$strResource,$arrArguments,$strContext = 'HTML', $strAction = 'GET'){
		$this->bolResourceVariablesSet = true;

		$this->strModule    = $strModule;
		$this->strSection   = $strSection;
		$this->strResource  = $strResource;
		$this->strContext   = $strContext;
		$this->strAction    = $strAction;
		$this->arrArguments = $arrArguments;
	}

	public static function GetInvalidCharacters(){
		$arrInvalidCharacters = array('.','\\',',',')','(','"','\'',';','$','*','/');
		return $arrInvalidCharacters;
	}
	
	public function RunAux(){
		$arrInvalidCharacters = MVController::GetInvalidCharacters();
		$strModule     = str_replace($arrInvalidCharacters,'',$_GET['Module']);
		$strPageHandle = str_replace($arrInvalidCharacters,'',$_GET['PageHandle']);
		$strFileType   = str_replace($arrInvalidCharacters,'',$_GET['FileType']);
		$strApplication = str_replace($arrInvalidCharacters,'',$GLOBALS['strApplication']);
		if(!$strApplication){
			echo "This web application is misconfigured, please contact your administrator in order to fix it";
			XiSystem::LogError('You need to set up the global variable $strApplication in the application\'s conf file');
			exit;
		}
		$strHTTPVersion = 'HTTP/1.0';
		
		$intWebApplicationId = Resources_Base::GetApplicationIdFromHandle($strApplication);
		$intModuleId = Resources_Base::GetModuleIdFromHandle($strModule,$intWebApplicationId);
		$arrFileInfo = Resources_Pages_Page::GetAuxFileInfo($strPageHandle,$intModuleId,$intWebApplicationId,$strFileType);
		$intPageId = Resources_Pages_Page::GetPageIdFromHandle($strPageHandle,$GLOBALS['objSite']->GetSiteId(),$intModuleId);
		$strText = '';
		switch($strFileType){
			case 'CSS':
				$strMimeType = 'text/css';
				break;
			case 'JavaScript':
				$strMimeType = 'text/javascript';
				$strText = '
					XiPageSettings = {
						"strPageHandle":"'.addslashes($strPageHandle).'",
						"intPageId":'.intval($intPageId).'
					}
				';
			
				break;
			default:
				$strMimeType = 'text/plain';
		}
			
		header("Expires: " . gmdate("D, d M Y H:i:s",time()+(60*60)) . " GMT");
		header("Cache-Control: public, max-age=0");
		header("Content-Type: ".$strMimeType);
		
		echo $strText;
		foreach($arrFileInfo as $strFileInfo){
			readfile($strFileInfo);
		}
		
	}
	
	public static function SetCurrentPage($intPageId,$strURI){
		$arrPage = array(
			'intPageId' => $intPageId,
			'strURI' => $strURI
		);

		$objSession = XiSession::Get();
		return $objSession->SetSessionVariable(null,'Global','MVController.arrCurrentPage',$arrPage,'Object');
	}
	
	public static function GetCurrentPage(){
		$objSession = XiSession::Get();
		$arrPage = $objSession->GetSessionVariable(null,'Global','MVController.arrCurrentPage','Object');
		return $arrPage;
	}
	
	public function Run(){
		$arrInvalidCharacters = MVController::GetInvalidCharacters();
	
		if(!$this->bolResourceVariablesSet){
			$strModule    = str_replace($arrInvalidCharacters,'',$_GET['Module']);
			$strSection   = str_replace($arrInvalidCharacters,'',$_GET['Section']);
			$strResource  = str_replace($arrInvalidCharacters,'',$_GET['Resource']);
			$strContext   = str_replace($arrInvalidCharacters,'',$_GET['Context']);
			$strAction    = str_replace($arrInvalidCharacters,'',$_GET['Action']);
			$arrArguments = json_decode($_GET['Arguments']);
		}else{
			$strModule    = str_replace($arrInvalidCharacters,'',$this->strModule);
			$strSection   = str_replace($arrInvalidCharacters,'',$this->strSection);
			$strResource  = str_replace($arrInvalidCharacters,'',$this->strResource);
			$strContext   = str_replace($arrInvalidCharacters,'',$this->strContext);
			$strAction    = str_replace($arrInvalidCharacters,'',$this->strAction);
			$arrArguments = $this->arrArguments;
		}
		
		$strApplication = str_replace($arrInvalidCharacters,'',$GLOBALS['strApplication']);
		if(!$strApplication){
			echo "This web application is misconfigured, please contact your administrator in order to fix it";
			XiSystem::LogError('You need to set up the global variable $strApplication in the application\'s conf file');
			exit;
		}
		$strFunctionPrefix = 'HTTPAction';
		$strFunction    = $strFunctionPrefix.$strAction;
		$strHTTPVersion = 'HTTP/1.0';
		if(!isset($strContext)){
			$strContext = 'HTML';
		}

		$bolEditMode = (intval($_GET['EditMode']) > 0?true:false);

		$strResourcePath = $GLOBALS['strBaseDir'].'/Applications/'.$strApplication.'/Private/Classes/Resources/'.$strModule.'/'.$strSection.'/'.$strResource.'.class.php';

		if(!file_exists($strResourcePath)){
			header($strHTTPVersion.' 404 Not Found');
			echo "Resource Not Found";
			exit;
		}

		$objSession = XiSession::Get();
		$intApplicationId  = WebApplication::GetWebApplicationIdFromHandle($strApplication);
		$intModuleId       = Resources_Base::GetModuleIdFromHandle($strModule,$intApplicationId);
		$intSessionId      = $objSession->GetSessionIdInteger();
		$intLoggedInUserId = $objSession->GetLoggedInUserId();
		
		require_once($strResourcePath);
		$strClassName = 'Resources_'.$strModule.'_'.$strSection.'_'.$strResource;
		$objResource = new $strClassName;
		$objResource->SetModule($strModule,$intApplicationId);
		
		$bolHasAccess = XiPermissions::UserHasAccessToResourceAction($objResource, $intLoggedInUserId, $strAction, $arrArguments);
		
		if($bolHasAccess){
			//We have access to the object
			
			if($objResource->IsPage()){
				$objResource->SetResourcesManuallySet($this->bolResourceVariablesSet);
			}else{
				$arrCurrentPage = MVController::GetCurrentPage();
				$intCurrentPageId = $arrCurrentPage['intPageId'];
				if($intCurrentPageId){
					$objResource->SetCurrentPageId($intCurrentPageId);
					$objResource->SetCurrentURI($arrCurrentPage['strURI']);
				}else{
					$objCurrentPage = new Resources_Pages_Page();
					$objCurrentPage->SetModule($strModule,$intApplicationId);
					$objCurrentPage->LoadBy('p.vchPageHandle','Index');
					$arrCurrentPageDBData = $objCurrentPage->GetDBData();
					$objResource->SetCurrentPageId($arrCurrentPageDBData['intPageId']);
					$objResource->SetCurrentURI('/');
				}
			}
		
			if(is_callable(array($objResource, $strFunction))){
				call_user_func_array(array($objResource,$strFunction), $arrArguments);
			}else{
				header($strHTTPVersion." 403 Forbidden");
				echo "Action Not Allowed";
				exit;
			}
		}elseif($objResource->IsPage() && ($_SERVER["REQUEST_URI"] == $objResource->strLoginPage || $_SERVER["REQUEST_URI"] == $objResource->strAccessDeniedPage)){
			echo('You do not have access to view this page. It seems something may have a gone wrong. Please contact your administrator');
			XiSystem::LogError('Access has been denied to this page but the login page isn\'t set. ');
			exit;
		}else{
			if($intLoggedInUserId){
				$objResource->SetReturnActionStartProcess('Login',$objResource->strAccessDeniedPage,$_SERVER["REQUEST_URI"]);
				error_log("GO TO ACCESS DENIED");
			}else{
				$objResource->SetReturnActionStartProcess('Login',$objResource->strLoginPage,$_SERVER["REQUEST_URI"]);
				error_log("GO TO ACCESS LOGIN");
			}
		}
		$arrGenerateDataArguments = array('EditMode' => false);

		if($objResource->ContextAllowed($strContext)){
			switch($strContext){
				case 'HTML':
					
					$arrAction = $objResource->GetReturnAction();
					switch($arrAction['strActionName']){
						case 'StartProcess':
							$strProcessName         = $arrAction['mxdActionValue']['strProcessName'];
							$strProcessAction       = $arrAction['mxdActionValue']['strProcessAction'];
							$strProcessReturnAction = $arrAction['mxdActionValue']['strProcessReturnAction'];
							$objSession->SetSessionVariable(null,'Global','Xi.Process.'.$strProcessName.'.ReturnAction',$strProcessReturnAction,'Text');
							header('Location: '.$strProcessAction,TRUE,303);
							exit;
						break;
						case 'CompleteProcess':
							$strProcessName              = $arrAction['mxdActionValue']['strProcessName'];
							$strProcessAlternativeAction = $arrAction['mxdActionValue']['strProcessAlternativeAction'];
							$strProcessReturnAction      = $objSession->GetSessionVariable(null,'Global','Xi.Process.'.$strProcessName.'.ReturnAction','Text');
							//clear the general variable in the same way as the function SetGeneralVariable in Resources Base
							if($strProcessReturnAction){
								$objSession->ClearSessionVariable(null,'Global','Xi.Process.'.$strProcessName.'.ReturnAction','Text');
								header('Location: '.$strProcessReturnAction,TRUE,303);
							}else{
								header('Location: '.$strProcessAlternativeAction,TRUE,303);
							}
							exit;
						case 'ShowPageById':
							require_once($GLOBALS['strBaseDir'].'/Applications/'.$strApplication.'/Private/Classes/Resources/'.$strModule.'/Pages/Page.class.php');
							$strPageClassName = 'Resources_'.$strModule.'_Pages_Page';
							$objPage = new $strPageClassName;
							//$objPage->SetModule($strModule,$intApplicationId);
							$objPage->SetResourcesManuallySet(true);
							$objPage->HTTPActionGetById($arrAction['mxdActionValue']);
						break;
						case 'RedirectToPageById':
							MVController::RedirectToPage($arrAction['mxdActionValue']);
							exit;
						break;
						case 'RedirectToPageByURI':
							header('Location: '.$arrAction['mxdActionValue'],TRUE,303);
							exit;
						break;
						case 'RedirectToReferingPage':
							$strReferer = $_SERVER["HTTP_REFERER"];
							$arrReferer = parse_url($strReferer);
							if($_SERVER['HTTP_HOST'] == $arrReferer['host']){
								$strURI = $arrReferer['path'].($arrReferer['query']?'?'.$arrReferer['query']:'');
							}else{
								$strURI = '/';
							}
							header('Location: '.$strURI,TRUE,303);
						exit;
						break;
						case 'RedirectToCurrentPage':
							if($GLOBALS['decLibVersion'] >= 0.5){
								self::RedirectToCurrentPage();
							}else{
								if(!$objResource->IsPage()){
									MVController::RedirectToPage($objResource->GetCurrentPageId());
								}else{
									XySystem::LogError("cannot redirect to the same page. \nRequest Vars are: ".print_r($_REQUEST,1));
									echo "Error: the page tried to redirect to itself. Please contact your adminstrator to fix the problem";
								}
							}
							exit;
						break;
						case 'ShowCurrentPage':
							if($objResource->IsPage()){
								$objPage = $objResource;
							}else{
								require_once($GLOBALS['strBaseDir'].'/Applications/'.$strApplication.'/Private/Classes/Resources/'.$strModule.'/Pages/Page.class.php');
								$strPageClassName = 'Resources_'.$strModule.'_Pages_Page';
								$objPage = new $strPageClassName;
								$objPage->SetModule($strModule,$intApplicationId);
								$objPage->SetResourcesManuallySet(true);
								$objPage->HTTPActionGetById($objResource->GetCurrentPageId());
							}
						break;
						default:
							if($GLOBALS['decLibVersion'] >= 0.5){
								if($objResource->IsPage()){
									$objPage = $objResource;
								}else{
									self::RedirectToCurrentPage();
								}
							}else{
								if($objResource->IsPage()){
									$objPage = $objResource;
								}else{
									require_once($GLOBALS['strBaseDir'].'/Applications/'.$strApplication.'/Private/Classes/Resources/'.$strModule.'/Pages/Page.class.php');
									$strPageClassName = 'Resources_'.$strModule.'_Pages_Page';
									$objPage = new $strPageClassName;
									$objPage->SetModule($strModule,$intApplicationId);
									$objPage->SetResourcesManuallySet(true);
									$objPage->HTTPActionGetById($objResource->GetCurrentPageId());
								}
							}
					}
					
					$objPage->GenerateData($arrGenerateDataArguments);
					$arrData = $objPage->GetData();

					$arrSystemMessage = $objSession->GetSessionVariable(null,'Global','Xi.System.Message','Object');
		
					if($arrSystemMessage){
						$objSession->ClearSessionVariable(null,'Global','Xi.System.Message','Object');
						$arrData['Root']['SystemMessage'] = $arrSystemMessage;
					}
					$objXMLData = new XMLCommon;
					$objXMLData->SetData($arrData);
					$objXMLData->CreateXML();
					if($GLOBALS['bolDevEnv'] && $GLOBALS['bolDebugMode']){
					//if(true){
						$strReturn   = $objPage->GetXSLTemplateContents();
						$strMimeType = 'text/xml';
					}else{
						$objXMLData->AddXSLTemplate($objPage->GetXSLTemplateContents());
						$strReturn   = $objXMLData->Transform();
						$strMimeType = 'text/html';
					}
				break;
				case 'XML':
					$objResource->GenerateData($arrGenerateDataArguments);
					$arrData = $objResource->GetData();

					$arrSystemMessage = $objSession->GetSessionVariable(null,'Global','Xi.System.Message','Object');
					          
					if($arrSystemMessage){
						$objSession->ClearSessionVariable(null,'Global','Xi.System.Message','Object');
						$arrData['Root']['SystemMessage'] = $arrSystemMessage;
					}

					$objXMLData = new XMLCommon;
					$objXMLData->SetData($arrData);
					$strReturn   = $objXMLData->CreateXMLString();
					$strMimeType = 'text/xml';
				break;
				case 'JSON':
					$objResource->GenerateData($arrGenerateDataArguments);
					$arrData = $objResource->GetData();

					$arrSystemMessage = $objSession->GetSessionVariable(null,'Global','Xi.System.Message','Object');
					if($arrSystemMessage){
						$objSession->ClearSessionVariable(null,'Global','Xi.System.Message','Object');
						$arrData['SystemMessage'] = $arrSystemMessage;
					}
					$strReturn = json_encode($arrData['Root']);
					$strMimeType = 'text/json';
				break;
				case 'CSV':
					$objResource->GenerateData($arrGenerateDataArguments);
					$arrData = $objResource->GetData();
										
					$objXMLData = new XMLCommon;
					$objXMLData->SetData($arrData);
					$objXMLData->CreateXML();
					//$strReturn=  $objResource->GetXSLTemplateContents('CSV');
					//$strReturn   = $objXMLData->CreateXMLString();
					$objXMLData->AddXSLTemplate($objResource->GetXSLTemplateContents('CSV'));
					$strReturn   = $objXMLData->Transform();
					$strMimeType = 'text/csv';
					header("Content-disposition: attachment; filename=File.csv; size=".strlen($strReturn));
				break;
				default:
					$strReturn   = 'Context not recognised';
					$strMimeType = 'text/html';
			}
			
			header('Content-Type: '.$strMimeType.'; charset=utf-8');
			header('Content-Length: '.strlen($strReturn));
			header('Vary: User-Agent');
			echo $strReturn;
			exit;
		}else{
			header($strHTTPVersion.' 403 Forbidden');
			echo "Context Not Allowed";
			exit;
		}
	}
	
	public static function RedirectToCurrentPage(){
		$arrCurrentPage = self::GetCurrentPage();
		if(!$arrCurrentPage['strURI']){
			XiSystem::LogError('You are using a version of Xi greater than 0.4 but you are still not setting your current page properly. Dropping back to 0.4 redirect');
			self::RedirectToPage($arrCurrentPage['intPageId']);
		}else{
			header('Location: '.$arrCurrentPage['strURI'],TRUE,303);
		}
		exit;
	}

	public static function RedirectToPage($intPageId,$intModuleId=null){
		$objPage = new Resources_Pages_Page;
		$objPage->LoadBy('p.intPageId',$intPageId);
		if(!$intModuleId){
			$intModuleId = $objPage->GetModuleId();
		}
		
		$strModule = Resources_Base::GetModuleHandleFromId($intModuleId);
		$objXiURIBuilder = new XiURIBuilder($GLOBALS['strApplication'],$strModule, 'Pages', 'Page', 'Get', array($objPage->GetPageHandle()));
		$strURI = $objXiURIBuilder->GetRestfulURI();
		header('Location: '.$strURI,TRUE,303);
		exit;
	}

}

*/
