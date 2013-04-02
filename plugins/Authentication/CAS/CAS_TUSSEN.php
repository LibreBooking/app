<?php

include_once('CAS-1.3.1/CAS.php');

//phpCAS::setDebug('/tmp/phpCAS.log'); // Schrijft debug informatie naar een log-file

// Parameters: CAS versie, url CAS server, poort CAS server, CAS server URI (idem als host),
// boolean die aangeeft of sessie moet gestart worden, communicatieprotocol (SAML) tussen toepassing en CAS server
phpCAS::client(SAML_VERSION_1_1, 'login.ugent.be',443,'', true, 'saml');

// Geeft aan vanaf welke server logout requests mogelijk zijn
phpCAS::handleLogoutRequests(true, array('cas1.ugent.be','cas2.ugent.be','cas3.ugent.be','cas4.ugent.be','cas5.ugent.be','cas6.ugent.be'));

// Configuratie van het certificaat van de CAS server
phpCAS::setExtraCurlOption(CURLOPT_SSLVERSION, 3);
// Locatie van het "trusted certificate authorities" bestand:
phpCAS::setCasServerCACert('/etc/ssl/certs/ca-certificates.crt');
// Geen server verificatie (minder veilig!):
//phpCAS::setNoCasServerValidation();
// Hier gebeurt de authenticatie van de gebruiker
phpCAS::forceAuthentication();

// Opvangen van logout requests
if (isset($_REQUEST['logout'])) {
        phpCAS::logout();
}


?>

<html>
  <head>
    <title>phpCAS simple client</title>
  </head>
  <body>
    <h1>Successfull Authentication!</h1>

    <p>the user's login is <b><?php echo phpCAS::getUser(); ?></b>.</p>
    <p>the attributes are:
    <?php
    echo '<ul>';
    $attr = phpCAS::getAttributes();
    foreach ($attr as $key => $value)
    {
        if(!is_array($value))
        {
                echo '<li>' . $key . ' => ' . $value . '</li>';
        }
        else
        {
                echo '<li>' . $key . '</li>';
                echo '<ul>';
                foreach($value as $v)
                {
                        echo '<li>' . $v . '</li>';
                }
                echo '</ul>';
        }
    }
    echo '</ul>';

   var_dump($_SESSION);

    ?>

    </p>
    <p>phpCAS version is <b><?php echo phpCAS::getVersion(); ?></b>.</p>
    <p><a href="?logout=">Logout</a></p>

  </body>
</html>

