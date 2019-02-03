<?php
/**
 * Copyright 2018-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

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

        if ($row = $reader->GetRow())
        {
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