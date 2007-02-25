<?php
class AvailableLanguage
{
	public $LanguageCode;
	public $ValidationExpression;
	public $LanguageFile;
	public $DisplayName;
	
	public function __construct($languageCode, $validationExpression, $languageFile, $displayName)
	{
		$this->LanguageCode = $languageCode;
		$this->ValidationExpression = $validationExpression;
		$this->LanguageFile = $languageFile;
		$this->DisplayName = $displayName;		
	}
}
?>