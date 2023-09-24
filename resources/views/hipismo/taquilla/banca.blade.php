@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" x-data="amount()">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10 p-0" x-init="$watch('hipodromoSelected', value => getCommingRaces(value))">
            <div class="card shadow">
                <div class="card-header d-none d-sm-block ">Banca Hipodromo</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">

                            <select class="form-select" x-model="hipodromoSelected">
                                <option :value="false"> Seleccione Hipodromo</option>
                                <template x-for="(hipodromo, index) in hipodromos" :key="index">
                                    <option :value="hipodromo.id" x-text="hipodromo.name"></option>
                                </template>
                            </select>
                        </div>

                        <div class="col-12 col-md-12">
                            <select class="form-select" x-model="hipodromoSelected">
                                <template x-for="(hipodromo, index) in hipodromos" :key="index">
                                    <option :value="hipodromo.id" x-text="hipodromo.name"></option>
                                </template>
                            </select>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    function amount() {
        const _hipodromos = @json($hipodromos);
        // console.log(_hipodromos)
        return {
            hipodromoSelected: false,
            hipodromos: _hipodromos,
            commingRaces: [],
            getCommingRaces: async function(id) {
                let body = await fetch('/hipismo/taquilla-banca/getcomming/races/' + id, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                    },
                })
                res = await body.json()
                if (res.valid) {
                    console.log(res)
                    this.commingRaces = res.data
                } else {
                    this.toast(res.message, 5000);
                }
            },
            remateSelect: async function(id) {
                await this.fetchHorsesForRace(id);
                await this.getRematesCodes(id)
                this.remate.remateSelected = id
            },
            cancelar: function() {
                this.remate.remateSelected = false;
                this.remate.remateHorses = false;
                this.remate.remateEditSelected = undefined;
            },
            saveAndCreateNewRemate: async function() {
                if (this.validRemate()) {
                    const data = this.remate.remateHorses.map((v) => {
                        v.moneda_id = 1
                        return v;
                    })
                    console.log(this.remate)
                    this.handleBtnSave = true;
                    let body = await fetch('/hipismo/taquilla/remate/save', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify(this.remate)
                    })
                    res = await body.json()
                    if (res.valid) {
                        this.remateHorses = false;
                        this.toast(res.message, 5000);
                        this.remate.remateEditSelected = false;
                        await this.fetchHorsesForRace(this.remate.remateSelected);
                        await this.getRematesCodes(this.remate.remateSelected);
                    } else {
                        this.toast(res.message, 5000);
                    }
                }
            },
            calculeTotal: function(v) {
                total = 0;
                v.forEach(e => {
                    if (!isNaN(e.monto) && (e.status)) {
                        total += Number(e.monto);
                    }
                });
                this.remate.total = total;
                this.remate.premio = total * 0.70;
                this.remate.banca = total * 0.30;
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

    function obtenerGMTOffset() {
        const fechaActual = new Date();
        const offsetMinutos = fechaActual.getTimezoneOffset();

        // Convierte el offset en minutos a formato legible (positivo para GMT+ y negativo para GMT-)
        const horas = Math.abs(Math.floor(offsetMinutos / 60));
        const minutos = Math.abs(offsetMinutos % 60);
        const signo = offsetMinutos > 0 ? '-' : '+';

        // Devuelve el valor GMT en formato legible
        return Number(`${horas}`);
    }


    function timer(expiry) {
        return {
            expiry: expiry,
            remaining: null,
            init() {
                this.setRemaining()
                setInterval(() => {
                    this.setRemaining();
                }, 1000);
            },
            setRemaining() {
                const diff = this.expiry - new Date().getTime();
                this.remaining = parseInt(diff / 1000);
            },
            days() {
                return {
                    value: this.remaining / 86400,
                    remaining: this.remaining % 86400
                };
            },
            hours() {
                return {
                    value: this.days().remaining / 3600,
                    remaining: this.days().remaining % 3600
                };
            },
            minutes() {
                return {
                    value: this.hours().remaining / 60,
                    remaining: this.hours().remaining % 60
                };
            },
            seconds() {
                return {
                    value: this.minutes().remaining,
                };
            },
            format(value) {
                return ("0" + parseInt(value)).slice(-2)
            },
            time() {
                return {
                    days: this.format(this.days().value),
                    hours: this.format(this.hours().value),
                    minutes: this.format(this.minutes().value),
                    seconds: this.format(this.seconds().value),
                    diff: this.remaining
                }
            },
        }
    }
</script>
@endsection