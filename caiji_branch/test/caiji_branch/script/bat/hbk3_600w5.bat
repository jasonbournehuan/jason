@echo off
        set n=0
        :abc
        set /a n+=1
        D:
        cd D:\phpStudy\PHPTutorial\php\php-5.6.27-nts
        echo  ��%n%�� >>  D:/phpStudy/PHPTutorial/WWW/caipiaocj/script/logo/hbk3_600w5.txt
        php.exe D:/phpStudy/PHPTutorial/WWW/caipiaocj/collection.php -0 hbk3_600w5 >>  D:/phpStudy/PHPTutorial/WWW/caipiaocj/script/logo/hbk3_600w5.txt
        echo.  >>  D:/phpStudy/PHPTutorial/WWW/caipiaocj/script/logo/hbk3_600w5.txt
        ping 127.0.0.1 -n 2 >nul
        goto abc