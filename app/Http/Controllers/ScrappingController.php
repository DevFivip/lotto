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
        try {

            $client = new Client();
            $crawler = $client->request('GET', 'http://lottoactivo.com');
            $resultados = [];
            $r = $crawler->filter('#result ')->each(function ($node) {
                return $node->text();
            });
            $bodyRes = $crawler->filter('#result ');
            $rgg = $bodyRes->filter('p')->each(function ($node2) {

                $img = $node2->filter('img')->each(function ($node3) {
                    $src = $node3->extract(['src']);
                    // dd($src);
                    return $src[0];
                });
                // dd($img);
                return $img[0];
                // $wt = $node2->extract(['style']);        
            });

            $n = [];
            foreach ($rgg as $k => $value) {
                $ss = str_replace('/images/animalitos/venezuela/', '', $value);
                $ss = str_replace('.jpg', '', $ss);

                if ($ss == 'lottoactivoesperaVE.png') {
                    //noting
                } else {
                    $schedule_id = $k + 1; //id
                    //horario = []

                    array_push($n, [
                        "numero" => $ss,
                        "horario" => $schedule_id,
                    ]);
                }
            }


            return $n;
        } catch (\Throwable $th) {

            return [];
        }

        // $str = $bodyRes;

        // $resultados = explode('(-5)', $str);
        // // dd($str,$resultados);

        // $n = [];

        // foreach ($resultados as $r) {
        //     #eliminar doble espacio
        //     $ss = str_replace('  ', '', $r);
        //     $ss = str_replace('  ', '', $r);
        //     $ss = ltrim($ss);
        //     $ee = explode(' (-4) ', $ss);
        //     $ss = $ee[0];
        //     $ss = str_replace(' Hora de', '', $ss);
        //     $ss = str_replace(':00', '', $ss);
        //     $eee = explode(' ', $ss);
        //     // var_dump($eee);

        //     if (isset($eee[0]) && isset($eee[1]) && isset($eee[2])) {

        //         $el = [
        //             'animal' => $eee[0],
        //             'hora' => $eee[1] . ' ' . $eee[2]
        //         ];
        //         if ($el['animal'] == 'Prueba' || $el['animal'] == 'Esperando' || $el['animal'] == '') {
        //             //noting
        //         } else {
        //             array_push($n, $el);
        //         }
        //     }
        // }
        // dd($rgg, $n);
        // dd($n);
    }
}
