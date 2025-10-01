# Kessly Database Seeding Script (PowerShell)
# This script will reset and seed the database with sample data

Write-Host "🚀 Kessly Database Seeding" -ForegroundColor Cyan
Write-Host "==========================" -ForegroundColor Cyan
Write-Host ""

# Navigate to Laravel directory
Set-Location "c:\laravel\Herd-sites\Kessly"

Write-Host "📋 Step 1: Refreshing migrations..." -ForegroundColor Yellow
php artisan migrate:fresh --force

Write-Host ""
Write-Host "🌱 Step 2: Running database seeders..." -ForegroundColor Yellow
php artisan db:seed --force

Write-Host ""
Write-Host "🔗 Step 3: Creating storage link..." -ForegroundColor Yellow
php artisan storage:link

Write-Host ""
Write-Host "✅ Database seeding completed!" -ForegroundColor Green
Write-Host ""
Write-Host "🔑 Admin Login Credentials:" -ForegroundColor Magenta
Write-Host "Email: admin@kessly.com" -ForegroundColor White
Write-Host "Password: password" -ForegroundColor White
Write-Host ""
Write-Host "📊 Your database now contains sample data for:" -ForegroundColor Blue
Write-Host "- Users & Roles" -ForegroundColor Gray
Write-Host "- Product Categories & Suppliers" -ForegroundColor Gray
Write-Host "- Products (with various stock levels)" -ForegroundColor Gray
Write-Host "- Customers (VIP, Business, Individual)" -ForegroundColor Gray
Write-Host "- Company Branches & Employees" -ForegroundColor Gray
Write-Host "- Orders & Order Items" -ForegroundColor Gray
Write-Host "- Invoices & Customer Notes" -ForegroundColor Gray
Write-Host ""
Write-Host "🎉 Ready to explore your SCM system!" -ForegroundColor Green

# Pause to show results
Read-Host "Press Enter to continue..."