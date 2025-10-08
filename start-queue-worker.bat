@echo off
echo Demarrage du worker de queue Laravel...
echo Appuyez sur Ctrl+C pour arreter
php artisan queue:work --verbose --tries=3 --timeout=90
pause
