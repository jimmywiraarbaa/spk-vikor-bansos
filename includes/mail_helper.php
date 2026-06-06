<?php

require_once __DIR__ . '/../vendor/autoload.php';

function sendEmail($toEmail, $toName, $subject, $htmlBody)
{
    $apiKey = $_ENV['BREVO_API_KEY'] ?? '';
    $fromName = $_ENV['MAIL_FROM_NAME'] ?? 'SPK VIKOR BANSOS';
    $fromEmail = $_ENV['MAIL_FROM_EMAIL'] ?? '';

    $data = [
        'sender' => [
            'name' => $fromName,
            'email' => $fromEmail,
        ],
        'to' => [
            [
                'email' => $toEmail,
                'name' => $toName,
            ],
        ],
        'subject' => $subject,
        'htmlContent' => $htmlBody,
    ];

    $ch = curl_init('https://api.brevo.com/v3/smtp/email');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'Content-Type: application/json',
            'api-key: ' . $apiKey,
        ],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        error_log('Mail cURL Error: ' . $error);
        return false;
    }

    if ($httpCode >= 400) {
        error_log('Mail API Error: ' . $response);
        return false;
    }

    return true;
}
