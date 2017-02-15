<?php

/*
  Uploadify
  Copyright (c) 2012 Reactive Apps, Ronnie Garcia
  Released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
 */


define('ABSPATH', dirname(__FILE__));

// Define a destination
$targetFolder = ABSPATH.'/../../../arquivos'; // Relative to the root


if (!empty($_FILES)/* && $_POST['token'] == $verifyToken */) {
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $targetPath = $targetFolder;
    $targetFile = rtrim($targetPath, '/') . '/' . $_FILES['Filedata']['name'];

    // Validate the file type
    $fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // File extensions
    $fileParts = pathinfo($_FILES['Filedata']['name']);

    //if (in_array($fileParts['extension'], $fileTypes)) {
        move_uploaded_file($tempFile, $targetFile);
        
        echo $_FILES['Filedata']['name'];
    //} else {
    //    echo 'Invalid file type.';
    //}
}

function verify_dir($folder) {
    if (!is_dir($folder))
        mkdir($folder);
}

?>