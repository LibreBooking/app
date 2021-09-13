<?php

class CustomAttributes
{
    private $attributes = [];

    /**
     * @param string $attributes
     * @return CustomAttributes
     */
    public static function Parse($attributes)
    {
        $ca = new CustomAttributes();

        if (empty($attributes)) {
            return $ca;
        }

        $pairs = explode('!sep!', $attributes);

        foreach ($pairs as $pair) {
            $nv = explode('=', $pair);
            $ca->Add($nv[0], $nv[1]);
        }

        return $ca;
    }

    /**
     * @param $id int
     * @param $value string
     */
    public function Add($id, $value)
    {
        $this->attributes[$id] = $value;
    }

    /**
     * @param $id int
     * @return null|string
     */
    public function Get($id)
    {
        if (array_key_exists($id, $this->attributes)) {
            return $this->attributes[$id];
        }

        return null;
    }

    /**
     * @return array|string[]
     */
    public function All()
    {
        return $this->attributes;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function Contains($id)
    {
        return array_key_exists($id, $this->attributes);
    }
}
