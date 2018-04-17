<?php
// Alert all errors.
ini_set('display_errors', true);
error_reporting(E_ALL);

// Start session if it has not already started.
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

function ftp_rdel($handle, $path) {

	if (@ftp_delete ($handle, $path) === false) {

	    if ($children = @ftp_nlist ($handle, $path)) {
	      	foreach ($children as $p)
	        	ftp_rdel ($handle,  $p);
	    }

    	@ftp_rmdir ($handle, $path);
  	}
}

Class FTPClient
{
	// *** Class variables
	private $connectionId;
	private $loginOk = false;
	private $messageArray = array();

	public function __construct() { }

	private function logMessage($message)
	{
		$this->messageArray[] = $message;
	}

	public function getMessages()
	{
		return $this->messageArray;
	}

	public function connect ($server, $ftpUser, $ftpPassword, $isPassive = true)
	{
		// *** Set up basic connection
		$this->connectionId = ftp_connect($server);

		// *** Login with username and password
		$loginResult = ftp_login($this->connectionId, $ftpUser, $ftpPassword);

		// *** Sets passive mode on/off (default on)
		ftp_pasv($this->connectionId, $isPassive);

		// *** Check connection
		if ((!$this->connectionId) || (!$loginResult)) {
			$this->logMessage('FTP connection has failed!');
			$this->logMessage('Attempted to connect to ' . $server . ' for user ' . $ftpUser, true);
			return false;
		} else {
			$this->logMessage('Connected to ' . $server . ', for user ' . $ftpUser);
			$this->loginOk = true;
			return true;
		}
	}

	public function makeDir($directory)
	{
		// *** If creating a directory is successful...
		if (ftp_mkdir($this->connectionId, $directory)) {

			$this->logMessage('Directory "' . $directory . '" created successfully');
			return true;

		} else {

			// *** ...Else, FAIL.
			$this->logMessage('Failed creating directory "' . $directory . '"');
			return false;
		}
	}

	public function uploadFile ($fileFrom, $fileTo)
	{
		// *** Set the transfer mode
		$asciiArray = array('txt', 'csv');
		$splitString = explode('.', $fileFrom);
		$extension = end($splitString);
		if (in_array($extension, $asciiArray)) {
			$mode = FTP_ASCII;
		} else {
			$mode = FTP_BINARY;
		}

		// *** Upload the file
		$upload = ftp_put($this->connectionId, $fileTo, $fileFrom, $mode);

		// *** Check upload status
		if (!$upload) {
			$this->logMessage('FTP upload has failed!');
			return false;

		} else {
			$this->logMessage('Uploaded "' . $fileFrom . '" as "' . $fileTo);
			return true;
		}
	}

	public function changeDir($directory)
	{
		if (ftp_chdir($this->connectionId, $directory)) {
			$this->logMessage('Current directory is now: ' . ftp_pwd($this->connectionId));
			return true;
		} else {
			$this->logMessage('Couldn\'t change directory');
			return false;
		}
	}

	public function getDirListing($directory = '.', $parameters = '-la')
	{
		// get contents of the current directory
		$contentsArray = ftp_nlist($this->connectionId, $parameters . ' ' . $directory);

		return $contentsArray;
	}

	public function getRawDirListing($directory = '.')
	{
		// get contents of the current directory
		$contentsArray = ftp_rawlist($this->connectionId, $directory);

		return $contentsArray;
	}

	public function downloadFile ($fileFrom, $fileTo)
	{
		// *** Set the transfer mode
		$asciiArray = array('txt', 'csv');
		$tmp = explode('.', $fileFrom);
		$extension = end($tmp);
		if (in_array($extension, $asciiArray)) {
			$mode = FTP_ASCII;
		} else {
			$mode = FTP_BINARY;
		}

		// try to download $remote_file and save it to $handle
		if (ftp_get($this->connectionId, $fileTo, $fileFrom, $mode, 0)) {

			return true;
			$this->logMessage(' file "' . $fileTo . '" successfully downloaded');
		} else {

			return false;
			$this->logMessage('There was an error downloading file "' . $fileFrom . '" to "' . $fileTo . '"');
		}

	}

	function copyPaste($file, $dirCopiados, $dirDestino)
	{ 
        // *** Set the transfer mode
		$asciiArray = array('txt', 'csv');
		$tmp = explode('.', $file);
		$extension = end($tmp);
		if (in_array($extension, $asciiArray)) {
			$mode = FTP_ASCII;
		} else {
			$mode = FTP_BINARY;
		}

		// Cambiar a dirCopiados
		if (ftp_chdir($this->connectionId, $dirCopiados)) {
			$this->logMessage('Current directory is now: ' . $dirCopiados);
		} else {
			$this->logMessage('Couldn\'t change directory');
		}

		// Descargar archivo a copiar en /tmp/
		if (ftp_get($this->connectionId, '/tmp/' . $file, $file, $mode, 0)) {
			$this->logMessage(' file "' . $file . '" successfully downloaded');
		} else {
			$this->logMessage('There was an error downloading file "' . $file . '" to /tmp/');
		}

		// Cambiar a dirDestino
		if (ftp_chdir($this->connectionId, $dirDestino)) {
			$this->logMessage('Current directory is now: ' . $dirDestino);
		} else {
			$this->logMessage('Couldn\'t change directory');
		}

		// Subir archivo de /tmp/
		$upload = ftp_put($this->connectionId, $dirDestino . $file, '/tmp/' . $file, $mode);

		// *** Check upload status
		if (!$upload) {
			$this->logMessage('FTP upload has failed!');
			unlink('/tmp/' . $file);
			return false;

		} else {
			$this->logMessage('Uploaded "' . $file . '" as "' . $dirDestino . $file);
			unlink('/tmp/' . $file);
			return true;
		}
		
	}

	public function deleteFile ($fileName)
	{	

		if(substr($fileName, -1) == "/"){
			if (ftp_rdel($this->connectionId, $fileName)) {
				$this->logMessage(' folder "' . $fileName . '" successfully deleted');
				return true;
				
			} else {
				$this->logMessage('There was an error deleting folder "' . $fileName . '"');
				return false;

			}
		} else {
			// try to delete $fileName
			if (ftp_delete($this->connectionId, $fileName)) {
				$this->logMessage(' file "' . $fileName . '" successfully deleted');
				return true;
				
			} else {
				$this->logMessage('There was an error deleting file "' . $fileName . '"');
				return false;
				
			}
		}	
	}

	public function __deconstruct()
	{
		if ($this->connectionId) {
			ftp_close($this->connectionId);
		}
	}
}
?>
