<?php

class FileTypeValidator extends ValidatorBase implements IValidator
{
    /**
     * @var null|UploadedFile
     */
    private $file;

    /**
     * @var array|string[]
     */
    private $allowedTypes;

    /**
     * @param UploadedFile|null $file
     * @param array|string|string[] $allowedTypes
     */
    public function __construct($file, $allowedTypes = [])
    {
        $this->file = $file;
        if (!is_array($allowedTypes)) {
            $this->allowedTypes = [$allowedTypes];
        } else {
            $this->allowedTypes = $allowedTypes;
        }
    }

    public function Validate()
    {
        if ($this->file == null) {
            return;
        }
        $this->isValid = in_array($this->file->Extension(), $this->allowedTypes);
        if (!$this->IsValid()) {
            $this->AddMessage(Resources::GetInstance()->GetString('InvalidAttachmentExtension', [implode(',', $this->allowedTypes)]));
        }
    }
}
