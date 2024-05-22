<?php

require_once(ROOT_DIR . 'WebServices/Requests/Resource/ResourceRequest.php');
require_once(ROOT_DIR . 'WebServices/Validators/ResourceRequestValidator.php');
require_once(ROOT_DIR . 'Domain/Access/ResourceRepository.php');

interface IResourceSaveController
{
    /**
     * @param ResourceRequest $request
     * @param WebServiceUserSession $session
     * @return ResourceControllerResult
     */
    public function Create($request, $session);

    /**
     * @param int $resourceId
     * @param ResourceRequest $request
     * @param WebServiceUserSession $session
     * @return ResourceControllerResult
     */
    public function Update($resourceId, $request, $session);

    /**
     * @param int $resourceId
     * @param WebServiceUserSession $session
     * @return ResourceControllerResult
     */
    public function Delete($resourceId, $session);
}

class ResourceSaveController implements IResourceSaveController
{
    /**
     * @var IResourceRepository
     */
    private $repository;

    /**
     * @var IResourceRequestValidator
     */
    private $validator;

    public function __construct(IResourceRepository $repository, IResourceRequestValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function Create($request, $session)
    {
        $errors = $this->validator->ValidateCreateRequest($request);
        if (!empty($errors)) {
            return new ResourceControllerResult(null, $errors);
        }

        $newResource = BookableResource::CreateNew(
            $request->name,
            $request->scheduleId,
            $request->autoAssignPermissions,
            $request->sortOrder
        );
        $resourceId = $this->repository->Add($newResource);

        $resource = $this->BuildResource($request, $resourceId);
        $this->repository->Update($resource);

        return new ResourceControllerResult($resourceId, null);
    }

    public function Update($resourceId, $request, $session)
    {
        $errors = $this->validator->ValidateUpdateRequest($resourceId, $request);
        if (!empty($errors)) {
            return new ResourceControllerResult(null, $errors);
        }
        $oldResource = $this->repository->LoadById($resourceId);
        $resource = $this->BuildResource($request, $resourceId);
        $resource->SetImages($oldResource->GetImages());
        $this->repository->Update($resource);

        return new ResourceControllerResult($resourceId);
    }

    /**
     * @param int $resourceId
     * @param WebServiceUserSession $session
     * @return ResourceControllerResult
     */
    public function Delete($resourceId, $session)
    {
        $errors = $this->validator->ValidateDeleteRequest($resourceId);
        if (!empty($errors)) {
            return new ResourceControllerResult(null, $errors);
        }
        $resource = $this->repository->LoadById($resourceId);
        $this->repository->Delete($resource);

        return new ResourceControllerResult($resourceId);
    }

    /**
     * @param ResourceRequest $request
     * @param int $resourceId
     * @return BookableResource
     */
    private function BuildResource($request, $resourceId)
    {
        $resource = new BookableResource(
            $resourceId,
            $request->name,
            $request->location,
            $request->contact,
            $request->notes,
            $request->minLength,
            $request->maxLength,
            $request->autoAssignPermissions,
            $request->requiresApproval,
            $request->allowMultiday,
            $request->maxParticipants,
            $request->minNotice,
            $request->maxNotice,
            $request->description,
            $request->scheduleId
        );
        $resource->SetSortOrder($request->sortOrder);

        $attributes = [];
        foreach ($request->GetCustomAttributes() as $attribute) {
            $attributes[] = new AttributeValue($attribute->attributeId, $attribute->attributeValue);
        }
        $resource->ChangeAttributes($attributes);

        if (isset($request->statusId)) {
            $resource->ChangeStatus($request->statusId, $request->statusReasonId);
        }

        $resource->SetCheckin($request->requiresCheckIn, $request->autoReleaseMinutes);
        $resource->SetColor($request->color);
        $resource->SetCreditsPerSlot($request->creditsPerSlot);
        $resource->SetPeakCreditsPerSlot($request->peakCreditsPerSlot);
        if (isset($request->maxConcurrentReservations)) {
            $resource->SetMaxConcurrentReservations(intval($request->maxConcurrentReservations));
        }

        return $resource;
    }
}

class ResourceControllerResult
{
    private $resourceId;
    private $errors = [];

    public function __construct($resourceId, $errors = [])
    {
        $this->resourceId = $resourceId;
        $this->errors = $errors;
    }

    /**
     * @return bool
     */
    public function WasSuccessful()
    {
        return !empty($this->resourceId) && empty($this->errors);
    }

    /**
     * @return int
     */
    public function ResourceId()
    {
        return $this->resourceId;
    }

    /**
     * @return string[]
     */
    public function Errors()
    {
        return $this->errors;
    }
}
