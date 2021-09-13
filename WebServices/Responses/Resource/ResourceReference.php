<?php

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class ResourceReference extends RestResponse
{
    /**
     * @var int
     */
    public $resourceId;
    /**
     * @var string
     */
    public $name;
    /**
     * @var int
     */
    public $scheduleId;
    /**
     * @var int
     */
    public $statusId;
    /**
     * @var int
     */
    public $statusReasonId;

    /**
     * @param IRestServer $server
     * @param BookableResource $resource
     */
    public function __construct(IRestServer $server, $resource)
    {
        $this->resourceId = $resource->GetId();
        $this->name = $resource->GetName();
        $this->scheduleId = $resource->GetScheduleId();
        $this->statusId = $resource->GetStatusId();
        $this->statusReasonId = $resource->GetStatusReasonId();

        $this->AddService($server, WebServices::GetResource, [WebServiceParams::ResourceId => $this->resourceId]);
        $this->AddService($server, WebServices::GetSchedule, [WebServiceParams::ScheduleId => $this->scheduleId]);
    }

    public static function Example()
    {
        return new ExampleResourceReference();
    }
}

class ExampleResourceReference extends ResourceReference
{
    public function __construct()
    {
        $this->resourceId = 1;
        $this->name = 'resource name';
        $this->scheduleId = 2;
        $this->statusId = ResourceStatus::AVAILABLE;
        $this->statusReasonId = 123;

        $this->AddServiceLink(new RestServiceLink('http://get-resource-url', WebServices::GetResource));
        $this->AddServiceLink(new RestServiceLink('http://get-schedule-url', WebServices::GetSchedule));
    }
}
