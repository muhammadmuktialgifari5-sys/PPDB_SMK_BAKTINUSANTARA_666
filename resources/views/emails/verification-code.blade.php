<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kode Verifikasi Email</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #1f2937; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 8px 8px; }
        .code-box { background: #3b82f6; color: white; padding: 20px; text-align: center; border-radius: 8px; margin: 20px 0; }
        .code { font-size: 32px; font-weight: bold; letter-spacing: 8px; }
        .footer { text-align: center; margin-top: 20px; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SMK Bakti Nusantara 666</h1>
            <p>Sistem Penerimaan Mahasiswa Baru</p>
        </div>
        
        <div class="content">
            <h2>Halo {{ $user->nama }},</h2>
            
            <p>Terima kasih telah mendaftar di sistem SPMB SMK Bakti Nusantara 666.</p>
            
            <p>Untuk melanjutkan proses pendaftaran, silakan masukkan kode verifikasi berikut:</p>
            
            <div class="code-box">
                <div class="code">{{ $code }}</div>
            </div>
            
            <p><strong>Penting:</strong></p>
            <ul>
                <li>Kode ini berlaku selama <strong>15 menit</strong></li>
                <li>Jangan bagikan kode ini kepada siapapun</li>
                <li>Jika Anda tidak mendaftar, abaikan email ini</li>
            </ul>
            
            <p>Jika Anda mengalami kesulitan, silakan hubungi panitia SPMB.</p>
            
            <p>Terima kasih,<br>
            <strong>Panitia SPMB SMK Bakti Nusantara 666</strong></p>
        </div>
        
        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>