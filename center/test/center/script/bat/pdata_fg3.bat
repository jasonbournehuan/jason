@echo off
        set n=0
        :abc
        set /a n+=1
        D:
        cd D:\phpStudy\PHPTutorial\php\php-5.6.27-nts
        echo  µÚ%n%´Î >>  D:/phpStudy/PHPTutorial/WWW/script/logo/pdata_fg3.txt
        php.exe D:/phpStudy/PHPTutorial/WWW/pdata_fg3.php  >>  D:/phpStudy/PHPTutorial/WWW/script/logo/pdata_fg3.txt
        echo.  >>  D:/phpStudy/PHPTutorial/WWW/script/logo/pdata_fg3.txt
        ping 127.0.0.1 -n 60 >nul
        goto abc