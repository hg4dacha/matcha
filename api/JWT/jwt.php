<?php


require_once "includes/config.php";


class JWT
{
    public function generate(array $header, array $payload, string $secret = SECRET, int $validity = 86400): string
    {
        if ( $validity > 0 ) {
            $now = new DateTime();
            $expiry = $now->getTimestamp();
        }

        // VALUES ENCODING
        $header_base64 = base64_encode(json_encode($header));
        $payload_base64 = base64_encode(json_encode($payload));
        
        // VALUES CLEANING
        $header_base64 = str_replace(['+', '/', '='], ['-', '_', ''], $header_base64);
        $payload_base64 = str_replace(['+', '/', '='], ['-', '_', ''], $payload_base64);
        
        // SIGNATURE GENERATION
        $secret_base64 = base64_encode($secret);
        $signature = hash_hmac('sha256', $header_base64.'.'.$payload_base64, $secret_base64, true);

        // SIGNATURE ENCODING
        $signature_base64 = base64_encode($signature);

        // SIGNATURE CLEANING
        $signature_base64 = str_replace(['+', '/', '='], ['-', '_', ''], $signature_base64);
        
        // TOKEN CREATION
        $jwt = $header_base64.'.'.$payload_base64.'.'.$signature_base64;

        return $jwt;
    }
}

// HEADER CREATION
$header = [
    "alg" => "HS256",
    "typ" => "JWT"
];

// CONTENT CREATION (PAYLOAD)
$payload = [
    "user_id" => 63
];

$test = new JWT();
$token = $test->generate($header, $payload);
echo $token;






// https://www.youtube.com/watch?v=dZgHUq-uEGY&ab_channel=NouvelleTechno
?>