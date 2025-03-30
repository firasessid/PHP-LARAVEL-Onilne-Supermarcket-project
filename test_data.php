<?php
$data = [
    'segment' => 'vip',
    'loyalty_points' => 150,
    'purchase_frequency' => 5,
    'avg_spending' => 200,
    'age' => 30
];

echo base64_encode(json_encode($data));