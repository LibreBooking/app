<?php

class JsonRequest
{
    public function __construct($jsonObject = null)
    {
        $this->Hydrate($jsonObject);
    }

    private function Hydrate($jsonObject)
    {
        if (empty($jsonObject)) {
            return;
        }

        foreach ($jsonObject as $key => $value) {
            $this->$key = $value;
        }
    }
}
