<?php

namespace App\Notifications;

use Twilio\Rest\Client;

$dir = __DIR__;
require_once $dir . '/../../vendor/autoload.php';


class MonthlyPaymentPhoneNotif
{
    public static function sendSMS($sms, $phone)
    {
        $sid    = config('services.twilio.account_sid');
        $token  = config('services.twilio.auth_token');
        $twilio = new Client($sid, $token);
        $message = $twilio->messages
            ->create(
                "", // to
                array(
                    "from" => "",
                    "body" => $sms
                )
            );
        print($message->sid);
    }

    public static function paymentCreated($user)
    {
        $phone = $user->phone;
        $name = $user->name;
        $month = date('F');
        $sms = "Olá $name, o pagamento do aluguer deste mês ($month) está disponível para pagamento. Para mais detalhes, aceda à sua àrea de alugueres.";
        self::sendSMS($sms, $phone);
    }

    public static function paymentUpdated($user)
    {
        $phone = $user->phone;
        $name = $user->name;
        $month = date('F');
        $sms = "Olá $name, o pagamento do aluguer deste mês ($month) foi atualizado. Para mais detalhes, aceda à sua àrea de alugueres.";
        self::sendSMS($sms, $phone);
    }

    public static function paymentOverdue($user)
    {
        $phone = $user->phone;
        $name = $user->name;
        $month = date('F');
        $sms = "Olá $name, o pagamento do aluguer deste mês ($month) está vencido. Contacte o administrador do condomínio para extender a data de vencimento.";
        self::sendSMS($sms, $phone);
    }

    public static function paymentCompleted($user)
    {
        $phone = $user->phone;
        $name = $user->name;
        $month = date('F');
        $sms = "Olá $name, o pagamento do aluguer deste mês ($month) foi completado. Para mais detalhes, aceda à sua àrea de alugueres.";
        self::sendSMS($sms, $phone);
    }
}
