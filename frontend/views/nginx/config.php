<?php
/**
 * Created by PhpStorm.
 * User: Lars
 * Date: 17.12.2017
 * Time: 12:43
 *
 * @property string $siteName
 * @property array $siteAliases
 * @property string $tmpPath
 * @property string $logPath
 */
?>

server {
listen        <?= $siteName ?>;
server_name   <?= implode(' ', $siteAliases) ?>;

access_log   <?= $logPath ?>  main;

location / {
    proxy_pass         http://127.0.0.1/;
    proxy_redirect     off;

    proxy_set_header   Host             $host;
    proxy_set_header   X-Real-IP        $remote_addr;
    #proxy_set_header  X-Forwarded-For  $proxy_add_x_forwarded_for;

    client_max_body_size       10m;
    client_body_buffer_size    128k;

    client_body_temp_path      <?= $tmpPath ?>;

    proxy_connect_timeout      70;
    proxy_send_timeout         90;
    proxy_read_timeout         90;
    proxy_send_lowat           12000;

    proxy_buffer_size          4k;
    proxy_buffers              4 32k;
    proxy_busy_buffers_size    64k;
    proxy_temp_file_write_size 64k;

    proxy_temp_path            <?= $tmpPath ?>;

    charset  koi8-r;
}
    error_page  404  /404.html;
}
