<?php

require_once(ROOT_DIR . 'Domain/TermsOfService.php');

interface ITermsOfServiceRepository
{
    /**
     * @param TermsOfService $terms
     * @return int
     */
    public function Add(TermsOfService $terms);

    /**
     * @return TermsOfService|null
     */
    public function Load();

    /**
     * @return void
     */
    public function Delete();
}

class TermsOfServiceRepository implements ITermsOfServiceRepository
{
    public function Add(TermsOfService $terms)
    {
        $this->Delete();
        return ServiceLocator::GetDatabase()->ExecuteInsert(new AddTermsOfServiceCommand($terms->Text(), $terms->Url(), $terms->FileName(), $terms->Applicability()));
    }

    public function Load()
    {
        $reader = ServiceLocator::GetDatabase()->Query(new GetTermsOfServiceCommand());

        if ($row = $reader->GetRow()) {
            $reader->Free();
            return new TermsOfService($row[ColumnNames::TERMS_ID], $row[ColumnNames::TERMS_TEXT], $row[ColumnNames::TERMS_URL], $row[ColumnNames::TERMS_FILE], $row[ColumnNames::TERMS_APPLICABILITY]);
        }

        $reader->Free();
        return null;
    }

    public function Delete()
    {
        ServiceLocator::GetDatabase()->Execute(new DeleteTermsOfServiceCommand());
    }
}
