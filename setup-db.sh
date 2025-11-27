#!/bin/bash
echo "Menunggu MySQL siap..."
sleep 2
php artisan migrate:fresh --seed
echo ""
echo "✅ Database berhasil dibuat!"
echo "✅ Akses phpMyAdmin: http://localhost/phpmyadmin"
echo "✅ Database: spmb_db"
