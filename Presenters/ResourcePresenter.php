<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class ResourcePresenter
{
	/**
	 * @var IResourcePage
	 */
	private $_page;
	
	/**
	 * @var IResourceRepository
	 */
	private $_resourceRepository;
	
	public function __construct(IResourcePage $page, IResourceRepository $resourceRepository)
	{
		$this->_page = $page;
		$this->_resourceRepository = $resourceRepository;
				
		if ($page->IsPostBack())
		{
			$this->LoadValidators();
		}
	}
			
	public function PageLoad()
	{			
		if ($this->_page->SaveClicked())
		{
			$this->AddResource();
		}
		else if ($this->_page->IsEditingResource())
		{
			$this->BindExistingResource();
		}
		else
		{
			// creating new resource, need to do anything special?
		}
	}
	
	private function BindExistingResource()
	{
		$resourceId = $this->_page->GetResourceId();
		
		$resource = $this->_resourceRepository->LoadById($resourceId);
		
		$this->_page->SetAllowMultiday($resource->GetAllowMultiday());
		$this->_page->SetAutoAssign($resource->GetAutoAssign());
		$this->_page->SetContactInfo($resource->GetPhone());		
		//TODO: No mapping currently $this->_page->SetDescription();
		$this->_page->SetLocation($resource->GetLocation());
		$this->_page->SetMaxDuration($resource->GetMaxLength());
		$this->_page->SetMaxNotice($resource->GetMaxNotice());
		$this->_page->SetMaxParticipants($resource->GetMaxParticipants());
		$this->_page->SetMinDuration($resource->GetMinLength());
		//TODO: No mapping currently $this->_page->SetMinIncrement(null);
		$this->_page->SetMinNotice($resource->GetMinNotice());
		$this->_page->SetNotes($resource->GetNotes());
		$this->_page->SetRequiresApproval($resource->GetRequiresApproval());
		$this->_page->SetResourceName($resource->GetName());
		//TODO: No mapping currently $this->_page->SetUnitCost();
	}
	
	private function AddResource()
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
    		
    		//TODO: Handle as update if resourceId is already set
    		$this->_resourceRepository->AddResource(
    			$this->_page->GetResourceName(), 
    			$additionalFields);
    			
    		//TODO: Handle errors/redirect after save
    		//$this->_page->Redirect(Pages::UrlFromId($this->_page->GetHomepage()));
	    }
	}
	
	private function LoadValidators()
	{
		$this->_page->RegisterValidator('name', new RequiredValidator($this->_page->GetResourceName()));
	}
}
?>