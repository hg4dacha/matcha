<?php


const TOKEN = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjo2MywiaWF0IjoxNjUwNzQ4MTk4LCJleHAiOjE2NTA4MzQ1OTh9.raVLQ_qfrlhN0s8-qu1LHkCCqwAtmG2cvo0G1G6hQD4';

include_once 'jwt.php';


// HEADER CREATION
$header = [
    "alg" => "HS256",
    "typ" => "JWT"
];

// CONTENT CREATION (PAYLOAD)
$payload = [
    "user_id" => 63
];



$jwt = new JWT();
var_dump($jwt->check(TOKEN));



?>