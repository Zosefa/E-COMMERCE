<?php
    namespace App\Service;
    
    class Cryptage{
        private string $secretKey;
        private string $cipherAlgorithm;

        public function __construct(string $secretKey)
        {
            $this->secretKey = $secretKey;
            $this->cipherAlgorithm = 'aes-256-cbc';
        }

        public function encrypt( $data): string 
        {
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipherAlgorithm));
            $encryptedData = openssl_encrypt($data, $this->cipherAlgorithm, $this->secretKey, 0, $iv);
            return base64_encode($iv . $encryptedData);
        }

        public function decrypt(string $data): string
        {
            $data = base64_decode($data);
            $ivLength = openssl_cipher_iv_length($this->cipherAlgorithm);
            $iv = substr($data, 0, $ivLength);
            $encryptedData = substr($data, $ivLength);
            return openssl_decrypt($encryptedData, $this->cipherAlgorithm, $this->secretKey, 0, $iv);
        }
    }
