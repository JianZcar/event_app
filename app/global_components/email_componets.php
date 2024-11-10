<?php

function send_email($to, $subject, $message, $headers) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'smtp://live.smtp.mailtrap.io:587');
    curl_setopt($ch, CURLOPT_USERPWD, 'api:4e204e380fe30781a610e520a186107e');
    curl_setopt($ch, CURLOPT_MAIL_FROM, 'hello@demomailtrap.com');
    curl_setopt($ch, CURLOPT_MAIL_RCPT, $to);
    curl_setopt($ch, CURLOPT_UPLOAD, true);
    curl_setopt($ch, CURLOPT_READFUNCTION, function($ch, $fd, $length) use ($message) {
        static $data;
        if (!$data) {
            $data = $message;
        }
        $chunk = substr($data, 0, $length);
        $data = substr($data, $length);
        return $chunk;
    });

    $result = curl_exec($ch);
    if ($result === false) {
        return false;
    }

    $info = curl_getinfo($ch);
    curl_close($ch);

    return $info['http_code'] == 250;
}
?>