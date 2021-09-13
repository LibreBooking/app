<?php

class CompositeResourceFilter implements IResourceFilter
{
    /**
     * @var array|IResourceFilter[]
     */
    private $filters = [];

    public function Add(IResourceFilter $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * @param IResource $resource
     * @return bool
     */
    public function ShouldInclude($resource)
    {
        foreach ($this->filters as $filter) {
            if (!$filter->ShouldInclude($resource)) {
                return false;
            }
        }

        return true;
    }
}
