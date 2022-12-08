<?php

namespace App\Http\Libs;

use Illuminate\Support\Facades\Http;

class Telegram
{

    public  $token = '5631319594:AAEH0VNlM_efmRet8ntpUFqThfghIhU2mvA';

    public function get()
    {
        return 'https://api.telegram.org/bot' . $this->token . '/';
    }

    public function sendMessage($text,$chat_id = 5291243759)
    {
        $url = $this->get();
        Http::get($url . "sendmessage?chat_id=" . $chat_id . "&text=" . $text);
    }
}
?>