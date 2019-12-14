#!/bin/bash

CUR_PATH=$(cd "$(dirname "$0")"; pwd)

# Ҫ¶¨ʱִÐµÄÎñSK_COM
TASK_COMMAND="php ${CUR_PATH}/../../heartbeat.php"
# ҪÌ¼ӵÄrontabÈÎ
CRONTAB_TASK="* * * * * ${TASK_COMMAND}"
# ±¸·Ý­ʼcrontab¼Ç¼Î¼þ
CRONTAB_BAK_FILE="${CUR_PATH}/crontab_bak"

# ´´½¨crontabÈÎº¯Ê
function create_crontab()
{
    echo 'Create crontab task...'
    crontab -l > ${CRONTAB_BAK_FILE} 2>/dev/null
    sed -i "/.*${TASK_COMMAND}/d" ${CRONTAB_BAK_FILE}  
    echo "${CRONTAB_TASK}" >> ${CRONTAB_BAK_FILE}
    crontab ${CRONTAB_BAK_FILE}
    echo 'Complete'
}

# Ç³ýabÈÎº¯Ê
function clear_crontab(){
    echo 'Delete crontab task...'
    crontab -l > ${CRONTAB_BAK_FILE} 2>/dev/null
    sed -i "/.*${SCRIPT_NAME}/d" ${CRONTAB_BAK_FILE}
    crontab ${CRONTAB_BAK_FILE}
    echo 'Complete'
}

if [ $# -lt 1 ]; then
    echo "Usage: $0 [start | stop]"
    exit 1
fi

case $1 in
    'start' )
        create_crontab
        ;;
    'stop' )
        clear_crontab
        ;;
esac
