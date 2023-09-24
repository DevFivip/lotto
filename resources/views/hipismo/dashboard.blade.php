@extends('layouts.app')

@section('content')
<div class="container" x-data="amount()">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-end"> <a href="/hipismo/taquilla" class="btn btn-primary">Nuevo</a></div>
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

                    <div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Resumen de Remates</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">Total: Bs. {{ number_format($total,2,',','.') }}</h6>
                                <h6 class="card-subtitle mb-2 text-body-secondary">Pagos: Bs. {{ number_format($pagado,2,',','.') }}</h6>
                                <h6 class="card-subtitle mb-2 text-body-secondary">Banca: Bs. {{ number_format($total - $pagado,2,',','.')}}</h6>
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
                                                                            <td class="fw-bold" x-text="`Total Bs. ${remates.remates.reduce((a, b) => {
                                                                                if(b.horse.status == 1){
                                                                                    return a + b.monto
                                                                                }else{
                                                                                    return a+0
                                                                                }
                                                                                // console.log(a,b)
                                                                            }, 0).toFixed(2)}`"></td>
                                                                            <td class="fw-bold" x-text="`Premio a Pagar Bs. ${remates.pagado.toFixed(2)}`"></td>
                                                                            <td><a x-bind:href="`/hipismo/taquilla/remate/edit/${remates.remates[0].code}`" class="btn btn-primary">Editar</a></td>
                                                                            <td></td>
                                                                            <td></td>
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
                                                                                <td x-text="`${(odds.horse.place == null)?'Pendiente': odds.horse.place}`"></td>
                                                                                <td x-text="`${odds.cliente}`"></td>
                                                                                <td x-text="`Bs. ${odds.monto.toFixed(2)} ${(odds.status_pago == false)? '❌': '✅'}`"></td>
                                                                            </tr>
                                                                        </template>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                        </template>


                                                    </div>
                                                </div>
                                            </template>

                                            <!-- <template x-for="fixture in race.fixtures">
                                                <div class="tab-content" id="myTabContent">
                                                    <div>
                                                        <template x-for="(remate, index) in fixture.remates" :key="index">
                                                            <div>
                                                                <pre x-text="JSON.stringify(remate,null,2)"></pre>
                                                                <template x-for="(rem, ii) in remate.remates" :key="ii">
                                                                    <div>
                                                                        <button class="btn btn-primary m-1" x-text="`${ii+1}`"></button>
                                                                        <pre x-text="JSON.stringify(rem,null,2)"></pre>
                                                                    </div>
                                                                </template>
                                                                <hr>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template> -->


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