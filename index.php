<?php
/**
 * Created by PhpStorm.
 * User: tomkarho
 * Date: 6.4.2017
 * Time: 17:56
 */

function printMessage($message)
{
    echo "$message\r\n";
}

printMessage("Starting renamer");

$fileSource = readline("Provide source of the files to rename: ");
$renameTarget = $fileSource . "/../renamed";

if (!is_dir($fileSource)) {
    printMessage("{$fileSource} is not a valid path.  Exiting.");
    return 1;
}

printMessage("Reading path '{$fileSource}'");

$files = array_diff(scandir($fileSource), array('..', '.'));

printMessage(count($files) . " files found from directory.");

foreach ($files as $fileName) {

    $sourcePath = "{$fileSource}/{$fileName}";
    printMessage("Handling file {$fileName}");

    // Split first numbers
    $parts = explode(" ", $fileName);

    if(count($parts) > 1 && preg_match('/[^A-Za-z]/', $parts[0])) {
        array_splice($parts, 0, 1);
        $fileName = implode(" ", $parts);
    }

    // strip artist name from file
    $parts = explode(" - ", $fileName);

    if(count($parts) === 2) {
        array_splice($parts, 0, 1);
        $fileName = implode(" ", $parts);
    }

    printMessage($fileName);


    $targetPath = "{$renameTarget}/{$fileName}";

    copy($sourcePath, $targetPath);
}