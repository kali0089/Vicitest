#!/bin/bash

AMI_HOST="10.200.3.226"
AMI_PORT="5038"
AMI_USERNAME="admin"
AMI_SECRET="yyy"
CALLER_ID="100"  # Extension or phone number initiating the call
DESTINATION_NUMBER="101"  # Extension or phone number to be called

# Construct the Originate action
ORIGINATE_ACTION="Action: Originate\r\nChannel: SIP/${CALLER_ID}\r\nExten: ${DESTINATION_NUMBER}\r\nContext: testing1\r\nPriority: 1\r\nCallerID: ${CALLER_ID} <${CALLER_ID}>\r\nTimeout: 30000\r\n\r\n"

# Connect to AMI using telnet
echo -e "Action: Login\r\nUsername: ${AMI_USERNAME}\r\nSecret: ${AMI_SECRET}\r\n\r\n" | telnet ${AMI_HOST} ${AMI_PORT}

# Send the Originate action
echo -e ${ORIGINATE_ACTION} | telnet ${AMI_HOST} ${AMI_PORT}

AMI_RESPONSE=$(echo -e ${ORIGINATE_ACTION} | telnet ${AMI_HOST} ${AMI_PORT})
echo "Response from AMI: ${AMI_RESPONSE}"

# Logout from AMI
echo -e "Action: Logoff\r\n\r\n" | telnet ${AMI_HOST} ${AMI_PORT}
