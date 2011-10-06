<?php
    define('ROOT_DIR', 'C:/Users/Michael Pinnegar/Desktop/xampp/htdocs/development/');
    require_once('Drupal.php');
    
    $registration = new Drupal();
    //Using the userID as the username
    //Using the normal password before MD5 as password
    echo '<BR>' . $registration->Validate(1,'');
    
    ?>
    