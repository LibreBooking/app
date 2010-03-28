<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class ResourcePresenter
{
	private $_page;
	private $_resource;
    private $_auth;
	
	public function __construct(IResourcePage $page, $resource = null, $authorization = null)
	{
		$this->_page = $page;
		$this->SetResource($resource);
		$this->SetAuthorization($authorization);
				
		if ($page->IsPostBack())
		{
			$this->LoadValidators();
		}
	}
	
	private function SetResource($resource)
	{
		if (is_null($resource))
		{
			$this->_resource = new AddResource(1); //wtf does this 1 help? It removes the warning...
		}
		else
		{
			$this->_resource = $resource;
		}
	}
			
	private function SetAuthorization($authorization)
	{
		if (is_null($authorization))
		{
			$this->_auth = PluginManager::Instance()->LoadAuth();
		}
		else
		{
			$this->_auth = $authorization;
		}
	}
	
	public function PageLoad()
	{			
		if ($this->_page->SaveClicked())
		{
			$this->AddResource();
		}
	}
	
	public function AddResource()
	{
		if ($this->_page->IsValid())
	    {
    		$additionalFields = array('location' => $this->_page->GetLocation(),
									  'contactInfo' => $this->_page->GetContactInfo(),
									  'description' => $this->_page->GetDescription(),
									  'notes' => $this->_page->GetNotes(),
									  'isActive' => $this->_page->GetIsActive(),
									  'minDuration' => $this->_page->GetMinDuration(),
									  'minIncrement' => $this->_page->GetMinIncrement(),
    								  'maxDuration' => $this->_page->GetMaxDuration(),
									  'unitCost' => $this->_page->GetUnitCost(),
									  'autoAssign' => $this->_page->GetAutoAssign(),
									  'requiresApproval' => $this->_page->GetRequiresApproval(),
									  'allowMultiday' => $this->_page->GetAllowMultiday(),
									  'maxParticipants' => $this->_page->GetMaxParticipants(),
									  'minNotice' => $this->_page->GetMinNotice(),
									  'maxNotice' => $this->_page->GetMaxNotice());
    		
    		$this->_resource->AddResource(
    			$this->_page->GetResourceName(), 
    			$additionalFields);
    			
    		//$this->_auth->Login($this->_page->GetEmail(), false);
    		//$this->_page->Redirect(Pages::UrlFromId($this->_page->GetHomepage()));
	    }
	}
	
	private function LoadValidators()
	{
		$this->_page->RegisterValidator('name', new RequiredValidator($this->_page->GetResourceName()));
	}
}
?>