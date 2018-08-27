<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '../application/util/PostgreSQLConnectionManager.class.php';

$postgresConn = PostgreSQLConnectionManager::getInstance();

//print_r($postgresConn);

$query = 'insert into gdr_user (username,password) values(\'test3\',\'test3\')';

$list = $postgresConn->executeTransaction($query);

echo '<pre>';
print_r($list);
echo '</pre>';