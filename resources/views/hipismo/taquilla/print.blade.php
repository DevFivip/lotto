{{$banca->user->taquilla_name}} <br>
Codigo:{{$banca->code}} <br>
Fecha:{{$banca->created_at}} <br>
<br>
Apuesta: <br>
{{$banca->fixturerace->hipodromo->name}} {{$banca->fixturerace->race->name}} CARRERA {{$banca->fixturerace->race_number}} <br>

@if($banca->apuesta_type == 1)
{{'GANADOR'}}
@endif

@if($banca->apuesta_type == 2)
{{'PERFECTA'}}
@endif

@if($banca->apuesta_type == 3)
{{'TRIFECTA'}}
@endif

"{{$banca->combinacion}}" X {{ number_format($banca->unidades,2,',','.')}} <br><br>

TOTAL Bs.{{ number_format($banca->total,2,',','.')}}