<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require dirname(__DIR__) . '/vendor/autoload.php';

use Coded\Memory\Ram;
use Coded\Memory\Session;
use Coded\Memory\Cookie;
use Coded\Memory\Database;

session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Memory Library</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>

<body>

<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Memory Library</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="http://php.net" target="_blank">PHP</a></li>
                <li><a href="https://github.com/codedgr/cache" target="_blank">GitHub</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container" role="main">
    <h2>Ram Memory</h2>
    <?php
    Ram::init();
    Ram::add('text', 'example with key text');
    Ram::add('text', 'example with key text overwrite');

    ?>
    <pre><?php echo Ram::get('text'); ?></pre>

    <h2>Cookie Memory</h2>
    <?php
    Cookie::add('text', 'example with key text', strtotime('+30 seconds'));
    ?>
    <pre><?php echo Cookie::get('text'); ?></pre>

    <h2>Session Memory</h2>
    <?php
    Session::init();
    Session::add('text', 'example with key text');
    Session::add('text', 'example with key text overwrite');
    ?>
    <pre><?php echo Session::get('text'); ?></pre>

    <h2>Database Memory</h2>
    <?php
    $username = '';
    $password = '';

    if($username){
        $pdo = new PDO('mysql:dbname=phpunit;host=10.0.0.200', $username, $password);

        Database::init($pdo);
        Database::getObject()->createTable();
        Database::getObject()->truncateTable();
        Database::add('text', 'example with key text');
        Database::add('text', 'example with key text overwrite');
        ?>
        <pre><?php echo Database::get('text'); ?></pre>
        <?php
        Database::getObject()->dropTable();
    }
    ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>