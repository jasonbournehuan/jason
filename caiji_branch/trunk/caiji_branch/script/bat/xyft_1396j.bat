@echo off
        set n=0
        :abc
        set /a n+=1
        D:
        cd D:\phpStudy\PHPTutorial\php\php-5.6.27-nts
        echo  µÚ%n%´Î >>  D:/phpStudy/PHPTutorial/WWW/caipiaocj/script/logo/xyft_1396j.txt
        php.exe D:/phpStudy/PHPTutorial/WWW/caipiaocj/collection.php -0 xyft_1396j >>  D:/phpStudy/PHPTutorial/WWW/caipiaocj/script/logo/xyft_1396j.txt
        echo.  >>  D:/phpStudy/PHPTutorial/WWW/caipiaocj/script/logo/xyft_1396j.txt
        ping 127.0.0.1 -n 2 >nul
        goto abc