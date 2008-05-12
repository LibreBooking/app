<?php
abstract class DashboardPresenterBase
{
	protected function GetDashboardVisibility($widgetId)
	{
		$cookie = ServiceLocator::GetServer()->GetCookie('dashboard_' . $widgetId);
		if (empty($cookie))
		{
			return true;
		}
		
		$converter = new BooleanConverter();
		return $converter->Convert($cookie);
	}
}

class DashboardWidgets
{
	const ANNOUNCEMENTS = 'announcementsDash';
}
?>