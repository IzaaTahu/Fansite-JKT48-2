<?php
// Cek beberapa bulan untuk dapat semua set_list code
$months = [4, 5, 6];
$year   = 2026;
$seen   = [];

foreach ($months as $m) {
    $url = "https://jkt48.com/api/v1/schedules?lang=id&month={$m}&year={$year}";
    $ch  = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_ENCODING       => 'gzip, deflate',
        CURLOPT_HTTPHEADER     => [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'Accept: application/json',
            'Referer: https://jkt48.com/',
        ],
    ]);
    $result = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($result, true);
    if (empty($json['data'])) continue;

    foreach ($json['data'] as $d) {
        $key = $d['title'];
        if (!isset($seen[$key])) {
            $seen[$key] = [
                'title'   => $d['title'],
                'type'    => $d['type'],
                'link'    => $d['link'],
            ];
        }
    }
}

foreach ($seen as $s) {
    echo "[{$s['type']}] {$s['title']} → link: {$s['link']}\n";
}