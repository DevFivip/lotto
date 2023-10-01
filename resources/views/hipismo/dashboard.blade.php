@extends('layouts.app')

@section('content')
<div class="container" x-data="amount()">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-end"> <a href="/hipismo/taquilla" class="btn btn-primary">Nueva Remate</a> <a href="/hipismo/taquilla-banca" class="btn btn-primary">Nueva Apuesta</a></div>
                <div class="card-body">
                    @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{!! \Session::get('success') !!}</li>
                        </ul>
                    </div>
                    @endif

                    @if (\Session::has('error'))
                    <div class="alert alert-danger">
                        <ul>
                            <li>{!! \Session::get('error') !!}</li>
                        </ul>
                    </div>
                    @endif

                    <div class="row g-2">
                        <div class="col-12 col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Resumen de Remates</h5>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">Total: Bs. {{ number_format($total,2,',','.') }}</h6>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">Pagos: Bs. {{ number_format($pagado,2,',','.') }}</h6>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">Banca: Bs. {{ number_format($total - $pagado,2,',','.')}}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Resumen de Banca</h5>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">Total: Bs. {{ number_format($bancas_totales[0]->total,2,',','.') }}</h6>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">Pagos: Bs. {{ number_format($bancas_totales[0]->premiototal,2,',','.') }}</h6>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">Banca: Bs. {{ number_format($bancas_totales[0]->total - $bancas_totales[0]->premiototal ,2,',','.')}}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Resumen Total</h5>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">Total: Bs. {{ number_format($total + $bancas_totales[0]->total,2,',','.') }}</h6>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">Pagos: Bs. {{ number_format($pagado + $bancas_totales[0]->premiototal,2,',','.') }}</h6>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">Banca: Bs. {{ number_format( ($total - $pagado) + ($bancas_totales[0]->total - $bancas_totales[0]->premiototal) ,2,',','.')}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <template x-for="hipodromo in hipodromos">
                        <div class="mt-2">
                            <div class="card">
                                <div class="card-body bg-body">
                                    <h3 class="h3" x-text="`${hipodromo.name} ${hipodromo.flag}`"></h3>

                                    <template x-for="race in hipodromo.races">
                                        <div>
                                            <h5 x-text="race.name"></h5>

                                            <ul class="nav nav-tabs">
                                                <template x-for="fixture in race.fixtures">
                                                    <li class="nav-item">
                                                        <a x-bind:class="{ 'active': fixture.id === tab.selected }" class="nav-link" @click="selectTab(fixture.id)" x-bind:id="`${fixture.id}-tab`" id="home" x-text="`Carrera ${fixture.race_number}`"></a>
                                                    </li>
                                                </template>
                                            </ul>

                                            <template x-for="fixture in race.fixtures">
                                                <div class="card" x-show="tab.selected === fixture.id">
                                                    <div>
                                                        <template x-for="remates in fixture.remates">
                                                            <div class=" mt-1">
                                                                <div class="table-responsive">

                                                                    <table class="table">
                                                                        <tr>
                                                                            <td><a x-bind:href="`/hipismo/taquilla/remate/edit/${remates.remates[0].code}`" class="btn btn-primary">Editar</a></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Numero</th>
                                                                            <th>Ejemplar</th>
                                                                            <th>Posición</th>
                                                                            <th>Cliente</th>
                                                                            <th>Monto</th>
                                                                        </tr>
                                                                        <template x-for="odds in remates.remates">
                                                                            <tr x-bind:class="{ 'bg-danger': odds.horse.status == 0 }">
                                                                                <td x-text="`${odds.horse.horse_number}`"></td>
                                                                                <td x-text="`${odds.horse.horse_name} ${(odds.horse.remate_winner == 1) ? '🏅': '' } ${(odds.horse.status == 0)? '(Retirado)': ''}`"></td>
                                                                                <td x-text="`${(odds.horse.place == null) ? 'Pendiente': odds.horse.place}`"></td>
                                                                                <td x-text="`${odds.cliente}`"></td>
                                                                                <td x-text="`Bs. ${odds.monto.toFixed(2)} ${(odds.status_pago == false)? '❌': '✅'}`"></td>
                                                                            </tr>
                                                                        </template>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td class="fw-bold">Total</td>
                                                                            <td class="fw-bold" x-text="`Bs. ${remates.remates.reduce((a, b) => {
                                                                                if(b.horse.status == 1){
                                                                                    return a + b.monto
                                                                                }else{
                                                                                    return a+0
                                                                                }
                                                                                // console.log(a,b)
                                                                            }, 0).toFixed(2)}`"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td class="fw-bold">Pagar</td>
                                                                            <td class="fw-bold" x-text="` Bs. ${remates.pagado.toFixed(2)}`"></td>
                                                                        </tr>

                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>
                                            <div class="table-responsive">

                                                <table class="table">
                                                    <tr>
                                                        <td></td>
                                                        <td class="fw-bold">Hipodromo</td>
                                                        <td class="fw-bold">Carrera</td>
                                                        <td class="fw-bold">Apuesta</td>
                                                        <td class="fw-bold">Premio</td>
                                                        <td class="fw-bold">Win</td>
                                                    </tr>
                                                    @foreach($bancas as $banca)
                                                    <tr>
                                                        <td>

                                                            @if($banca->status == 1)
                                                            <span class="badge bg-warning text-dark">Correcto</span>
                                                            @elseif($banca->status == 0)
                                                            <span class="badge bg-danger">Eliminado</span>
                                                            @else($banca->status == 2)
                                                            <span class="badge bg-success">Pagado</span>
                                                            @endif
                                                            @if($banca->win != null)
                                                            <span class="badge bg-primary">Ganador</span>
                                                            @endif


                                                        </td>
                                                        <td>{{$banca->fixtureRace->hipodromo->name}}</td>
                                                        <td>Carrera {{$banca->fixtureRace->race_number}}</td>
                                                        <td>Unidades {{$banca->unidades}} | Bs. {{ number_format($banca->total,2,',','.') }}</td>
                                                        <td> Bs. {{ number_format($banca->total * $banca->win,2,',','.') }}</td>
                                                        <td> Bs. {{ number_format($banca->win,2,',','.') }}</td>
                                                        <td><button @click="handleOpenPreviewApuesta({{$banca->id}})" class="btn btn-primary btn-sm m-1"> <i class="fa fa-eye"></i></button><button @click="handleDelete({{$banca->id}})" class="m-1 btn btn-danger btn-sm"><i class="fa fa-trash"></i> </button></td>
                                                    </tr>
                                                    @endforeach
                                                </table>

                                            </div>

                                            <div class="d-flex">
                                                {!! $bancas->links() !!}
                                            </div>

                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>




                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function amount() {
        let hipodromos = @json($hipodromos);
        console.log(hipodromos)
        return {
            hipodromos: hipodromos,
            tab: {
                selected: false,
            },
            selectTab: function(carreraId) {
                this.tab.selected = carreraId
            },
            handleOpenPreviewApuesta: async function(id) {
                let win = window.open(`/hipismo/taquilla-banca/print/${id}`, "_blank", 'width=400, height=400');
                let q = win.focus();
                let w = win.print();
            },
            handleDelete: async function(id) {
                if (confirm("¿Seguro deseas eliminar esta Apuesta?") == true) {
                    const res = await fetch('/hipismo/taquilla-banca/' + id, {
                        method: 'DELETE',
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                        },
                    })

                    body = await res.json();

                    if (body.valid) {
                        location.reload()
                    } else {
                        this.toast(body.message, 1000);
                    }
                }
            },
            toast: function(msg, duration = 800) {
                Toastify({
                    text: msg,
                    duration: duration,
                    className: "info",
                    close: true,
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    }
                }).showToast();
            },
        }
    }
</script>

@endsection