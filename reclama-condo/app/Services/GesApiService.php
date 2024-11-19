<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GesApiService
{
    private $baseUrl;
    private $token;
    private $cookie;

    public function __construct()
    {
        $this->baseUrl = config('services.ges_api.url');
        $this->cookie = config('services.ges_api.cookie');
    }


    public function authenticate()
    {

        $username = config('services.ges_api.username');
        $password = config('services.ges_api.password');

        try {
            $response = Http::asForm()->post($this->baseUrl . '/authentication', [
                'username' => $username,
                'password' => $password,
            ]);

            if ($response->successful()) {
                $this->token = $response->json()['_token'] ?? null;

                if (!$this->token) {
                    throw new \Exception('Token de autenticação não encontrado na resposta.');
                }

                Log::info('Token obtido com sucesso.');
            } else {
                throw new \Exception('Erro ao autenticar: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Erro na autenticação: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getPaymentMethods()
    {
        if (!$this->token) {
            throw new \Exception('Token de autenticação não configurado.');
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
                'Cookie' => $this->cookie,
            ])->get($this->baseUrl . '/payment-methods');

            if ($response->successful()) {
                return $response->json();
            } else {
                throw new \Exception('Erro ao obter métodos de pagamento: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Erro ao obter métodos de pagamento: ' . $e->getMessage());
            throw $e;
        }
    }
}
