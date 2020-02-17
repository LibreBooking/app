@echo off
rem IF NOT EXIST c:\php\phing-2.16.3.phar GOTO PEAR_DIR
vendor\phing\phing\bin\phing %1%


:PEAR_DIR
IF NOT EXIST c:\php\pear\phing.bat GOTO WAMP_DIR
c:\php\pear\phing %1%

:WAMP_DIR
C:\wamp64\bin\php\php5.6.16\phing %1%