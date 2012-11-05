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
class ApiHelpPage
{
	public static function Render(SlimWebServiceRegistry $registry, Slim\Slim $app)
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
						margin-bottom: 4px;
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
				self::EchoCommon($md, $post, $app);

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
				self::EchoCommon($md, $post, $app);
				echo '</div>';
			}
		}

		echo '</body></html>';
	}

	private static function EchoCommon(SlimServiceMetadata $md, $post, Slim\Slim $app)
	{
		$response = $md->Response();
		echo "<h4>Name</h4>" . $md->Name();
		echo "<h4>Description</h4>" . $md->Description();
		echo '<h4>Route</h4>' . $app->urlFor($post->RouteName());

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

?>