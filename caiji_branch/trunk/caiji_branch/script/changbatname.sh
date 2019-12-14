#!/bin/bash
#comment 这个脚本批量获取bat格式文件的文件名称放到userlist中
CUR_PATH=$(cd "$(dirname "$0")"; pwd)
cd  /var/lib/jenkins/workspace/prod_caiji_branch/caiji_branch/collection

for i in  `ls  *.php`
do 
A=$i
   echo  ${A%%.*}  >>  ${CUR_PATH}/userlist.txt 
done
