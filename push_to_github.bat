@echo off
echo =======================================================
echo     MENGUNGGAH PROYEK LARAVEL KE GITHUB (MinGit)
echo =======================================================
echo.
echo Sedang mengunggah (push) file proyek ke GitHub...
echo (Jika muncul jendela browser untuk login GitHub, silakan lakukan otorisasi/login).
echo.
"C:\Users\Hp\.gemini\antigravity\scratch\mingit\cmd\git.exe" push -u origin main --force
echo.
echo =======================================================
echo     PROSES SELESAI! SILAKAN PERIKSA DEPLOYMENT VERCEL.
echo =======================================================
pause
