#!/bin/bash
time=`date "+%Y-%m-%d %H:%M:%S"`
prefix="/opt/app/zz/center"
cd $prefix
for file in `ls -lh  *.php  | awk '{print  $9}' | grep  "^pd"`
do
  logfile=`echo $file | awk -F "." '{print $1}'`
  echo "=================================$time开始运行=============================" >> /logs/"$logfile".log 2>&1
  /usr/bin/php /opt/app/zz/center/$file  >> /logs/"$logfile".log   2>&1
  echo "=================================$time结束运行=============================" >> /logs/"$logfile".log 2>&1
done
