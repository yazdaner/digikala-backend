<?php

namespace Modules\zarinpal;

class Zarinpal
{
    protected string $MerchantID;


    protected array $error = [
        "-1" 	=> "اطلاعات ارسال شده ناقص است.",
        "-2" 	=> "IP و يا مرچنت كد پذيرنده صحيح نيست",
        "-3" 	=> "با توجه به محدوديت هاي شاپرك امكان پرداخت با رقم درخواست شده ميسر نمي باشد",
        "-4" 	=> "سطح تاييد پذيرنده پايين تر از سطح نقره اي است.",
        "-11" 	=> "درخواست مورد نظر يافت نشد.",
        "-12" 	=> "امكان ويرايش درخواست ميسر نمي باشد.",
        "-21" 	=> "هيچ نوع عمليات مالي براي اين تراكنش يافت نشد",
        "-22" 	=> "تراكنش نا موفق ميباشد",
        "-33" 	=> "رقم تراكنش با رقم پرداخت شده مطابقت ندارد",
        "-34" 	=> "سقف تقسيم تراكنش از لحاظ تعداد يا رقم عبور نموده است",
        "-40" 	=> "اجازه دسترسي به متد مربوطه وجود ندارد.",
        "-41" 	=> "اطلاعات ارسال شده مربوط به AdditionalData غيرمعتبر ميباشد.",
        "-42" 	=> "مدت زمان معتبر طول عمر شناسه پرداخت بايد بين 30 دقيه تا 45 روز مي باشد.",
        "-54" 	=> "درخواست مورد نظر آرشيو شده است",
        "100" 	=> "عمليات با موفقيت انجام گرديده است.",
        "101" 	=> "عمليات پرداخت موفق بوده و قبلا PaymentVerification تراكنش انجام شده است.",
    ];

    public function __construct()
    {
        $setting = settings(['MerchantID']);
        $this->MerchantID = $setting['MerchantID'];
    }

    public function pay($amount, $callbackUrl)
    {
        $Description = 'test description';
        $client = new \SoapClient("https://www.zarinpal.com/pg/services/WebGate/wsdl", ['encoding' => 'UTF-8']);
        $result = $client->PaymentRequest([
            'MerchantID'     => $this->MerchantID,
            'Amount'         => $amount,
            'Description'    => $Description,
            'CallbackURL'    => $callbackUrl,
        ]);
        if($result->Status == 100){
            return $result->Authority;
        }else{
            return false;
        }
    }

    public function verify($amount)
    {
        $Authority = request()->get('authority');
        $client = new \SoapClient("https://www.zarinpal.com/pg/services/WebGate/wsdl", ['encoding' => 'UTF-8']);
        $result = $client->PaymentVerification([
            'MerchantID'     => $this->MerchantID,
            'Authority'         => $Authority,
            'Amount'         => $amount,
        ]);
        if($result->Status == 100){
            return $result->RefID;
        }else{
            return false;
        }
    }
}
