<?php

require_once(ROOT_DIR . 'lib/Application/Reporting/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');

class CustomReport implements IReport
{
    /**
     * @var CustomReportData
     */
    private $data;
    /**
     * @var ReportColumns
     */
    private $cols;
    /**
     * @var int
     */
    private $resultCount = 0;

    /**
     * @param array $rows
     * @param IAttributeRepository $attributeRepository
     */
    public function __construct($rows, IAttributeRepository $attributeRepository)
    {
        $this->resultCount = count($rows);

        $this->cols = new ReportColumns();
        if (count($rows) > 0) {
            foreach ($rows[0] as $columnName => $value) {
                if ($columnName == ColumnNames::ATTRIBUTE_LIST) {
                    $attributes = $attributeRepository->GetByCategory(CustomAttributeCategory::RESERVATION);

                    foreach ($attributes as $attribute) {
                        $this->cols->AddAttribute(CustomAttributeCategory::RESERVATION, $attribute->Id(), $attribute->Label());
                    }
                } elseif ($columnName == ColumnNames::USER_ATTRIBUTE_LIST) {
                    $attributes = $attributeRepository->GetByCategory(CustomAttributeCategory::USER);

                    foreach ($attributes as $attribute) {
                        $this->cols->AddAttribute(CustomAttributeCategory::USER, $attribute->Id(), $attribute->Label());
                    }
                } elseif ($columnName == ColumnNames::RESOURCE_ATTRIBUTE_LIST) {
                    $attributes = $attributeRepository->GetByCategory(CustomAttributeCategory::RESOURCE);

                    foreach ($attributes as $attribute) {
                        $this->cols->AddAttribute(CustomAttributeCategory::RESOURCE, $attribute->Id(), $attribute->Label());
                    }
                } elseif ($columnName == ColumnNames::RESOURCE_TYPE_ATTRIBUTE_LIST) {
                    $attributes = $attributeRepository->GetByCategory(CustomAttributeCategory::RESOURCE_TYPE);

                    foreach ($attributes as $attribute) {
                        $this->cols->AddAttribute(CustomAttributeCategory::RESOURCE_TYPE, $attribute->Id(), $attribute->Label());
                    }
                } else {
                    $this->cols->Add($columnName);
                }
            }
        }

        $this->data = new CustomReportData($rows);
    }

    /**
     * @return IReportColumns
     */
    public function GetColumns()
    {
        return $this->cols;
    }

    /**
     * @return IReportData
     */
    public function GetData()
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function ResultCount()
    {
        return $this->resultCount;
    }
}
