@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" x-data="amount()">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10 p-0">
            <div class="card shadow">
                <div class="card-header d-none d-sm-block ">Ticket Hipodromo</div>
                <div class="card-body">
    
                    <div class="row mt-2" x-show="!!!remate.remateSelected" x-transition:enter.duration.500ms x-transition:leave.duration.50ms>
                        <div class="col-12 col-md-12">
                            <div class="list-group">
                                <template x-for="_race in _comming_races">
                                    <a @click="remateSelect(_race.id)" class="list-group-item list-group-item-action" x-data="timer(_race.start_time)" x-init="init();" x-show="time().diff > 1">
                                        <span x-text="`${_race.hipodromo.name} ${_race.race.name}`"></span>
                                        <strong class="badge rounded-pill bg-primary" x-text="`NRO ${_race.race_number}`"></strong>
                                        <span class="badge rounded-pill bg-success">
                                            <i class="fa-regular fa-clock"></i>
                                            <span x-text="`${time().days}:${time().hours}:${time().minutes}:${time().seconds}`"></span>
                                        </span>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 shadow border" style="padding-bottom: 25vh;" x-show="!!remate.remateSelected" x-transition:enter.duration.500ms x-transition:leave.duration.50ms x-init="$watch('remate.remateHorses', value => calculeTotal(value))">
                        <div class="col-12 col-md-12">
                            <template x-for="(horse, index) in remate.remateHorses" :key="index">
                                <div class="row border-bottom pb-1">
                                    <div class="col-4 d-flex align-items-center">
                                        <span><strong class="badge rounded-pill bg-info" x-text="horse.horse_number">1</strong>&nbsp;<span x-text="horse.horse_name"></span> <span x-show="!horse.status">(RETIRADO)</span></span>
                                    </div>
                                    <div class="col-4 d-flex align-items-center">
                                        <div>
                                            <label for="">Pagado | Monto</label>
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <input class="form-check-input mt-0" type="checkbox" x-model="horse.status_pago">
                                                </div>
                                                <input type="number" step="0.00" class="form-control" style="height:30px" x-model="horse.monto" x-bind:disabled="!horse.status">
                                            </div>
                                            <!-- <label for="">%:</label>
                                            <input type="number" step="0.00" class="form-control" style="height:30px" x-model="horse.pay_porcent" x-bind:disabled="!horse.status"> -->
                                        </div>
                                    </div>
                                    <div class="col-4 d-flex align-items-center">
                                        <div>
                                            <label for="">Cliente:</label>
                                            <input type="text" step="0.00" style="height:30px" class="form-control" x-model="horse.cliente" x-bind:disabled="!horse.status">
                                            <!-- <label for="">Premio:</label>
                                            <input type="number" step="0.00" style="height:30px" class="form-control" x-model="horse.monto * horse.pay_porcent" disabled="true"> -->
                                        </div>
                                    </div>
                                    <!-- <div class="col-1 d-flex align-items-center">
                                        <div>
                                            <label for="">&nbsp;</label>
                                            <button class="btn btn-primary align-middle"><i class="fa-solid fa-print" x-bind:disabled="!horse.status"></i></button>
                                        </div>
                                    </div> -->
                                </div>
                            </template>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- PANEL DEL REMATE -->
        <div x-bind:class="{ 'd-none': !remate.remateSelected }" class="fixed-bottom d-none" x-show="remate.remateSelected" x-transition:enter.duration.200ms x-transition:leave.duration.50ms>
            <div class="">
                <div class="row">
                    <div class="col-md-6 mt-1 offset-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mt-1">

                                    <div x-init="$watch('remate.remateEditSelected', value => viewRemate(value))">
                                        <template x-for="(code, index) in remate.listCodes" :key="index" class="g-2">
                                            <input type="radio" x-bind:id="code.code" x-bind:value="code.code" x-model="remate.remateEditSelected">
                                        </template>&nbsp;<span x-show="remate.remateEditSelected" x-text="`${remate.remateEditSelected}`"></span> <a href="#" x-show="remate.remateEditSelected" @click="closeEditMode()"> [CANCELAR EDICIÓN]</a> <br>
                                        <span><strong>Total:</strong> <span x-text="`Bs. ${(Math.round(remate.total * 100) / 100).toFixed(2)}`"></span> <strong> Premio:</strong><input type="number" x-model="remate.premio"></span>
                                    </div>

                                    <div class="d-grid gap-1 mt-1">
                                        <button class="btn btn-primary font-bold" @click="saveAndCreateNewRemate()" type="button">Guardar y Agregar Nuevo Remate <i class="fa-solid fa-arrow-right"></i>
                                        </button>
                                        <button class="btn btn-danger" @click="cancelar()"><i class="fa-solid fa-close"></i> Cancelar</button>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function amount() {
        let comming_races = @json($comming_races);
        return {
            remate: {
                remateSelected: false,
                remateHorses: false,
                remateEditSelected: false,
                listCodes: [],
                total: 0,
                premio: 0,
                banca: 0,
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
            _comming_races: comming_races.map((v) => {
                const fecha = new Date(v.start_time).getTime();
                const gmt = obtenerGMTOffset()
                timegmt = fecha + (-gmt * 60) * 60 * 1000;
                local = new Date(timegmt + (4 * 60) * 60 * 1000);
                console.log(new Date(fecha))
                console.log(new Date(timegmt))
                console.log(new Date(local))

                v.start_time = local.getTime();
                return v
            }),
            fetchHorsesForRace: async function(race_id) {
                this.handleBtnSave = true;
                let body = await fetch('/hipismo/fixture_race_horses/get/' + race_id, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                    },
                })
                res = await body.json()
                if (res.valid) {
                    console.log(res)
                    this.remate.remateHorses = res.data
                } else {
                    this.toast(res.message, 5000);
                }
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
            closeEditMode: async function() {
                this.remate.remateEditSelected = undefined;
                await this.fetchHorsesForRace(this.remate.remateSelected);
            },
            validRemate: function() {

                if (this.remate.total < 1) {
                    this.toast(`Limite Total de ventas debe ser mayor a 1`, 6000);
                    return false
                }

                return true

            },
            getRematesCodes: async function(id) {
                this.handleBtnSave = true;
                let body = await fetch('/hipismo/taquilla/remate/getRemateCodes/' + id, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                    },
                })
                let res = await body.json()
                if (res.valid) {
                    this.remate.listCodes = res.data
                } else {
                    this.toast(res.message, 5000);
                }
            },
            viewRemate: async function(code) {
                if (!!!code) {
                    return false
                }
                this.handleBtnSave = true;
                let body = await fetch('/hipismo/taquilla/remate/view/' + code, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                    },
                })
                let res = await body.json()
                if (res.valid) {
                    console.log('THIS', res.data)
                    const rem = res.data.map((v) => {
                        v.status = v.horse.status;
                        v.horse_number = v.horse.horse_number;
                        v.horse_name = v.horse.horse_name;
                        v.jockey_name = v.horse.jockey_name;
                        v.status_pago = !!v.status_pago == 1
                        
                        return v
                    });
                    this.remate.remateHorses = rem;
                    // modificar respuesta
                    // this.remate.listCodes = res.data
                } else {
                    this.toast(res.message, 5000);
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