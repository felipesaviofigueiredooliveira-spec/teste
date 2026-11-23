<?php
// Inicia o script para o index.php

// 1. DETECÇÃO DE DISPOSITIVO (Celular vs Computador)
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$isMobile = preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $userAgent);

// 2. DETECÇÃO DE PAÍS (Geolocalização)
// Método A: Se o seu site usa Cloudflare, o país já vem pronto no header (Mais rápido e recomendado)
$country = $_SERVER['HTTP_CF_IPCOUNTRY'] ?? '';

// Método B: Se NÃO usa Cloudflare, consultamos uma API gratuita pelo IP do usuário
if (empty($country)) {
    $userIp = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    
    // Ignora localhost para testes locais funcionarem
    if ($userIp === '127.0.0.1' || $userIp === '::1') {
        $country = 'BR'; // Simula Brasil em ambiente de teste local
    } else {
        // Consulta rápida via API ip-api.com
        $geoResponse = @file_get_contents("http://ip-api.com/json/{$userIp}?fields=status,countryCode");
        $geoData = json_decode($geoResponse, true);
        if ($geoData && isset($geoData['status']) && $geoData['status'] === 'success') {
            $country = $geoData['countryCode'];
        }
    }
}

// 3. REGRAS DE BLOQUEIO E REDIRECIONAMENTO

// Regra 1: Bloquear se for Computador (Desktop)
if (!$isMobile) {
    header("HTTP/1.1 403 Forbidden");
    echo "<h2 style='font-family: sans-serif; text-align: center; margin-top: 20vh;'>Acesso permitido apenas via dispositivos móveis.</h2>";
    exit;
}

// Regra 2: Bloquear se estiver fora do Brasil (mesmo sendo celular)
if ($country !== 'BR') {
    header("HTTP/1.1 403 Forbidden");
    echo "<h2 style='font-family: sans-serif; text-align: center; margin-top: 20vh;'>Acesso restrito a usuários no Brasil.</h2>";
    exit;
}

// Regra 3: Se passou pelas validações (É celular E está no Brasil), vai para o segundo.php
header("Location: 5CA9B2B691E7F2CBBAC9550C36769C4903D4D987A20E8E3660944BCB59A2ADC9E5B70F9216E06AECDD23458A6B08C61E9C147D5B0263701831BCD8F56809DB99.php");
exit;
?>