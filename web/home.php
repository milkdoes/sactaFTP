<?php

// set up basic connection
$conn_id = ftp_connect('localhost');

// login with username and password
$login_result = ftp_login($conn_id, 'test1', '123');

// get the file list for /
$buff = ftp_rawlist($conn_id, '/');

// close the connection
ftp_close($conn_id);

// output the buffer
var_dump($buff);
?>
