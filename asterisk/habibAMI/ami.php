<?php

$amiHost = "192.168.1.112";
$amiPort = 5038;
$amiUsername = "admin";
$amiSecret = "yyy";
$callerId = "Local/s@testing1";  // Extension or phone number initiating the call
$destinationNumber = "102";  // Extension or phone number to be called

// Construct the Originate action
$originateAction = "Action: Originate\r\nChannel: {$callerId}\r\nExten: {$destinationNumber}\r\nContext: testing1\r\nPriority: 1\r\nCallerID: Out{$destinationNumber} <{$destinationNumber}>\r\nTimeout: 10000\r\n\r\n";

// Connect to AMI using fsockopen
$amiSocket = fsockopen($amiHost, $amiPort, $errno, $errstr, 10);

if ($amiSocket) {
    // Send the login action
    fputs($amiSocket, "Action: Login\r\nUsername: {$amiUsername}\r\nSecret: {$amiSecret}\r\n\r\n");

    // Wait for the response
    usleep(500000);  // Wait for 500 milliseconds to ensure the response is received

    // Send the Originate action
    fputs($amiSocket, $originateAction);
    // Wait for the response
    usleep(500000);  // Wait for 500 milliseconds to ensure the response is received
    fputs($amiSocket, "Application: Dial\r\n");
    // Send the logoff action
    fputs($amiSocket, "Action: Logoff\r\n\r\n");

    // Close the connection
    fclose($amiSocket);
} else {
    echo "Failed to connect to AMI: {$errstr} ({$errno})";
}

?>

