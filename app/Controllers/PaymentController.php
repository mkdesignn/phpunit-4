<?php
namespace App\Controllers;

use App\Api\V1\Factories\ServiceFactory;
use app\Models\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentController
{
    /**
     * @var User
     */
    private $user;

    /**
     * PaymentController constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param string $paymentName
     * @param Request $request
     * @return Response
     */
    public function addToWallet(string $paymentName, Request $request)
    {
        $payment = ServiceFactory::build(ucfirst(strtolower($paymentName)));

        $response = $payment->charge($request->get('token'), $request->get('amount'));

        if($response['status'] == 200){

            $this->user->getCurrentUser()
                ->update(['wallet' => $this->user->getCurrentUser()->wallet + $request->get('amount')]);

            return new Response('The money has successfully added to the wallet');
        } else {
            return new Response('There are a problem, Please contact the customer service.', 502);
        }
    }
}