#!/bin/bash
echo "SCP..."
spawn scp -r configdb/xmldata.xml pi@10.0.1.48:/home/pi/mytelldus/db/devices.xml
expect "password:"
send "lytill53\r"
