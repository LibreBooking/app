<?php

class ApiHelpPage
{
    public static function Render(SlimWebServiceRegistry $registry, Slim\Slim $app)
    {
        $head = <<<EOT
	<!DOCTYPE html>
	    <html>
	        <head>
	            <meta charset="utf-8"/>
	            <title>LibreBooking API Documentation</title>
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
	            <h1>LibreBooking API Documentation</h1>
EOT;

        $security = sprintf(
            "<div id='security'>Pass the following headers for all secure service calls: <span>%s</span> and <span>%s</span></div>",
            WebServiceHeaders::SESSION_TOKEN,
            WebServiceHeaders::USER_ID
        );
        echo $head . "\n";

        echo $security . "\n";

        echo '<ul>' . "\n";

        foreach ($registry->Categories() as $category) {
            echo "<li><a href='#{$category->Name()}'>{$category->Name()}</a></li>" . "\n";
        }

        echo '</ul>' . "\n";
        foreach ($registry->Categories() as $category) {
            echo "<a name='{$category->Name()}'></a><h2>{$category->Name()}</h2>" . "\n";
            echo "<a href=''>Return To Top</a>" . "\n";
            echo '<h3>POST Services</h3>' . "\n";

            foreach ($category->Posts() as $service) {
                echo '<div class="service">' . "\n";

                $md = $service->Metadata();
                $request = $md->Request();
                self::EchoCommon($md, $service, $app);

                echo '<h4>Request</h4>' . "\n";
                if (is_object($request)) {
                    echo '<div class="code"><pre>' . json_encode($request, JSON_PRETTY_PRINT) . '</pre></div>' . "\n";
                } elseif (is_null($request)) {
                    echo 'No request' . "\n";
                } else {
                    echo 'Unstructured request of type <i>' . $request . '</i>' . "\n";
                }

                echo '</div>' . "\n";
            }

            echo '<h3>GET Services</h3>' . "\n";

            foreach ($category->Gets() as $service) {
                echo '<div class="service">' . "\n";
                $md = $service->Metadata();
                self::EchoCommon($md, $service, $app);
                echo '</div>' . "\n";
            }

            echo '<h3>DELETE Services</h3>' . "\n";

            foreach ($category->Deletes() as $service) {
                echo '<div class="service">' . "\n";
                $md = $service->Metadata();
                self::EchoCommon($md, $service, $app);
                echo '</div>' . "\n";
            }
        }

        echo '</body></html>' . "\n";
    }

    /**
     * @param SlimServiceMetadata $md
     * @param SlimServiceRegistration $endpoint
     * @param Slim\Slim $app
     */
    private static function EchoCommon(SlimServiceMetadata $md, $endpoint, Slim\Slim $app)
    {
        $response = $md->Response();
        echo "<h4>Name</h4>" . $md->Name() . "\n";
        echo "<h4>Description</h4>" . str_replace("\n", "<br/>", $md->Description()) . "\n";
        echo '<h4>Route</h4>' . $app->urlFor($endpoint->RouteName()) . "\n";

        if ($endpoint->IsSecure()) {
            echo '<h4 class="secure">This service is secure and requires authentication</h4>' . "\n";
        }
        if ($endpoint->IsLimitedToAdmin()) {
            echo '<h4 class="admin">This service is only available to application administrators</h4>' . "\n";
        }

        echo '<h4>Response</h4>' . "\n";
        if (is_object($response)) {
            echo '<div class="code"><pre>' . json_encode($response, JSON_PRETTY_PRINT) . '</pre></div>' . "\n";
        } elseif (is_null($response)) {
            echo 'No response' . "\n";
        } else {
            echo 'Unstructured response of type <i>' . $response . '</i>' . "\n";
        }
    }
}
