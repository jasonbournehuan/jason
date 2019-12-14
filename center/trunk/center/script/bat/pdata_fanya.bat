@echo off
        set n=0
        :abc
        set /a n+=1
        D:
        cd D:\phpStudy\PHPTutorial\php\php-5.6.27-nts
        echo  µÚ%n%´Î >>  D:/phpStudy/PHPTutorial/WWW/script/logo/pdata_fanya.txt
        php.exe D:/phpStudy/PHPTutorial/WWW/pdata_fanya.php  >>  D:/phpStudy/PHPTutorial/WWW/script/logo/pdata_fanya.txt
        echo.  >>  D:/phpStudy/PHPTutorial/WWW/script/logo/pdata_fanya.txt
        ping 127.0.0.1 -n 60 >nul
        goto abc