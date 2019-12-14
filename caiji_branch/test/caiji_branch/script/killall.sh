#!/bin/bash
A=$(cd "$(dirname "$0")"; pwd)
n=0
#cd /trunk/caiji_branch/batsh
#for i in `ps -ef | grep root | grep /bin/bash|php |  awk '{print $2}'`
for i in `ps -ef | grep  /bin/bash  |  grep  /opt/app/caiji_branch/trunk/caiji_branch/script/shell   |  awk '{print $2}'`
do 
   kill  -9  $i
   echo "$i 已被杀死"
   sleep 1
   let "n++"
  echo "已经杀死了$n个了！"
   #if [ $n - ge 56 ] ; then
   # echo "$i已经被杀死"
   # exit 0
   #fi
done
