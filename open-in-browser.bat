@echo off
setlocal

set "URL=http://127.0.0.1:8000"

where chrome >nul 2>nul
if %errorlevel%==0 (
    start "" chrome "%URL%"
    exit /b 0
)

start "" "%URL%"