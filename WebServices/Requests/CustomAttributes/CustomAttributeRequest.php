<?php

require_once(ROOT_DIR . 'lib/WebService/JsonRequest.php');

class CustomAttributeRequest extends JsonRequest
{
	/**
	 * @var string
	 */
	public $label;

	/**
	 * @var int|CustomAttributeTypes
	 */
	public $type;

	/**
	 * @var int|CustomAttributeCategory
	 */
	public $categoryId;

	/**
	 * @var string
	 */
	public $regex;

	/**
	 * @var bool
	 */
	public $required;

	/**
	 * @var array|string
	 */
	public $possibleValues;

	/**
	 * @var int
	 */
	public $sortOrder;

	/**
	 * @var int[]
	 */
	public $appliesToIds = array();

	/**
	 * @var bool
	 */
	public $adminOnly;

	/**
	 * @var bool
	 */
	public $isPrivate;

    /**
     * @var int|null
     */
	public $secondaryCategoryId;

    /**
     * @var int[]|null
     */
    public $secondaryEntityIds;

	/**
	 * @return ExampleCustomAttributeRequest
	 */
	public static function Example()
	{
		return new ExampleCustomAttributeRequest();
	}
}

class ExampleCustomAttributeRequest extends CustomAttributeRequest
{
	public function __construct()
	{
		$this->label = 'attribute name';
		$this->type = 1;
		$this->categoryId = 1;
		$this->regex = 'validation regex';
		$this->required = true;
		$this->possibleValues = array('possible','values','only valid for select list');
		$this->sortOrder = 100;
		$this->appliesToIds = array(10);
		$this->adminOnly = true;
		$this->isPrivate = true;
		$this->secondaryCategoryId = 1;
		$this->secondaryEntityIds = array(1,2);
	}
}
