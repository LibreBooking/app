<?php
/**
Copyright 2012-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Application/Reporting/IReport.php');
require_once(ROOT_DIR . 'lib/Application/Reporting/IReportColumns.php');
require_once(ROOT_DIR . 'lib/Application/Reporting/IReportData.php');

require_once(ROOT_DIR . 'lib/Application/Reporting/ReportDefinition.php');
require_once(ROOT_DIR . 'lib/Application/Reporting/GeneratedSavedReport.php');
require_once(ROOT_DIR . 'lib/Application/Reporting/CustomReport.php');
require_once(ROOT_DIR . 'lib/Application/Reporting/CustomReportData.php');
require_once(ROOT_DIR . 'lib/Application/Reporting/Report_Filter.php');
require_once(ROOT_DIR . 'lib/Application/Reporting/Report_GroupBy.php');
require_once(ROOT_DIR . 'lib/Application/Reporting/Report_Range.php');
require_once(ROOT_DIR . 'lib/Application/Reporting/Report_ResultSelection.php');
require_once(ROOT_DIR . 'lib/Application/Reporting/Report_Usage.php');
require_once(ROOT_DIR . 'lib/Application/Reporting/ReportColumns.php');
require_once(ROOT_DIR . 'lib/Application/Reporting/ReportingService.php');
require_once(ROOT_DIR . 'lib/Application/Reporting/CannedReport.php');
require_once(ROOT_DIR . 'lib/Application/Reporting/ReportUtilizationData.php');
