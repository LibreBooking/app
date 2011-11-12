@echo off
IF NOT EXIST c:\php\phing.bat GOTO PEAR_DIR
c:\php\phing %1%

:PEAR_DIR
c:\php\pear\phing %1%