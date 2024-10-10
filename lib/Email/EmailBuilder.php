<?php

class EmailBuilder
{
    private array $subjectTranslationParams;
    private string $languageCode;
    private string $template;
    private array $smartyValues = [];
    private EmailAddress $from;
    /**
     * 
     * @var EmailAddress[]
     */
    private array $to = [];
    /**
     * 
     * @var EmailAddress[]
     */
    private array $cc = [];
    /**
     * 
     * @var EmailAddress[]
     */
    private array $bcc = [];
    /**
     * 
     * @var StringAttachment[]
     */
    private array $attachments = [];

    /**
     * 
     * @param string[] $args 
     * @return EmailBuilder 
     */
    public function SubjectTranslation(string $key, array $args = []): EmailBuilder
    {
        $this->subjectTranslationParams = 
        [
            'key' => $key, 
            'args' => implode(',', $args)
        ];
        return $this;
    }

    public function LanguageCode(string $languageCode): EmailBuilder
    {
        $this->languageCode = $languageCode;
        return $this;
    }

    public function Template(string $template): EmailBuilder
    {
        $this->template = $template;
        return $this;
    }

    public function FromAddress(EmailAddress $from): EmailBuilder
    {
        $this->from = $from;
        return $this;
    }

    public function From(string $email, string $name): EmailBuilder
    {
        return $this->FromAddress(new EmailAddress($email, $name));
    }    
    
    public function AddToAddress(EmailAddress $to): EmailBuilder
    {
        $this->to[] = $to;
        return $this;
    }

    public function AddTo(string $email, string $name): EmailBuilder
    {
        return $this->AddToAddress(new EmailAddress($email, $name));
    }

    public function AddCC(EmailAddress $cc): EmailBuilder
    {
        $this->cc[] = $cc;
        return $this;
    }

    public function AddBCC(EmailAddress $bcc): EmailBuilder
    {
        $this->bcc[] = $bcc;
        return $this;
    }

    public function AddStringAttachment(string $filename, string $contents): EmailBuilder
    {
        $this->attachments[] = new StringAttachment($filename, $contents);
        return $this;
    }

    public function Set($var, $value): EmailBuilder
    {
        $this->smartyValues[] = [$var, $value];
        return $this;
    }

    public function Build(): RenderedMessage
    {
        $enforceCustomTemplate = Configuration::Instance()->GetKey(ConfigKeys::ENFORCE_CUSTOM_MAIL_TEMPLATE, new BooleanConverter());
        $email = new SmartyPage($resources);
        $languageCode = $this->languageCode;
        if (!empty($languageCode)) {
            $resources->SetLanguage($languageCode);
            $email->assign('CurrentLanguage', $languageCode);
        }

        $email->assign('ScriptUrl', Configuration::Instance()->GetScriptUrl());
        $email->assign('Charset', $resources->Charset);
        $email->assign('AppTitle', (empty($appTitle) ? 'LibreBooking' : $appTitle));

        // ^^ copied

        foreach($this->smartyValues as $pair)
            $email->assign($pair[0], $pair[1]);

        $header = $email->fetch('Email/emailheader.tpl');
        $body = $email->FetchLocalized($this->template, $enforceCustomTemplate);
        $footer = $email->fetch('Email/emailfooter.tpl');

        $subject = $email->SmartyTranslate($this->subjectTranslationParams, $email);
        
        $from = $this->from ?? new EmailAddress(Configuration::Instance()->GetAdminEmail(), Configuration::Instance()->GetKey(ConfigKeys::ADMIN_EMAIL_NAME));
        $replyTo = $from;

        $charset = $resources->Charset;

        return new RenderedMessage(
            $charset,
            $subject,
            $from,
            $replyTo,
            $this->to,
            $this->cc,
            $this->bcc,
            $header . $body . $footer,
            $this->attachments
        );
    }
}