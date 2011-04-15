<?php
class UploadedFile
{
	private $file;

	public function __construct($file)
	{
		$this->file = $file;
	}

	/**
	 * @return string
	 */
	public function OriginalName()
	{
		return $this->file['name'];
	}

	/**
	 * @return string
	 */
	public function TemporaryName()
	{
		return $this->file['tmp_name'];
	}

	/**
	 * @return string
	 */
	public function MimeType()
	{
		return $this->file['type'];
	}

	/**
	 * @return int total bytes
	 */
	public function Size()
	{
		return $this->file['size'];
	}
	
	/**
	 * @return string
	 */
	public function Extension()
	{
		$info = pathinfo($this->OriginalName());
		return $info['extension'];
	}
	
	public function IsError()
	{
	 	return $this->file['error'] != UPLOAD_ERR_OK;
	}
	
	public function Error()
	{
		$messages = array(
			UPLOAD_ERR_OK => '',
			UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the maximum file size',
			UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the maximum file size',
			UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
			UPLOAD_ERR_NO_FILE => 'No file was uploaded',
			UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary storage folder',
			UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk, check folder permissions of configured upload directory'
		);
		
		return $messages[$this->file['error']];
	}
}
?>