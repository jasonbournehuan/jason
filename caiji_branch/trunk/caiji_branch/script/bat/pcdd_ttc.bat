@echo off
        set n=0
        :abc
        set /a n+=1
        D:
        cd D:\phpStudy\PHPTutorial\php\php-5.6.27-nts
        echo  µÚ%n%´Î
        php.exe D:/phpStudy/PHPTutorial/WWW/caipiaocj/collection.php -0 pcdd_ttc
        echo.
        timeout 2 > null
        goto abc