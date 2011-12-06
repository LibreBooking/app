<?php
require_once(ROOT_DIR . 'lib/WebService/IRestService.php');
require_once(ROOT_DIR . 'lib/WebService/IRestServer.php');

class RestRequestProcessor
{
	public function __construct(IRestService $service, IRestServer $server)
	{
		$this->service = $service;
		$this->server = $server;
	}

	public function ProcessRequest()
	{
		$response = new NullRestResponse();

		if ($this->server->IsPost())
		{
			$response = $this->service->HandlePost($this->server, $this->GetServiceAction());
		}
		if ($this->server->IsGet())
		{
			$response = $this->service->HandleGet($this->server, $this->GetServiceAction());
		}

		$this->server->Respond($response);
	}

	private function GetServiceAction()
	{
		return $this->server->GetServiceAction();
	}
}

?>