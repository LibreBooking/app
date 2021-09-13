<?php

class ReportCsvColumnView
{
    /**
     * @var string[]
     */
    private $selectedColumns;

    /**
     * @var int[]
     */
    private $skippedIterations = [];

    /**
     * @var bool
     */
    private $showAll;

    public function __construct($selectedColumns)
    {
        $this->selectedColumns = explode('!s!', $selectedColumns);
        $this->showAll = empty($selectedColumns);
    }

    public function ShouldShowCol(ReportColumn $column, $iteration)
    {
        if ($this->showAll) {
            return true;
        }

        $columnName = $column->HasTitle() ? $column->Title() : Resources::GetInstance()->GetString($column->TitleKey());
        if (in_array($columnName, $this->selectedColumns)) {
            return true;
        }

        $this->skippedIterations[] = $iteration;
        return false;
    }

    public function ShouldShowCell($iteration)
    {
        if ($this->showAll) {
            return true;
        }

        return !in_array($iteration, $this->skippedIterations);
    }
}
