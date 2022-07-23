<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sunra\PhpSimple\HtmlDomParser;
use Goutte\Client;

class ScrappingController extends Controller
{
    //

    public function scrap()
    {
        // try {
        //     //code...
        //     //throw $th;
        $client = new Client();
        $crawler = $client->request('GET', 'http://lottoactivo.com');
        $resultados = [];
        $r = $crawler->filter('#result')->each(function ($node) use ($resultados) {
            return $node->text();
        });

        $str = $r[0];

        $resultados = explode('(-5)', $str);
        // dd($str,$resultados);

        $n = [];

        foreach ($resultados as $r) {
            #eliminar doble espacio
            $ss = str_replace('  ', '', $r);
            $ss = str_replace('  ', '', $r);
            $ss = ltrim($ss);
            $ee = explode(' (-4) ', $ss);
            $ss = $ee[0];
            $ss = str_replace(' Hora de', '', $ss);
            $ss = str_replace(':00', '', $ss);
            $eee = explode(' ', $ss);
            // var_dump($eee);

            if (isset($eee[0]) && isset($eee[1]) && isset($eee[2])) {

                  $el = [
                      'animal'=>$eee[0],
                      'hora' => $eee[1].' '.$eee[2]
                      ];
                  if($el['animal']=='Prueba' || $el['animal']=='Esperando' || $el['animal']==''){
                      //noting
                  }else{
                 array_push($n,$el);
                  }

            }
        }

        dd($n);

        // } catch (\Throwable $th) {
        //     dd('false');
        // }
    }
}
