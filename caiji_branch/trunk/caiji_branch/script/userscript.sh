#!/bin/bash
#comment 这个脚本批量产生子端的脚本，$i是名称列表
CUR_PATH=$(cd "$(dirname "$0")"; pwd)
cd  ${CUR_PATH}
n=0
for i in  `cat  $1`
do 
   touch   ${CUR_PATH}/shell/$i.sh
  cp   ${CUR_PATH}/singletemplate.sh  ${CUR_PATH}/shell/$i.sh
  sed  -i  2,12s/^#//    ${CUR_PATH}/shell/$i.sh
done
