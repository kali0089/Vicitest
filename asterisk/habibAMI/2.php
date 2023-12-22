<?php
$amiHost = '10.200.3.226';
$amiPort = '5038'; // Default AMI port
$amiUsername = 'admin';
$amiPassword = 'yyy';

// Asterisk Manager API connection
$amiSocket = fsockopen($amiHost, $amiPort, $errno, $errstr, 10);

if (!$amiSocket) {
    die("Unable to connect to Asterisk AMI: $errstr ($errno)\n");
}

// Log in to AMI
fputs($amiSocket, "Action: Login\r\n");
fputs($amiSocket, "Username: $amiUsername\r\n");
fputs($amiSocket, "Secret: $amiPassword\r\n\r\n");

// Wait for a moment to ensure the response is received
usleep(500000);

// Originate call
fputs($amiSocket, "Action: Originate\r\n");
fputs($amiSocket, "Channel: Local/s@testing1\r\n");
fputs($amiSocket, "Application: Dial\r\n");
fputs($amiSocket, "Data: SIP/102\r\n");
fputs($amiSocket, "CallerID: \"Test Queue\" <102>\r\n");
fputs($amiSocket, "Async: yes\r\n\r\n");

// Wait for a moment to ensure the response is received
usleep(500000);

// Send the logoff action
fputs($amiSocket, "Action: Logoff\r\n\r\n");

// Close the socket
fclose($amiSocket);
?>

