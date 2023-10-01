@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" x-data="amount()">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10 p-0" x-init="$watch('hipodromo.hipodromoSelected', value => getCommingRaces(value))">
            <div class="card shadow">
                <div class="card-header d-none d-sm-block ">Banca Hipodromo</div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-12 col-md-6">
                            <select class="form-select" x-model="hipodromo.hipodromoSelected">
                                <option :value="false"> Seleccione Hipodromo</option>
                                <template x-for="(hipodromo, index) in hipodromos" :key="index">
                                    <option :value="hipodromo.id" x-text="hipodromo.name"></option>
                                </template>
                            </select>
                        </div>

                        <div class="col-12 col-md-12" x-show="!hipodromo.horseSelected" x-transition:enter.duration.200ms x-transition:leave.duration.50ms>
                            <div class="row mt-2">
                                <div class="col-12 col-md-12">
                                    <div class="list-group">
                                        <template x-for="_race in commingRaces.fixtures">
                                            <div>
                                                <a @click="getHorsesFromRace(_race.id)" class="list-group-item list-group-item-action" x-data="timer(_race.start_time)"  x-show="time().diff > 1">
                                                    <strong class="badge rounded-pill bg-primary" x-text="`Carrera Nro ${_race.race_number}`"></strong>
                                                    <span class="badge rounded-pill bg-success">
                                                        <i class="fa-regular fa-clock"></i>
                                                        <span x-text="`${time().days}:${time().hours}:${time().minutes}:${time().seconds}`"></span>
                                                    </span>
                                                </a>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-12" style="height:1000px;" x-show="!!hipodromo.horseSelected" x-transition:enter.duration.200ms x-transition:leave.duration.50ms>
                            <div class="row mt-2">
                                <div class="col-12 col-md-12">
                                    <table class="table">
                                        <tr>
                                            <td>Nro</td>
                                            <td>Ejemplar</td>
                                            <template x-for="i in Number(form.type)">
                                                <td x-text="i">1</td>
                                            </template>
                                        </tr>
                                        <template x-for="_horse in hipodromo.horses">
                                            <tr>
                                                <td x-text="_horse.horse_number"></td>
                                                <td x-text="_horse.horse_name"></td>
                                                <template x-for="i in Number(form.type)">
                                                    <td><input :value="i" type="checkbox" x-model="_horse['odd_'+i]"></td>
                                                </template>
                                            </tr>
                                        </template>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="fixed-bottom">
                            <div class="">
                                <div class="row">
                                    <div class="col-md-6 mt-1 offset-md-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="mt-1">
                                                    <div class="d-grid gap-1 mt-1">
                                                        <label for="">Tipo de Apuesta</label>
                                                        <select class="form-select" id="" x-model="form.type">
                                                            <option value="1">Ganador</option>
                                                            <option value="2">Exacta</option>
                                                            <option value="3">Trifecta</option>
                                                        </select>
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="">Unidades</label>
                                                                <input type="number" class="form-control" x-model="ticket.unidades">
                                                            </div>
                                                            <div class="col">
                                                                <label for="">Total Bs</label>
                                                                <input type="number" class="form-control" disabled :value="(ticket.unidades * ticket.monto_banca).toFixed(2)">
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary font-bold" type="button" @click="validate()"><i class="fa-solid fa-save"></i> Guardar
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
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function amount() {
        const monto_banca = @json($monto_banca);
        const hipodromos = @json($hipodromos);
        // console.log(_hipodromos)
        return {
            form: {
                type: 1,
            },
            ticket: {
                monto_banca: monto_banca,
                unidades: 0,
            },
            hipodromos: hipodromos,
            hipodromo: {
                hipodromoSelected: false,
                horses: [],
                horseSelected: false,
            },
            validate: async function() {

                if (this.ticket.unidades < 1) {
                    this.toast('El monto minimo de unidades debe ser 1 o superior', 3000);
                    return false
                }

                switch (Number(this.form.type)) {
                    case 1:
                        validate = this.hipodromo.horses.filter((v) => v.odd_1 === true);

                        if (validate.length === 0) {
                            this.toast('Debes seleccionar (1) un Ganador', 3000);
                            return false;
                        }

                        if (validate.length === 1) {
                            await this.bancaSave()
                        } else {
                            this.toast('Debes seleccionar solo (1) un Ganador', 3000);
                            return false
                        }
                        break;

                    case 2:
                        validate_1 = this.hipodromo.horses.filter((v) => v.odd_1 === true);
                        if (validate_1.length === 0) {
                            this.toast('Debes seleccionar (1) una opcion de 1er Primer Lugar', 3000);
                            return false;
                        }
                        if (validate_1.length === 1) {
                            this.toast('validacion 1 success');
                        } else {
                            this.toast('Debes seleccionar solo (1) una opcion de 1er Primer Lugar', 3000);
                            return false
                        }

                        validate_2 = this.hipodromo.horses.filter((v) => v.odd_2 === true);
                        if (validate_2.length === 0) {
                            this.toast('Debes seleccionar (1) una opcion de 2do Segundo Lugar', 3000);
                            return false;
                        }

                        if (validate_2.length === 1) {
                            this.toast('validacion 2 success');
                        } else {
                            this.toast('Debes seleccionar solo (1) una opcion de 2do Segundo Lugar', 3000);
                            return false
                        }

                        if (validate_1[0].id === validate_2[0].id) {
                            console.log(validate_1[0].id, validate_2[0].id)
                            this.toast('El primer y segundo lugar no deben ser el mismo ejemplar', 3000);
                            return false
                        } else {
                            await this.bancaSave()
                        }

                        break;
                    case 3:
                        validate_1 = this.hipodromo.horses.filter((v) => v.odd_1 === true);
                        if (validate_1.length === 0) {
                            this.toast('Debes seleccionar (1) una opcion de 1er Primer Lugar', 3000);
                            return false;
                        }
                        if (validate_1.length === 1) {
                            this.toast('validacion 1 success');
                        } else {
                            this.toast('Debes seleccionar solo (1) una opcion de 1er Primer Lugar', 3000);
                            return false
                        }

                        validate_2 = this.hipodromo.horses.filter((v) => v.odd_2 === true);
                        if (validate_2.length === 0) {
                            this.toast('Debes seleccionar (1) una opcion de 2do Segundo Lugar', 3000);
                            return false;
                        }

                        if (validate_2.length === 1) {
                            this.toast('validacion 2 success');
                        } else {
                            this.toast('Debes seleccionar solo (1) una opcion de 2do Segundo Lugar', 3000);
                            return false
                        }

                        validate_3 = this.hipodromo.horses.filter((v) => v.odd_3 === true);
                        if (validate_3.length === 0) {
                            this.toast('Debes seleccionar (1) una opcion de 3er Tercer Lugar', 3000);
                            return false;
                        }

                        if (validate_3.length === 1) {
                            this.toast('validacion 3 success');
                        } else {
                            this.toast('Debes seleccionar solo (1) una opcion de 3er Tercer Lugar', 3000);
                            return false
                        }

                        if (validate_1[0].id === validate_2[0].id || validate_1[0].id === validate_3[0].id || validate_2[0].id === validate_3[0].id) {
                            console.log(validate_1[0].id, validate_2[0].id)
                            this.toast('El Primer, Segundo y Tercer lugar no deben ser el mismo ejemplar', 3000);
                            return false
                        } else {
                            await this.bancaSave()
                        }

                        break;

                    default:
                        break;
                }
            },
            bancaSave: async function() {

                let data = {
                    fixture_race_id: this.race.race_id,
                    unidades: this.ticket.unidades,
                    horses: this.hipodromo.horses,
                    type: this.form.type,
                    precio_unidad: this.ticket.monto_banca
                }


                let body = await fetch('/hipismo/taquilla-banca/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify(data)
                })
                res = await body.json()
                if (res.valid) {
                    console.log(res)
                    this.handleOpenPreviewApuesta(res.data.id)
                    location.reload();
                } else {
                    this.toast(res.message, 5000);
                }
            },

            selectHipodromo: function($id) {
                this.getCommingRaces($id);
                this.hipodromo.hipodromoSelected = $id;
            },
            race: {
                raceSelected: false,
            },
            commingRaces: {
                fixtures: []
            },
            _fixtures: (fixtures) => fixtures.map((v) => {
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
                    console.log(res.data[0])
                    this.commingRaces = res.data[0]
                    this.commingRaces.fixtures = this._fixtures(res.data[0].fixtures);
       
                } else {
                    this.toast(res.message, 5000);
                }
            },
            getHorsesFromRace: async function(raceid) {
                this.race.race_id = raceid;
                let body = await fetch('/hipismo/fixture_race_horses/get/' + raceid, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                    },
                })
                res = await body.json()
                if (res.valid) {
                    this.hipodromo.horses = res.data;
                    this.hipodromo.horseSelected = true;
                } else {
                    this.toast(res.message, 5000);
                }
            },
            handleOpenPreviewApuesta: async function(id) {
                let win = window.open(`/hipismo/taquilla-banca/print/${id}`, "_blank", 'width=400, height=400');
                let q = win.focus();
                let w = win.print();
            },
            remateSelect: async function(id) {
                await this.fetchHorsesForRace(id);
                await this.getRematesCodes(id)
                this.remate.remateSelected = id
            },
            cancelar: function() {
                console.log('cancelar')
                this.hipodromo.horseSelected = false;
                this.hipodromo.horses = [];
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