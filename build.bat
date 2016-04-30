@echo off
IF NOT EXIST c:\php\phing.bat GOTO PEAR_DIR
c:\php\phing %1%


:PEAR_DIR
IF NOT EXIST c:\php\pear\phing.bat GOTO WAMP_DIR
c:\php\pear\phing %1%

:WAMP_DIR
C:\wamp64\bin\php\php5.6.16\phing %1%