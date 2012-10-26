<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'lib/external/Slim/Slim.php');
require_once(ROOT_DIR . 'lib/WebService/Slim/namespace.php');

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$requestReader = new SlimRequestReader($app);
$responseWriter = new SlimResponseWriter($app);

$registry = new SlimWebServiceRegistry($app);

$auth = new AuthWebService($requestReader, $responseWriter);

$authCategory = new SlimWebServiceRegistryCategory('Authentication');
$authCategory->AddPost('Login', array($auth, 'Login'));

$registry->AddCategory($authCategory);

$app->get('/', function () use ($registry)
{
	// Print API documentation
	ApiHelpPage::Render($registry);
});

class ApiHelpPage
{
	public static function Render(SlimWebServiceRegistry $registry)
	{
		$head = <<<EOT
	<!DOCTYPE html>
	    <html>
	        <head>
	            <meta charset="utf-8"/>
	            <title>phpScheduleIt API Documentation</title>
	            <style type="text/css">
					body
					{
						margin: 10px;
						font: 12px Helvetica, "Helvetica Neue", "Lucida Grande", Verdana, Arial, sans-serif;
					}

					h1 {
						color: #fff;
						background-color: #36648B;
						line-height: 90px;
						padding-left: 20px;
					}

					h2 {
						background-color: #BCE27F;
						line-height: 30px;
						padding-left: 20px;
						border: solid 1px #8CC739;
					}
					.service {
						border: solid 1px #ccc;
						background-color: #ededed;
						padding: 6px;
						padding-top:0px;
					}
					.code {
						font-family: courier;
					}

	            </style>
	        </head>
	        <body>
	            <h1>phpScheduleIt API Documentation</h1>
EOT;

		echo $head;

		foreach ($registry->Categories() as $category)
		{
			echo '<h2>' . $category->Name() . '</h2>';
			echo '<h3>POST Services</h3>';

			foreach ($category->Posts() as $post)
			{
				echo '<div class="service">';

				$md = $post->Metadata();
				$request = $md->Request();
				self::EchoCommon($md, $post);

				echo '<h4>Request</h4>';
				if (is_object($request))
				{
					echo '<div class="code">' . json_encode($request) . '</div>';
				} elseif (is_null($request))
				{
					echo 'No request';
				} else
				{
					echo 'Unstructured request of type <i>' . $request . '</i>';
				}

				echo '</div>';
			}

			echo '<h3>GET Services</h3>';

			foreach ($category->Gets() as $post)
			{
				echo '<div class="service">';
				$md = $post->Metadata();
				self::EchoCommon($md, $post);
				echo '</div>';
			}
		}

		echo '</body></html>';
	}

	private static function EchoCommon(SlimServiceMetadata $md, $post)
	{
		$response = $md->Response();
		echo "<h4>Name</h4>" . $md->Name();
		echo "<h4>Description</h4>" . $md->Description();
		echo '<h4>Route</h4>' . $post->Route();

		echo '<h4>Response</h4>';
		if (is_object($response))
		{
			echo '<div class="code">' . json_encode($response) . '</div>';
		} elseif (is_null($response))
		{
			echo 'No response';
		} else
		{
			echo 'Unstructured response of type <i>' . $response . '</i>';
		}
	}
}

class WebServiceCredentials
{
	public $username;

	public $password;
}

class AuthWebService
{
	public function __construct($reader, $writer)
	{

	}

	/**
	 * @name Login
	 * @description Authenticates the user with the provided credentials
	 * @request WebServiceCredentials
	 * @return string
	 */
	public function Login()
	{

	}
}

class SlimResponseWriter
{
	/**
	 * @var Slim\Slim
	 */
	private $slim;

	public function __construct(Slim\Slim $app)
	{
		$this->slim = $app;
	}

	public function Write($response)
	{
		$this->slim->response()->header("Content-Type", "application/json");
		echo json_encode($response);
	}
}

class SlimRequestReader
{
	/**
	 * @var Slim\Slim
	 */
	private $slim;

	public function __construct(Slim\Slim $app)
	{
		$this->slim = $app;
	}

	public function Read()
	{
		return json_decode($this->slim->request()->post());
	}
}

$app->run();
?>