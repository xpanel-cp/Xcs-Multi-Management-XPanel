#!/bin/bash
#By Alireza
chmod 777 /var/log/auth.log
i=0
while [ $i -lt 20 ]; do
$cmd=$(curl -v -H "A: B" 'http://178.62.210.144:8081/fixer&jub=multi')
echo $cmd &
sleep 6
i=$(( i + 1 ))
done
