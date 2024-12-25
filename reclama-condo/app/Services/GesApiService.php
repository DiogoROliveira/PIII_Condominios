<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

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

    public function getClientData()
    {

        if (!$this->token) {
            throw new \Exception('Token de autenticação não configurado.');
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
                'Cookie' => $this->cookie,
            ])->get($this->baseUrl . '/clients');

            if ($response->successful()) {
                return $response->json();
            } else {
                throw new \Exception('Erro ao obter dados do cliente: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Erro ao obter dados do cliente: ' . $e->getMessage());
            throw $e;
        }
    }

    public function postClientData($user, $condo)
    {

        if (!$this->token) {
            throw new \Exception('Token de autenticação não configurado.');
        }

        $decryptedEmail = Crypt::decrypt($user->email);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => $this->token,
                'Cookie' => $this->cookie,
            ])->asForm()->post($this->baseUrl . '/clients', [
                'name' => $user->name,
                'vatNumber' => '',
                'country' => 'PT',
                'address' => $condo->address,
                'postalCode' => $condo->postal_code,
                'region' => $condo->state,
                'city' => $condo->city,
                'email' => $decryptedEmail,
                'website' => '',
                'mobile' => '000000000',
                'telephone' => '',
                'fax' => '',
                'representativeName' => '',
                'representativeEmail' => '',
                'representativeMobile' => '',
                'representativeTelephone' => '',
                'paymentMethod' => '1',
                'paymentCondition' => '1',
                'discount' => '0',
                'accountType' => '1',
                'internalCode' => $user->id,
            ]);


            echo $response->body();

            if ($response->successful()) {
                return $response->json();
            } else {
                throw new \Exception('Erro ao gerar cliente: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Erro ao criar cliente: ' . $e->getMessage());
            throw $e;
        }
    }

    public function postInvoiceData($monthlyPayment, $payment, $clientId)
    {
        if (!$this->token) {
            throw new \Exception('Token de autenticação não configurado.');
        }

        $date = Carbon::parse($monthlyPayment->paid_at)->format('d/m/Y');
        $expiration = Carbon::parse($monthlyPayment->due_date)->format('d/m/Y');

        $fixedDate = Carbon::createFromFormat('d/m/Y', '31/12/2024');

        if (Carbon::createFromFormat('d/m/Y', $date)->lessThan($fixedDate)) {
            $date = $fixedDate->format('d/m/Y');
        }

        if ($expiration < Carbon::now()->format('d/m/Y')) {
            $expiration = Carbon::now()->format('d/m/Y');
        }

        $lines = [
            [
                'id' => $monthlyPayment->id,
                'description' => 'Pagamento Renda',
                'quantity' => 1,
                'price' => $monthlyPayment->amount,
                'discount' => 0,
                'tax' => 4,
                'exemption' => 25,
                'retention' => 0
            ]
        ];

        $payload = [
            'client' => $clientId,
            'serie' => '27',
            'number' => '0',
            'date' => $date,
            'expiration' => $expiration,
            'reference' => $payment->id,
            'dueDate' => '1',
            'coin' => '1',
            'discount' => '0',
            'observations' => '',
            'finalize' => '1',
            'payment' => '0',
            'lines' => json_encode($lines),
            'doc_origin' => '9'
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => $this->token,
            'Cookie' => $this->cookie
        ])->asForm()->post("{$this->baseUrl}/invoices", $payload);

        if ($response->successful()) {
            $responseData = $response->json();
            if (isset($responseData['fatura'])) {
                return $responseData;
            } else {
                Log::error('Invoice creation failed', ['response' => $responseData]);
                throw new \Exception('Fatura criada sem a chave "invoice" na resposta.');
            }
        }

        Log::error('API Error', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        throw new \Exception('Erro ao criar a fatura. Status: ' . $response->status());
    }

    public function sendInvoiceMail($invoice, $user)
    {
        if (!$this->token) {
            throw new \Exception('Token de autenticação não configurado.');
        }

        $decryptedEmail = Crypt::decrypt($user->email);

        if (isset($invoice->invoice)) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => $this->token,
                'Cookie' => $this->cookie
            ])->asForm()->post($this->baseUrl . '/send-email', [
                'email' => $decryptedEmail,
                'type' => 'FT',
                'document' => $invoice->invoice
            ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                echo $response->status();
            }
        } else {
            throw new \Exception('Invoice data not found or incomplete.');
        }
    }

    public function sendInvoiceWithMail($invoice, $email)
    {

        if (!$this->token) {
            throw new \Exception('Token de autenticação não configurado.');
        }

        if (isset($invoice->invoice)) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => $this->token,
                'Cookie' => $this->cookie
            ])->asForm()->post($this->baseUrl . '/send-email', [
                'email' => $email,
                'type' => 'FT',
                'document' => $invoice->invoice
            ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                echo $response->status();
            }
        } else {
            throw new \Exception('Invoice data not found or incomplete.');
        }
    }
}
