# write-output "Shared Web Project!!"

ii C:\xampp\xampp_start.EXE 

timeout /t 10

wt --window 0 -p "Windows Powershell" -d . powershell -noExit "php artisan serve --host 192.168.0.102 --port 8000"`;  new-tab -p "Windows Powershell" -d . powershell -noExit "npm run dev";

# timeout /t 10

# ii C:\Users\kelvi\AppData\Local\Programs\"Microsoft VS Code"\Code.EXE

# timeout /t 10

START http://192.168.0.102:8000/