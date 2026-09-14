<?php
require_once 'wp-load.php';
$map_data = reco_get_vietnam_map_data();
echo "KEYS: " . count(array_keys($map_data)) . "\n";
echo "JSON ERROR: " . json_last_error_msg() . "\n";
$json = wp_json_encode($map_data, JSON_UNESCAPED_UNICODE);
echo "ENCODE ERROR: " . json_last_error_msg() . "\n";
echo "JSON LENGTH: " . strlen($json) . "\n";
if (isset($map_data['Thành phố Hà Nội'])) {
    echo "HANOI COUNT: " . count($map_data['Thành phố Hà Nội']) . "\n";
}
