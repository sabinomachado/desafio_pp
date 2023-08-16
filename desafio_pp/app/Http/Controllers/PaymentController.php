<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Interfaces\PaymentRepositoryInterface;
use App\Services\PaymentServiceInterface;
use Exception;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $repository;
    protected $service;
    

    public function __construct(
        PaymentRepositoryInterface $repository,
        PaymentServiceInterface $service
    ){
        $this->repository = $repository;
        $this->service = $service;
        
    }

    public function payment(PaymentRequest $request)
    {
        $data = array_merge($request->validated(), ['ip' => $request->ip()]);
      
        try {

            $payment = $this->service->makePayment($data);
            
            if (!$payment) {
                return back();
            }
            
            return redirect()->route('/', $payment);
            
        } catch(Exception $e) {
            return redirect('/')->with('message', $e->getMessage());
        }
    }


    public function sucessPayment($paymentId)
    {
        $payment = $this->repository->findById($paymentId);

        if (!$payment) {
            return back();
        }

        $qrCode = null;

        if ($payment->billingType == 'PIX') {
            $qrCode = $this->service->getQrCode($payment->invoiceNumber);
        }

        return view('/', compact('payment', 'qrCode'));
    }
}
