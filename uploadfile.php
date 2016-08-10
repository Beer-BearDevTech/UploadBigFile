<?php
function base64ToFile($outputFile) {
	try{
		$tempFile = "tempFile";
		$ifpTemp = fopen($tempFile, "r"); 
		$base64String = fread($ifpTemp,filesize($tempFile));
		fclose($ifpTemp);
		
		
		$ifpOutput = fopen($outputFile, "wb");
		$data = explode(',', $base64String);
		fwrite($ifpOutput, base64_decode($data[1])); 
		fclose($ifpOutput);
	}catch(Exception $e) {
		throw new Exception("Can't convert to file.");
	}
	return $outputFile; 
}
function unZipFile($outputFile){
	try{
		$zip = new ZipArchive;
		$res = $zip->open($outputFile);
		if ($res === TRUE) {
			$zip->extractTo('izezad/');
			$zip->close();
			return $outputFile;
		} else {
			throw new Exception("File is not Zip type.");
		}
	}catch(Exception $e) {
		throw new Exception("Can't unzip file.");
	}
}
try{
	$base64String = $_POST["base64String"];
	$tempFile = "tempFile";
	if($_POST["append"]=="start"){ 
		unlink($tempFile);
		file_put_contents($tempFile, $base64String , FILE_APPEND);
	} else if($_POST["append"]=="append"){ 
		file_put_contents($tempFile, $base64String , FILE_APPEND);
	} else if($_POST["append"]=="finish"){
		file_put_contents($tempFile, $base64String , FILE_APPEND);
		$outputFile = base64ToFile("finishFile.zip");
		unZipFile($outputFile);
	}
	echo "OK";
}catch(Exception $e) {
	echo 'Message: ' .$e->getMessage();
}

