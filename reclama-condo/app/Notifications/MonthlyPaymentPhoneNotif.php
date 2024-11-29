<?php
// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md

namespace App\Notifications;

use FontLib\Table\Type\name;
use Twilio\Rest\Client;



class MonthlyPaymentPhoneNotif
{
    public static function sendSMS($sms, $phone)
    {

        $pattern = "^(\+\d{1,2}\s?)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$";

        if (empty($phone) || !preg_match($pattern, $phone)) {
            return;
        }

        $sid    = "ACfa28bd8d1ea48b00076ec977f2580247";
        $token  = "506f8dc5f4579cdad8d33b4968af6379";
        $twilio = new Client($sid, $token);
        $message = $twilio->messages
            ->create(
                $phone, // to
                array(
                    "messagingServiceSid" => "MG3ee5e383d1d4433954a7acaf7c158d9e",
                    "body" => $sms
                )
            );
        print($message->sid);
    }

    public static function paymentCreated($user)
    {
        // $phone = $user->phone;
        $name = $user->name;
        $month = date('F');
        $sms = "Olá $name, o pagamento do aluguer deste mês ($month) está disponível para pagamento. Para mais detalhes, aceda à sua àrea de alugueres através do link: https://reclama-condo.000.pe/dashboard/complaints .";
        self::sendSMS($sms, "+351934436741");
    }

    public static function paymentUpdated($user)
    {
        $phone = $user->phone;
        $name = $user->name;
        $month = date('F');
        $sms = "Olá $name, o pagamento do aluguer deste mês ($month) foi atualizado. Para mais detalhes, aceda à sua àrea de alugueres através do link: https://reclama-condo.000.pe/dashboard/complaints .";
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
        $sms = "Olá $name, o pagamento do aluguer deste mês ($month) foi completado.";
        self::sendSMS($sms, $phone);
    }
}
