<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CohereService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('COHERE_API_KEY');
    }

    public function generateCV($userInput)
    {
        // Hapus spasi berlebih
        $userInput = trim($userInput);
        if (empty($userInput)) {
            throw new \Exception('User input cannot be empty.');
        }

        // Siapkan prompt
        $prompt = <<<EOT
Buatkan CV dalam bahasa Indonesia berdasarkan informasi berikut:

$userInput

Tampilkan nama di bagian paling atas dengan tag <h1>, lalu lanjutkan dengan struktur berikut:
- <h2>Profil</h2>
- <h2>Pengalaman Kerja</h2>
- <h2>Pendidikan</h2>
- <h2>Keterampilan</h2>
- <h2>Kontak</h2>

Formatkan hasilnya dalam HTML sederhana tanpa tag <html> dan <body>, hanya bagian isi saja.
Gunakan tag <ul> dan <li> untuk daftar, <p> untuk paragraf, dan buat tampilan rapi serta mudah dibaca.
Jangan beri penjelasan, jangan beri pembuka seperti "Berikut CV Anda:", dan jangan gunakan blok kode markdown (seperti ```html).
Langsung berikan hasil HTML-nya saja.
EOT;

        $payload = [
            'model' => 'command-xlarge',
            'prompt' => $prompt,
            'max_tokens' => 500,
            'temperature' => 0.7,
        ];

        Log::info('Payload sent to Cohere API:', $payload);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.cohere.ai/v2/generate', $payload);

        if ($response->failed()) {
            Log::error('Cohere API Error:', ['response' => $response->body()]);
            throw new \Exception('Failed to generate CV: ' . $response->body());
        }

        $responseData = $response->json();
        Log::info('Response from Cohere API:', $responseData);

        return $responseData['generations'][0]['text'] ?? 'No CV generated.';
    }
}
