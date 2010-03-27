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
			$this->_resource = new AddResource();
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
			$this->Resource();
		}
	}
	
	public function AddResource()
	{
		if ($this->_page->IsValid())
	    {
    		$additionalFields = array('location' => $this->_page->GetLocation(),
									  'contact_info' => $this->_page->GetContactInfo(),
									  'description' => $this->_page->GetDescription(),
									  'notes' => $this->_page->GetNotes(),
									  'isactive' => $this->_page->GetIsActive(),
									  'min_duration' => $this->_page->GetMinDuration(),
									  'min_increment' => $this->_page->GetMinIncrement(),
    								  'max_duration' => $this->_page->GetMaxDuration(),
									  'unit_cost' => $this->_page->GetUnitCost(),
									  'autoassign' => $this->_page->GetAutoAssign(),
									  'requires_approval' => $this->_page->GetRequiresApproval(),
									  'allow_multiday' => $this->_page->GetAllowMultiday(),
									  'max_participants' => $this->_page->GetMaxParticipants(),
									  'min_notice_time' => $this->_page->GetMinNotice(),
									  'max_notice_time' => $this->_page->GetMaxNotice(),
									  'constraint_id' => $this->_page->GetConstraints(),
									  'long_quota_id' => $this->_page->GetLongQuota(),
									  'day_quota_id' => $this->_page->GetDayQuota());
    		
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