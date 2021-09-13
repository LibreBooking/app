<?php

class ResourceMinimumNoticeRuleUpdate extends ResourceMinimumNoticeRuleAdd
{
    protected function EnforceMinimumNotice($resource)
    {
        return $resource->HasMinNoticeUpdate();
    }

    protected function GetMinimumNotice($resource)
    {
        return $resource->GetMinNoticeUpdate();
    }

    protected function GetErrorKey()
    {
        return 'MinNoticeErrorUpdate';
    }

    protected function ViolatesMinStartRule($instance, $minStartDate)
    {
        return $instance->PreviousStartDate()->LessThan($minStartDate) || $instance->StartDate()->LessThan($minStartDate);
    }
}

class ResourceMinimumNoticeCurrentInstanceRuleUpdate extends ResourceMinimumNoticeRuleUpdate
{
    protected function GetInstances($reservationSeries)
    {
        return [$reservationSeries->CurrentInstance()];
    }
}
