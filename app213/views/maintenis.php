<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance - Bappenda Kab. Bogor</title>

    <!-- Bootstrap 3 CDN (samain aja sama versi bootstrap yg dipake, tinggal ganti link ini kalau perlu) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">

    <style>
        html, body {
            height: 100%;
            background: #f4f6f9;
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }
        .maintenance-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        .maintenance-box {
            background: #fff;
            max-width: 550px;
            width: 100%;
            text-align: center;
            padding: 45px 35px;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }
        .maintenance-box img {
            max-width: 160px;
            margin-bottom: 25px;
        }
        .maintenance-box h2 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .maintenance-box p {
            color: #7b8a8b;
            font-size: 15px;
            line-height: 1.6;
        }
        .maintenance-icon {
            font-size: 55px;
            color: #f0ad4e;
            margin-bottom: 15px;
        }
        .footer-text {
            margin-top: 25px;
            font-size: 12px;
            color: #b0b0b0;
        }
    </style>
</head>
<body>

    <div class="maintenance-wrapper">
        <div class="maintenance-box">

            <img src="https://pbb.bogorkab.go.id/assets/img/img_logo.png">
            <br>
            <img src="https://pbb.bogorkab.go.id/assets/img/logo_bappenda.png">

            <div class="maintenance-icon">
                <!-- <span class="glyphicon glyphicon-wrench"></span> -->
            </div>

            <h2>Sedang Dalam Perbaikan</h2>
            <p>
                Mohon maaf, Aplikasi Bappenda Kabupaten Bogor saat ini sedang dalam proses
                <strong>maintenance</strong> untuk peningkatan layanan.
                Silakan coba akses kembali beberapa saat lagi. Terima kasih atas pengertiannya.
            </p>

            <div class="footer-text">
                &copy; <?= date('Y'); ?> Bappenda Kabupaten Bogor
            </div>

        </div>
    </div>

</body>
</html>