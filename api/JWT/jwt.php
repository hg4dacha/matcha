<?php


require_once "includes/config.php";


class JWT
{
    public function generate(array $header, array $payload, string $secret = SECRET, int $validity = 86400): string
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

    public function check(string $token, string $secret = SECRET)
    {
        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);

        $tokenVerif = $this->generate($header, $payload, SECRET, 0);

        return $token === $tokenVerif;
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