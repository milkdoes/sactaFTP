<?php
session_start();
// set up basic connection
$ftp_server = 'localhost';
$conn_id = ftp_connect($ftp_server); 


// login with username and password
$login_result = ftp_login($conn_id, $_SESSION['ftp_user'], $_SESSION['ftp_pass']); 

// check connection
if ((!$conn_id) || (!$login_result)) { 
        echo "FTP connection has failed!";
        echo "Attempted to connect to $ftp_server for user " . $_SESSION['ftp_user']; 
        exit; 
    } else {
        echo "Connected to $ftp_server, for user " . $_SESSION['ftp_user'];
    }

// upload the file
echo "<br>";
$destination_file =  $_FILES["fileToUpload"]["name"];
$source_file = $_FILES["fileToUpload"]["tmp_name"];
echo $_FILES["fileToUpload"]["tmp_name"];
$upload = ftp_put($conn_id, $destination_file, $source_file, FTP_BINARY); 

// check upload status
if (!$upload) { 
        echo "FTP upload has failed!";
    } else {
        echo "Uploaded $source_file to $ftp_server as $destination_file";
    }

// close the FTP stream 
ftp_close($conn_id); 

header('Location: ../../home.php');
?>