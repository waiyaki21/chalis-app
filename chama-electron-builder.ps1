Start-Process "wt.exe" -ArgumentList '-p "Windows PowerShell" -d . powershell -noExit "npm run electron-build"' -Verb RunAs
