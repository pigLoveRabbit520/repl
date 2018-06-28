<?php
require __DIR__ . '/DB.php';
ini_set('date.timezone','Asia/Shanghai');
$db = new DB();
$db->__setup([
    'dsn'=>'mysql:dbname=db_;host=127.0.0.1;port=3308',
    'username'=>'root',
    'password'=>'yVHytbH8tcYkHU2P',
    'charset'=>'utf8mb4'
]);

for (;;) {
	$res = $db->fetchColumn('SELECT time FROM heartbeat');
	if (!$res) {
		echo "get time failed\n";
	} else {
		$now = new \DateTime();
		$server_time = new \DateTime($res);
		$inter = $now->diff($server_time);
		$seconds = $now->getTimestamp() - $server_time->getTimestamp();
		$millionseconds =  round(($now->format('u') - $server_time->format('u')) / 1000) + $seconds * 1000;
		echo "delay {$millionseconds}ms\n";
	}
}