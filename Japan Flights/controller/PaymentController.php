<?php

namespace App\controller;

//*****GOAL: TO CREATE A PAYMENT INTENT WITH THE Stripe API//
//*********************************************************//

//*****METHODS: TO COMMUNICATE WITH THE DATABASE TO FIND AN ORDER'S DETAILS AND FIX THE TOTAL AMOUNT DUE,
//AND TO LAUNCH THE Stripe API VENDOR SO AS TO CREATE AN INTENT****************************************//

//*****1. Calling the appropriate model*****//
use App\model\{OrderDetails};

class PaymentController {

//*****2. Payment event*****// 
    public static function payment($amount) {
        
//*****A. Fixing an order's total amount due*****//
        $amount = floatval(number_format($amount, 2, '.', ' ')); 
        $amount = $amount*100;
        
//*****B. Calling the Stripe API vendor*****//
        require 'vendor/autoload.php';  

//*****C. Enabling a payment intent with a secret key*****//
        \Stripe\Stripe::setApiKey('sk_test_51J3HfUIgx08Ao9u6imED2U8jo5GyVWnqsEIU5U2haUQSTpSXcGJpLXxGJ2x8fmMhfyCVu4z2gKkN6EjGDQrIF7hh00PcovwsrW');
        
//*****D. Creating a payment intent, with an amount and a chose currency*****//
        return \Stripe\PaymentIntent::create([
                'amount' => $amount, 
                'currency' => 'usd'
        ]);
        
//*****END OF THE payment() METHOD*****//
    }

//*****END OF THE PaymentController CLASS*****//   
}