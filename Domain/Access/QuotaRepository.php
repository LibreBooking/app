<?php

interface IQuotaRepository
{
	/**
	 * @abstract
	 * @param $resourceId
	 * @return array|Quota[]
	 */
	function GetQuotas($resourceId);
}

class QuotaRepository
{

}
