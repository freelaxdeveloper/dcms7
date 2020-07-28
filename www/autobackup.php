<?php
require_once 'sys/inc/start.php';

$mysqldump = "mysqldump --user=root --password=root dcms > test.sql";

exec($mysqldump);

// mysqldump --login-path=local dcms > "/var/backups/dcms-"`date +"%Y-%m-%d_%H:%M:%S"`".sql"