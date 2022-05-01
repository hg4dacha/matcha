<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/JWT/includes/config.php");


class JWT
{
    public function generate(array $header, array $payload, string $secret = SECRET, int $validity = 3600): string
    {
        if ( $validity > 0 ) {
            $now = new DateTime();
            $expiry = $now->getTimestamp() + $validity;
            $payload['iat'] = $now->getTimestamp();
            $payload['exp'] = $expiry;
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

    public function check(string $token, string $secret = SECRET): bool
    {
        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);

        $tokenVerif = $this->generate($header, $payload, $secret, 0);

        return $token === $tokenVerif;
    }

    public function expired(string $token): bool
    {
        $payload = $this->getPayload($token);
        $now = new DateTime();

        return $payload['exp'] < $now->getTimestamp();
    }

    public function validSyntax(string $token): bool
    {
        return preg_match(
            "/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/",
            $token
        ) === 1;
    }

    public function getHeader(string $token)
    {
        $array = explode('.', $token);
        $header = json_decode(base64_decode($array[0]), true);

        return $header;
    }

    public function getPayload(string $token)
    {
        $array = explode('.', $token);
        $payload = json_decode(base64_decode($array[1]), true);

        return $payload;
    }
}




// https://www.youtube.com/watch?v=dZgHUq-uEGY&ab_channel=NouvelleTechno
?>