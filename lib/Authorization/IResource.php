<?php
interface IResource
{
	/**
	 * @param string $name
	 * @param array $additionalFields key value pair of additional fields to use during resource management
	 */
	public function Resource($name, $additionalFields = array());
}
?>