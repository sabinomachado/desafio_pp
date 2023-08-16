<?php

namespace App\Services;

use App\Interfaces\PaymentRepositoryInterface;
use App\Repositories\PaymentRepository;
use App\Services\PaymentServiceInterface;
use Exception;
use Illuminate\Support\Facades\Http;

class PaymentService implements PaymentServiceInterface
{
    protected $customerId;
    private $repository;

    public function __construct(PaymentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function makePayment(array $data)
    {
        
        $this->customerId = $this->createCustomer($data['name'], $data['email'], $data['cpfCnpj'], $data['phone']);
       
        $paymentData = $this->preparePaymentData($data);
       
        $response = $this->submitPayment($paymentData);

        return $this->handlePaymentResponse($response);
    }

    private function preparePaymentData(array $data)
    {
        
        $paymentMethod = $data['payment_method'];

        $paymentData = [
            'customer' => $this->customerId,
            'billingType' => $paymentMethod,
            'value' => '13',
            'dueDate' => '2023-08-20', //adicionar carbon(?)
            'remoteIp' => $data['ip'],
        ];

        

        if ($paymentMethod === 'CREDIT_CARD') {
            $paymentData['creditCard'] = $this->createCreditCardObject($data);
            $paymentData['creditCardHolderInfo'] = $this->createCreditCardHolderInfoObject($data);
        }

        return $paymentData;
    }

    private function submitPayment(array $paymentData)
    {
      
        return Http::withHeaders([
            'access_token' => env('ASAAS_KEY'),
        ])->post(env('ASAAS_URL') . 'payments', $paymentData);
    }

    private function handlePaymentResponse($response)
    {
       
        if ($response->failed()) {
            throw new Exception($response->json('errors')[0]['description']);
        }

        if ($response->successful()) {
            return $this->repository->create($response->json());
        }
        return $response->json();
    }

    public function createCustomer(string $name, string $email, string $cpfCnpj, string $phone): string|null
    {
        
        $response = Http::withHeaders([
            'access_token' => env('ASAAS_KEY')
        ])->post(env('ASAAS_URL').'customers',[
            'name'      => $name,
            'email'     => $email,
            'cpfCnpj'   =>  $cpfCnpj,
            'phone'     => $phone
        ]);
        
        if ($response->failed()) {
            throw new Exception($response->json('errors')[0]['description']);
        }
      
        $data = $response->json();
       
        return $data['id'];
    }

    public function createCreditCardObject(array $data)
    {        
        $expiry = explode('/', $data['card_expiry']);
                
        $creditCard = [
            'holderName' => $data['holderName'],
            'number' => $data['card_number'],
            'expiryMonth' => $expiry[0],
            'expiryYear' => $expiry[1],
            'ccv' => $data['cvv'],
        ];
        
        return (object) $creditCard;
    }

    public function createCreditCardHolderInfoObject(array $data)
    {        
        $creditCardHolderInfo = [
            'name'          => $data['name_titular'],
            'email'         => $data['email_titular'],
            'cpfCnpj'       => $data['cpfCnpj_titular'],
            'postalCode'    => $data['cep_titular'],
            'addressNumber' => $data['residencia_titular'],
            'phone'         => $data['phone_titular'],
        ];
        
        return (object) $creditCardHolderInfo;
    }

    public function getQrCode(string $invoiceNumber)
    {
        $response = Http::withHeaders([
            'access_token' => env('ASAAS_KEY')
        ])->get(env('ASAAS_URL')."payments/{$invoiceNumber}/pixQrCode"); 

        return $response->json();
    }
}
