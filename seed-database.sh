#!/bin/bash

# Kessly Database Seeding Script
# This script will reset and seed the database with sample data

echo "🚀 Kessly Database Seeding"
echo "=========================="
echo ""

# Navigate to Laravel directory
cd /c/laravel/Herd-sites/Kessly

echo "📋 Step 1: Refreshing migrations..."
php artisan migrate:fresh --force

echo ""
echo "🌱 Step 2: Running database seeders..."
php artisan db:seed --force

echo ""
echo "🔗 Step 3: Creating storage link..."
php artisan storage:link

echo ""
echo "✅ Database seeding completed!"
echo ""
echo "🔑 Admin Login Credentials:"
echo "Email: admin@kessly.com"
echo "Password: password"
echo ""
echo "📊 Your database now contains sample data for:"
echo "- Users & Roles"
echo "- Product Categories & Suppliers"  
echo "- Products (with various stock levels)"
echo "- Customers (VIP, Business, Individual)"
echo "- Company Branches & Employees"
echo "- Orders & Order Items"
echo "- Invoices & Customer Notes"
echo ""
echo "🎉 Ready to explore your SCM system!"