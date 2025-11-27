#!/bin/bash

echo "🚀 Memulai Aplikasi SPMB SMK Bakti Nusantara 666"
echo "================================================"
echo ""

# Clear cache
echo "🧹 Membersihkan cache..."
php artisan config:clear > /dev/null 2>&1
php artisan cache:clear > /dev/null 2>&1
php artisan view:clear > /dev/null 2>&1

echo "✅ Cache dibersihkan"
echo ""

# Check database
if [ ! -f "database/database.sqlite" ]; then
    echo "📦 Membuat database..."
    touch database/database.sqlite
    php artisan migrate --seed
    echo "✅ Database dibuat dan diisi dengan data awal"
else
    echo "✅ Database sudah ada"
fi

echo ""
echo "🌐 Menjalankan server..."
echo "📍 Aplikasi akan berjalan di: http://localhost:8000"
echo ""
echo "Tekan Ctrl+C untuk menghentikan server"
echo "================================================"
echo ""

# Start server
php artisan serve
