
wt --window 0 -p "Windows PowerShell" -d . powershell -noExit "php artisan serve" ; `
    wt -p "Windows PowerShell" -d . powershell -noExit "npm run dev" ; `
    wt -p "Windows PowerShell" -d . powershell -noExit "start http://localhost:8000/"
