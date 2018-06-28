<?php
require __DIR__ . '/DB.php';
ini_set('date.timezone','Asia/Shanghai');
$db = new DB();
$db->__setup([
    'dsn'=>'mysql:dbname=db_name;host=127.0.0.1;port=3307',
    'username'=>'root',
    'password'=>'STi7hXedI5vxnRgJ',
    'charset'=>'utf8mb4'
]);


// u 毫秒 （PHP 5.2.2 新加）。需要注意的是 date() 函数总是返回 000000 因为它只接受 integer 参数
// http://php.net/manual/zh/function.date.php
for (;;) {
	echo (new \DateTime())->format('Y-m-d H:i:s.u') . PHP_EOL;
	$res = $db->update('heartbeat', ['time' => (new \DateTime())->format('Y-m-d H:i:s.u')]);
	if (!$res) {
		echo "update heartbeat failed\n";
	} else {
		echo "updated\n";
	}
	sleep(1);
}