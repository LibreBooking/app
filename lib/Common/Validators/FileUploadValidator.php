<?php

class FileUploadValidator extends ValidatorBase implements IValidator
{
    /**
     * @var null|UploadedFile
     */
    private $file;

    /**
     * @param UploadedFile|null $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    public function Validate()
    {
        if ($this->file == null) {
            return;
        }
        $this->isValid = !$this->file->IsError();
        if (!$this->IsValid()) {
            Log::Debug('Uploaded file %s is not valid. %s', $this->file->OriginalName(), $this->file->Error());
            $this->AddMessage($this->file->Error());
        }
    }
}
