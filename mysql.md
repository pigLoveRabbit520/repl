# 相关配置
### 主库
```
log-bin=mysql-bin
server_id=854 #server_id不要和slave重复即可
sync_binlog=1
innodb_flush_log_at_trx_commit=1
```
### 备库
```
log-bin=mysql-bin
server_id=589
relay_log=mysql-relay-bin
read_only=1
log_slave_updates=1
```

# 操作集

## 创建复制用户
`grant REPLICATION SLAVE, REPLICATION CLIENT on *.* to 'repl'@'192.168.100.%' IDENTIFIED BY 'password';`


## 上锁
`flush tables with read lock;`

## 获取master binlog的坐标
`show master status;`

## dump数据
--master-data会自动加上全局锁，注意末尾没分号  
`mysqldump -uroot -p --databases db_name --master-data=2 > dump.db`  
`shell > grep -i -m 1 'change master to' dump.db`（直接文件里也可以查坐标）

## 复制到slave
`mysql -uroot -p -h 192.168.100.150 -e 'source dump.db'`

## slave启动复制
shell（\表示换行）
```
change master to \
        master_host='192.168.100.20', \
        master_port=3306, \
        master_user='repl', \
        master_password='P@ssword1!', \
        master_log_file='master-bin.000002', \
        master_log_pos=154;
```
powershell（不带\）
```
change master to
        master_host='192.168.100.20',
        master_port=3306,
        master_user='repl',
        master_password='P@ssword1!',
        master_log_file='master-bin.000002',
        master_log_pos=154;
```

启动
`start slave;`

## 查看复制状态
`show slave status;`


# docker中注意事项
* 复制用户允许IP地址应为`%`，如`'repl'@'%'`
* docker中`master_host`应该写入service名