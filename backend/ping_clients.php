<?php
header("Content-Type: application/json");

// --- Clients list (name + ip) ---
$clients = [
  [ "name" => "Giganet IPTV Mumbai", "ip" => "103.98.7.234" ],
  [ "name" => "VijayWada Bsnl", "ip" => "192.168.80.2" ],
  [ "name" => "BSNL HYDERABAD", "ip" => "192.168.80.50" ],
  [ "name" => "RailTel Kolkata", "ip" => "172.26.147.14" ],
  [ "name" => "RailTel Bhubaneswar", "ip" => "172.26.147.46" ],
  [ "name" => "StreamTv CDN", "ip" => "103.189.178.120/streamtv" ],
  [ "name" => "ZYETEL", "ip" => "192.168.80.218" ],
  [ "name" => "Aeronet BB Tarnaka", "ip" => "192.168.80.178" ],
  [ "name" => "Jeebr", "ip" => "192.168.80.202" ]
];

$results = [];

foreach ($clients as $client) {
    $ip = escapeshellarg($client['ip']);
    $pingCmd = "ping -c 3 -W 2 $ip"; // 3 packets, timeout 2s
    $output = [];
    $returnVar = 0;

    exec($pingCmd, $output, $returnVar);

    $latency = null;
    $status = "down";

    if ($returnVar === 0) {
        $status = "ok";
        foreach ($output as $line) {
            if (strpos($line, "avg") !== false) {
                preg_match('/= (.*)\/(.*)\/(.*)\/(.*) ms/', $line, $matches);
                if (isset($matches[2])) {
                    $latency = round(floatval($matches[2]), 2);
                }
            }
        }
    }

    $results[] = [
        "name" => $client['name'],
        "ip" => $client['ip'],
        "status" => $status,
        "latency_ms" => $latency,
        "raw" => $output
    ];
}

echo json_encode([
    "server" => getHostByName(getHostName()), // current server IP
    "results" => $results
], JSON_PRETTY_PRINT);

