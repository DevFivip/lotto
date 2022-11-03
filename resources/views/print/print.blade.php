<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Ticket {{$ticket->code}}</title>
    <style>
        @page {
            size: auto;
            margin: 0;
        }

        * {
            font-size: 11px;
            font-family: 'Arial';
        }

        /* td,
        th,
        tr,
        table {
            border-top: 1px solid black;
            border-collapse: collapse;
        } */

        td.description,
        th.description {
            width: 75px;
            max-width: 75px;
        }

        td.quantity,
        th.quantity {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }

        td.price,
        th.price {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        .ticket {
            margin-top: -10px;
            width: auto;
            max-width: auto;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <p class="centered"> <b>{{$ticket->user->taquilla_name}}</b>
            <br>Codigo: <b>{{$ticket->code}}</b>
            <br>{{$dt->format('d/m/y H:i:s')}}
            <br>Caja: {{$ticket->caja_id}} N: {{$ticket->id}}
        </p>

        <table style="width: 100%;">
            <!-- <thead>
                <tr>
                    <th class="quantity">Q.</th>
                    <th class="description">Description</th>
                    <th class="price">$$</th>
                </tr>
            </thead> -->
            <tbody>

                @for ($i = 0; $i < count($sorteos_keys); $i++) @php $sorteo=$ticket_detalles[$sorteos_keys[$i]]; $horarios_keys=array_keys($sorteo->toArray());
                    @endphp

                    @for ($e = 0; $e < count($horarios_keys); $e++) @php $horario=$sorteo[$horarios_keys[$e]]; @endphp <tr>
                        <th class="quantity"></th>
                        <th class="description" align="center">{{$horario[0]->schedule}} {{$horario[0]->type->name}}</th>
                        <th class="price"></th>
                        </tr>

                        @for($h = 0; $h < count($horario); $h++) @php $item=$horario[$h]; @endphp <tr>
                            <td align="right"><b>{{$item->animal->number}}</b< /td>
                            <td>{{$item->animal->nombre}}</td>
                            <td>{{$ticket->moneda->simbolo}} {{number_format($item->monto, 2, ".", ",")}}</td>
                            </tr>

                            @endfor

                            @endfor

                            @endfor




                            <!-- <tr>
                    <td class="quantity">1.00</td>
                    <td class="description">ARDUINO UNO R3</td>
                    <td class="price">$25.00</td>
                </tr>
                <tr>
                    <td class="quantity">2.00</td>
                    <td class="description">JAVASCRIPT BOOK</td>
                    <td class="price">$10.00</td>
                </tr>
                <tr>
                    <td class="quantity">1.00</td>
                    <td class="description">STICKER PACK</td>
                    <td class="price">$10.00</td>
                </tr>
                <tr>
                    <td class="quantity"></td>
                    <td class="description">TOTAL</td>
                    <td class="price">$55.00</td>
                </tr> -->

                            <tr>
                                <td class="quantity"></td>
                                <td class="description"><b> TOTAL </b></td>
                                <td class="price"><b>{{$ticket->moneda->simbolo}} {{number_format($ticket->total, 2, ".", ",")}}</b></td>
                            </tr>

            </tbody>
        </table>
        <p class="centered"><b><u> Verifique su ticket </u></b>
            <br>Ticket Caduca en 3 dias
            <br>Buena Suerte!
            <br>consulta resultados en
            <br>lottoactivo.com
            <br>lottoplus.plus
            <br>https://t.me/resultadosanimalitos
        </p>
    </div>
    <!-- <button id="btnPrint" class="hidden-print">Print</button> -->
    <!-- <script src="script.js"></script> -->
</body>

</html>