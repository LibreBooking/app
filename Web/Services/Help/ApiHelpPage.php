<?php
/**
Copyright 2012-2020 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */
class ApiHelpPage
{
	public static function Render(SlimWebServiceRegistry $registry, Slim\Slim $app)
	{
		$head = <<<EOT
	<!DOCTYPE html>
	    <html>
	        <head>
	            <meta charset="utf-8"/>
	            <title>Booked Scheduler API Documentation</title>
	              <link rel="shortcut icon" href="../favicon.ico"/>
                  <link rel="icon" href="../favicon.ico"/> 
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
						margin-bottom: 4px;
					}
					.code {
						font-family: courier;
					}
					#security {
						background-color: #FFFF99;
						border: solid 1px #CC9900;
						padding: 6px;
					}
					#security span {
						font-weight:bold;
					}

					a, a:visited {
						color:blue;
					}

                    .secure, .admin {
                        color:#ff0000;
                    }
	            </style>
	        </head>
	        <body>
	            <h1>Booked Scheduler API Documentation</h1>
EOT;

		$security = sprintf("<div id='security'>Pass the following headers for all secure service calls: <span>%s</span> and <span>%s</span></div>",
							WebServiceHeaders::SESSION_TOKEN, WebServiceHeaders::USER_ID);
		echo $head;

		echo $security;

		echo '<ul>';

		foreach ($registry->Categories() as $category)
		{
			echo "<li><a href='#{$category->Name()}'>{$category->Name()}</a></li>";
		}

		echo '</ul>';
		foreach ($registry->Categories() as $category)
		{
			echo "<a name='{$category->Name()}'></a><h2>{$category->Name()}</h2>";
			echo "<a href=''>Return To Top</a>";
			echo '<h3>POST Services</h3>';

			foreach ($category->Posts() as $service)
			{
				echo '<div class="service">';

				$md = $service->Metadata();
				$request = $md->Request();
				self::EchoCommon($md, $service, $app);

				echo '<h4>Request</h4>';
				if (is_object($request))
				{
					echo '<div class="code">' . json_encode($request) . '</div>';
				}
				elseif (is_null($request))
				{
					echo 'No request';
				}
				else
				{
					echo 'Unstructured request of type <i>' . $request . '</i>';
				}

				echo '</div>';
			}

			echo '<h3>GET Services</h3>';

			foreach ($category->Gets() as $service)
			{
				echo '<div class="service">';
				$md = $service->Metadata();
				self::EchoCommon($md, $service, $app);
				echo '</div>';
			}

			echo '<h3>DELETE Services</h3>';

			foreach ($category->Deletes() as $service)
			{
				echo '<div class="service">';
				$md = $service->Metadata();
				self::EchoCommon($md, $service, $app);
				echo '</div>';
			}
		}

		echo '</body></html>';
	}

	/**
	 * @param SlimServiceMetadata $md
	 * @param SlimServiceRegistration $endpoint
	 * @param Slim\Slim $app
	 */
	private static function EchoCommon(SlimServiceMetadata $md, $endpoint, Slim\Slim $app)
	{
		$response = $md->Response();
		echo "<h4>Name</h4>" . $md->Name();
		echo "<h4>Description</h4>" . str_replace("\n", "<br/>", $md->Description());
		echo '<h4>Route</h4>' . $app->urlFor($endpoint->RouteName());

		if ($endpoint->IsSecure())
		{
			echo '<h4 class="secure">This service is secure and requires authentication</h4>';
		}
		if ($endpoint->IsLimitedToAdmin())
		{
			echo '<h4 class="admin">This service is only available to application administrators</h4>';
		}

		echo '<h4>Response</h4>';
		if (is_object($response))
		{
			echo '<div class="code">' . json_encode($response) . '</div>';
		}
		elseif (is_null($response))
		{
			echo 'No response';
		}
		else
		{
			echo 'Unstructured response of type <i>' . $response . '</i>';
		}

	}
}

