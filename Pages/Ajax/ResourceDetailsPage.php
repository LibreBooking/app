<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class ResourceDetailsPage extends SecurePage implements IResourceDetailsPage
{
    /**
     * @var \ResourceDetailsPresenter
     */
    private $presenter;

    public function __construct()
    {
        parent::__construct('', 1);
        $this->presenter = new ResourceDetailsPresenter($this, new ResourceRepository());
    }

    public function PageLoad()
    {
        $this->presenter->PageLoad();

        $this->smarty->display('Ajax/resourcedetails.tpl');
    }

    public function BindResource(BookableResource $resource)
    {
        $this->Set('resourceName', $resource->GetName());
        $this->Set('description', $resource->GetDescription());
        $this->Set('notes', $resource->GetNotes());
        $this->Set('contactInformation', $resource->GetContact());
        $this->Set('locationInformation', $resource->GetLocation());
        $this->Set('allowMultiday', $resource->GetAllowMultiday());
        $this->Set('maximumDuration', $resource->GetMaxLength());
        $this->Set('minimumDuration', $resource->GetMinLength());
        $this->Set('maxParticipants', $resource->GetMaxParticipants());
        $this->Set('maximumNotice', $resource->GetMaxNotice());
        $this->Set('minimumNotice', $resource->GetMinNotice());

        if ($resource->HasImage())
        {
            $this->Set('imageUrl', Configuration::Instance()->GetKey(ConfigKeys::IMAGE_UPLOAD_DIRECTORY) . '/' . $resource->GetImage() );
        }
    }

    function GetResourceId()
    {
        return ServiceLocator::GetServer()->GetQuerystring(QueryStringKeys::RESOURCE_ID);
    }
}

interface IResourceDetailsPage
{
    function BindResource(BookableResource $resource);

    function GetResourceId();
}

class ResourceDetailsPresenter
{
    /**
     * @var ResourceRepository
     */
    private $resourceRepository;

    /**
     * @var IResourceDetailsPage
     */
    private $page;

    /**
     * @param IResourceDetailsPage $page
     * @param IResourceRepository $resourceRepository
     */
    public function __construct(IResourceDetailsPage $page, IResourceRepository $resourceRepository)
    {
        $this->page = $page;
        $this->resourceRepository = $resourceRepository;
    }

    public function PageLoad()
    {
        $resourceId = $this->page->GetResourceId();
        $resource = $this->resourceRepository->LoadById($resourceId);
        $this->page->BindResource($resource);
    }
}

?>
