<?php

require 'settings.php';

try
{
    $con = new PDO('mysql:host=' . $config['HOST'] . ';dbname=' . $config['DB'] . ';charset=utf8', $config['USER'], $config['PASS']);
    $con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
}
catch(PDOException $e)
{
    die('Server has encountered an unexpected error, please contact administration!');
}

?>
