@echo off
        set n=0
        :abc
        set /a n+=1
        D:
        cd D:\phpStudy\PHPTutorial\php\php-5.6.27-nts
        echo  ��%n%�� >>  D:/phpStudy/PHPTutorial/WWW/script/logo/pdata_bbin1_2.txt
        php.exe D:/phpStudy/PHPTutorial/WWW/pdata_bbin1_2.php  >>  D:/phpStudy/PHPTutorial/WWW/script/logo/pdata_bbin1_2.txt
        echo.  >>  D:/phpStudy/PHPTutorial/WWW/script/logo/pdata_bbin1_2.txt
        ping 127.0.0.1 -n 60 >nul
        goto abc