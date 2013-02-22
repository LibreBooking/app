<?php
/**
Copyright 2011-2013 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');

class ResourceDetailsPage extends Page implements IResourceDetailsPage
{
    /**
     * @var \ResourceDetailsPresenter
     */
    private $presenter;

    public function __construct()
    {
        parent::__construct('', 1);
        $this->presenter = new ResourceDetailsPresenter($this, new ResourceRepository(), new AttributeRepository());
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
		$this->Set('minimumDuration', $resource->GetMinLength());
        $this->Set('maximumDuration', $resource->GetMaxLength());

        $this->Set('maxParticipants', $resource->GetMaxParticipants());
        $this->Set('maximumNotice', $resource->GetMaxNotice());
        $this->Set('minimumNotice', $resource->GetMinNotice());
        $this->Set('requiresApproval', $resource->GetRequiresApproval());
        $this->Set('autoAssign', $resource->GetAutoAssign());

        if ($resource->HasImage())
        {
            $this->Set('imageUrl', Configuration::Instance()->GetKey(ConfigKeys::IMAGE_UPLOAD_URL) . '/' . $resource->GetImage() );
        }
    }

	public function BindAttributes($attributes)
	{
		$this->Set('Attributes', $attributes);
	}

    public function GetResourceId()
    {
        return ServiceLocator::GetServer()->GetQuerystring(QueryStringKeys::RESOURCE_ID);
    }
}

interface IResourceDetailsPage
{
	public function BindResource(BookableResource $resource);
	public function BindAttributes($attributes);
	public function GetResourceId();
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
	 * @var IAttributeRepository
	 */
    private $attributeService;

    /**
     * @param IResourceDetailsPage $page
     * @param IResourceRepository $resourceRepository
	 * @param IAttributeRepository $attributeRepository
     */
    public function __construct(IResourceDetailsPage $page, IResourceRepository $resourceRepository, IAttributeRepository $attributeRepository)
    {
        $this->page = $page;
        $this->resourceRepository = $resourceRepository;
		$this->attributeService = $attributeRepository;
    }

    public function PageLoad()
    {
		$attributeValues = array();
        $resourceId = $this->page->GetResourceId();
        $resource = $this->resourceRepository->LoadById($resourceId);
        $this->page->BindResource($resource);

		$attributes = $this->attributeService->GetByCategory(CustomAttributeCategory::RESOURCE);
		foreach ($attributes as $attribute)
		{
			$attributeValues[] = new Attribute($attribute, $resource->GetAttributeValue($attribute->Id()));
		}

		$this->page->BindAttributes($attributeValues);
    }
}

?>