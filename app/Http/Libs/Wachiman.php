<?php

namespace App\Http\Libs;

use Illuminate\Support\Facades\Http;

class Wachiman
{

    public  $token = '5818223520:AAErO4lDgBpr69-gVgQ2t37rbsGc7rFXLBs';

    public function get()
    {
        return 'https://api.telegram.org/bot' . $this->token . '/';
    }

    public function sendMessage($text,$chat_id = '-1001868524759')
    {
        $url = $this->get();
        Http::get($url . "sendmessage?chat_id=" . $chat_id . "&text=" . $text);
    }
}
