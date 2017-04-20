<?php
$db = require(__DIR__ . '/db.php');

$db['dsn'] = 'mysql:host=localhost;dbname=rgkgroup_tests';

return $db;
