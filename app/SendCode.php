<?php
namespace App;

class SendCode
{
    public static function sendCode($phone)
    {
        $code = rand(1111,9999);
        $nexmo = app('Nexmo\Client');
        $nexmo->message()->send([
            'to' => '+374'.(int) $phone,
            'from' => 'Artur',
            'text' => 'Hello World' .$code
        ]);
        return $code;
    }
}
