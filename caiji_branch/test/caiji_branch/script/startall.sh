#!/bin/bash
cd  /opt/app/caiji_branch/trunk/caiji_branch/script/shell
n=0
for i in  `ls  *.sh`
do 
   chmod +x   /opt/app/caiji_branch/trunk/caiji_branch/script/shell/$i
   sudo   /opt/app/caiji_branch/trunk/caiji_branch/script/shell/$i  $1   &  
   echo "$i 已经运行了！"
  let n++
   echo "$n个运行了"
done
