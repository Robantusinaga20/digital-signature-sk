<?php
namespace App\Services;

class RsaService
{
    /**
     * Generate RSA key pair menggunakan OpenSSL XAMPP
     * Kembalikan komponen n, e, d dalam format desimal (GMP)
     */
    public function generateKeyPair(): array
    {
        // Tentukan path openssl.cnf XAMPP secara eksplisit
        $opensslConf = 'C:\\xampp\\apache\\conf\\openssl.cnf';

        // Set environment variable agar OpenSSL bisa menemukan config
        putenv("OPENSSL_CONF={$opensslConf}");

        $config = [
            'config'           => $opensslConf,
            'digest_alg'       => 'sha256',
            'private_key_bits' => 1024,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        ];

        $keyPair = openssl_pkey_new($config);

        // Cek apakah berhasil
        if ($keyPair === false) {
            $error = openssl_error_string();
            throw new \RuntimeException("Gagal generate RSA key pair: {$error}");
        }

        $keyDetails = openssl_pkey_get_details($keyPair);

        // Konversi binary ke integer desimal menggunakan GMP
        $n = gmp_strval(gmp_import($keyDetails['rsa']['n']));
        $e = gmp_strval(gmp_import($keyDetails['rsa']['e']));
        $d = gmp_strval(gmp_import($keyDetails['rsa']['d']));

        return compact('n', 'e', 'd');
    }
    /**
     * ENKRIPSI menggunakan KUNCI PRIVAT (d)
     * Plaintext string → ASCII desimal → C = P^d mod n → hex
     *
     * Format plaintext: nosk/instansi/pengesah/tahun
     * Contoh: 127/HANUBA/JontarSinaga/2026
     */
    public function encrypt(string $plaintext, string $d, string $n): array
    {
        $d = gmp_init($d);
        $n = gmp_init($n);

        $result = [];

        foreach (str_split($plaintext) as $char) {
            // Konversi karakter ke nilai ASCII desimal
            $ascii = ord($char);
            $p     = gmp_init($ascii);

            // Enkripsi dengan kunci privat: C = P^d mod n
            $cipher = gmp_powm($p, $d, $n);

            // Konversi ciphertext ke heksadesimal
            $hex = strtoupper(gmp_strval($cipher, 16));

            $result[] = [
                'char'   => $char,
                'ascii'  => $ascii,
                'cipher' => gmp_strval($cipher),
                'hex'    => $hex,
            ];
        }

        return $result;
    }

    /**
     * DEKRIPSI menggunakan KUNCI PUBLIK (e)
     * Hex → ciphertext desimal → P = C^e mod n → ASCII → karakter asli
     */
    public function decrypt(array $cipherArray, string $e, string $n): string
    {
        $e = gmp_init($e);
        $n = gmp_init($n);

        $plaintext = '';

        foreach ($cipherArray as $item) {
            // Konversi hex ke desimal
            $cipher = gmp_init($item['hex'], 16);

            // Dekripsi dengan kunci publik: P = C^e mod n
            $plain = gmp_powm($cipher, $e, $n);

            // Konversi ASCII desimal ke karakter asli
            $plaintext .= chr(gmp_intval($plain));
        }

        return $plaintext;
    }

    /**
     * Format plaintext tanda tangan dari data SK
     * Format tetap: nosk/HANUBA/pengesah/tahun
     */
    public function formatPlaintext(string $nomorSk, string $pengesah, int $tahun): string
    {
        return "{$nomorSk}/HANUBA/{$pengesah}/{$tahun}";
    }

    /**
     * Serialize array cipher ke string untuk disimpan di database
     * Format: HEX1|HEX2|HEX3|...
     */
    public function serializeCipher(array $cipherArray): string
    {
        return implode('|', array_column($cipherArray, 'hex'));
    }

    /**
     * Deserialize string cipher dari database ke array
     */
    public function deserializeCipher(string $cipherString): array
    {
        return array_map(
            fn($hex) => ['hex' => $hex],
            explode('|', $cipherString)
        );
    }
}