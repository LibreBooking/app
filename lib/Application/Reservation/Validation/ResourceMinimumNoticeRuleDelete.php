<?php

class ResourceMinimumNoticeRuleDelete extends ResourceMinimumNoticeRuleAdd
{
    protected function EnforceMinimumNotice($resource)
    {
        return $resource->HasMinNoticeDelete();
    }

    protected function GetMinimumNotice($resource)
    {
        return $resource->GetMinNoticeDelete();
    }

    protected function GetErrorKey()
    {
        return 'MinNoticeErrorDelete';
    }
}
