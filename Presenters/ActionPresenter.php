<?php
abstract class ActionPresenter
{
	/**
	 * @var IActionPage
	 */
	private $actionPage;

	/**
	 * @var array
	 */
	private $actions;

	protected function __construct(IActionPage $page)
	{
		$this->actionPage = $page;
		$this->actions = array();
	}

	protected function AddAction($actionName, $actionMethod)
	{
		$this->actions[$actionName] = $actionMethod;
	}

	protected function ActionIsKnown($action)
	{
		return isset($this->actions[$action]);
	}

	public function ProcessAction()
	{
		$action = $this->actionPage->GetAction();

		if ($this->ActionIsKnown($action)) {
			$method = $this->actions[$action];
			try
			{
				Log::Error("Processing page action. Action %s", $action);
				$this->$method();
			}
			catch (Exception $ex)
			{
				Log::Error("ProcessAction Error. Action %s, Error %s", $action, $ex);
			}
		}
		else
		{
			Log::Error("Unknown action %s", $action);
		}
	}
}
?>