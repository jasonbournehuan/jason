@echo off
        set n=0
        :abc
        set /a n+=1
        D:
        cd D:\phpStudy\PHPTutorial\php\php-5.6.27-nts
        echo  ��%n%�� >>  D:/phpStudy/PHPTutorial/WWW/caipiaocj/script/logo/xjssc_ig185.txt
        php.exe D:/phpStudy/PHPTutorial/WWW/caipiaocj/collection.php -0 xjssc_ig185 >>  D:/phpStudy/PHPTutorial/WWW/caipiaocj/script/logo/xjssc_ig185.txt
        echo.  >>  D:/phpStudy/PHPTutorial/WWW/caipiaocj/script/logo/xjssc_ig185.txt
        ping 127.0.0.1 -n 2 >nul
        goto abc