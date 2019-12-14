@echo off
for /r %%a in (*.bat) do (
    if /i "%%~xa"==".bat" (
        if /i not "%%~nxa"=="%~nx0" start "" "%%~a"
    )
)
