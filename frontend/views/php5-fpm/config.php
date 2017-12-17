<?php
/**
 * Created by PhpStorm.
 * User: Lars
 * Date: 17.12.2017
 * Time: 14:19
 *
 * @var string $unixUserName
 * @var string $unixUserGroup
 * @var string $slowLogPath
 * @var string $tmpPath
 */

?>

[site]
listen = 127.0.0.1:9000
user = <?= $unixUserName ?>
group = <?= $unixUserGroup ?>
request_slowlog_timeout = 5s
slowlog = <?= $slowLogPath ?>
listen.allowed_clients = 127.0.0.1
pm = dynamic
pm.max_children = 5
pm.start_servers = 3
pm.min_spare_servers = 2
pm.max_spare_servers = 4
pm.max_requests = 200
listen.backlog = -1
pm.status_path = /status
request_terminate_timeout = 120s
rlimit_files = 131072
rlimit_core = unlimited
catch_workers_output = yes
env[HOSTNAME] = $HOSTNAME
env[TMP] = <?= $tmpPath ?>
env[TMPDIR] = <?= $tmpPath ?>
env[TEMP] = <?= $tmpPath ?>
