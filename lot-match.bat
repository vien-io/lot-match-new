@echo off
cd /d "C:\Users\user\lot-match"

:: start Laravel development server
start "Laravel Server" cmd /k "title Laravel Server && php artisan serve"

:: start vite
start "Vite Dev Server" cmd /k "title Vite Dev Server && npm run dev"

:: start laravel queue worker
start "Laravel Queue Worker" cmd /k "title Queue Worker && php artisan queue:work"

:: open vs code
start "VS Code - LotMatch" cmd /k "title VS Code - LotMatch && code ." 
