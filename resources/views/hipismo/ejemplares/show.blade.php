@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" x-data="amount()">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Ajustes de la Carrera {{$race->race->name}} Nro {{$race->race_number}} - {{$race->hipodromo->name}} </div>
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
                        <button class="btn btn-primary" @click="addItem()"> Agregar Ejemplar</button>
                    </div>

                    <template x-for="(horse,index) in _horses" :key="index">
                        <div class="row m-2 g-1 border p-2 rounded shadow bg-color">
                            <div class="col-6 col-md-1">
                                <label for="" class="col-form-label">Numero</label>
                                <input type="number" x-model="horse.horse_number" class="form-control">

                            </div>
                            <div class="col-6 col-md-3">
                                <label for="" class="col-form-label">Nombre</label>
                                <input type="text" x-model="horse.horse_name" class="form-control">

                            </div>
                            <div class="col-6 col-md-3">
                                <label for="" class="col-form-label">Jockey</label>
                                <input type="text" x-model="horse.jockey_name" class="form-control">
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="row g-1">
                                    <div class="col-6 col-md-6">
                                        <label for="" class="col-form-label">Posición</label>
                                        <input type="number" x-model="horse.place" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <template x-if="!!horse.id">
                                    <div>
                                        <button @click="remateWinner($event,horse.id)" x-bind:class="{ 'btn btn-warning': !!horse.remate_winner, 'btn btn-danger': !horse.remate_winner }"><span x-text="horse.remate_winner?'🏅':'⏱️'"></span></button>
                                        <button @click="disable($event,horse.id)" x-bind:class="{ 'btn btn-warning': !!horse.status, 'btn btn-danger': !horse.status }"><i x-bind:class="{ 'fa fa-check': !!horse.status, 'fa-solid fa-x': !horse.status }"></i></button>
                                        <button @click="removeHorse($event,index,horse.id)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                    </div>
                                </template>
                                <template x-if="!horse.id">
                                    <button @click="removeHorseNoSave($event,index)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                </template>
                            </div>
                        </div>
                    </template>

                    <div class="row mb-0">
                        <div class="col-md-6">
                            <button class="btn btn-primary" @click="addItem()"> Agregar Ejemplar</button>
                            <button @click="save($event)" class="btn btn-success">
                                {{ __('Guardar Cambios') }}
                            </button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <div class="alert alert-success">
                                <strong>Atención!</strong> <span>antes de rellenar el siguiente formulario complete el listado de posición de los ejemplares</span>.
                            </div>
                        </div>
                    </div>

                    <div x-init="watchPlaces()">
                        <div class="row">
                            <div class="col-6 col-md-3">
                                <label for="" class="col-form-label">Ganador Combinación</label>
                                <input type="text" disabled x-model="banca.ganador.combinacion" class="form-control">
                            </div>
                            <div class="col-6 col-md-3">
                                <label for="" class="col-form-label">Ganador Total</label>
                                <input type="number" x-model="banca.ganador.total" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 col-md-3">
                                <label for="" class="col-form-label">Perfecta Combinación</label>
                                <input disabled="text" x-model="banca.perfecta.combinacion" class="form-control">
                            </div>
                            <div class="col-6 col-md-3">
                                <label for="" class="col-form-label">Perfecta Total</label>
                                <input type="number" x-model="banca.perfecta.total" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 col-md-3">
                                <label for="" class="col-form-label">Trifecta Combinación</label>
                                <input disabled type="text" x-model="banca.trifecta.combinacion" class="form-control">
                            </div>
                            <div class="col-6 col-md-3">
                                <label for="" class="col-form-label">Trifecta Total</label>
                                <input type="number" x-model="banca.trifecta.total" class="form-control">
                            </div>
                        </div>

                        <button class="btn btn-success mt-1" @click="guardarCombinaciones($event)"><i class="fa fa-save"></i> Guardar Combinación</button>

                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function amount() {
        let resultados = @json($resultados);
        let horses = @json($horses);
        let race_id = @json($race_id);
        return {
            banca: {
                ganador: {
                    combinacion: '',
                    win: ''
                },
                perfecta: {
                    combinacion: '',
                    win: ''
                },
                trifecta: {
                    combinacion: '',
                    win: ''
                },
            },
            _horses: horses,
            watchPlaces: function() {
                console.log('CHANGE')
                // verificar 1er lugar
                verif1 = this._horses.filter((v) => v.place === 1);
                verif2 = this._horses.filter((v) => v.place === 2);
                verif3 = this._horses.filter((v) => v.place === 3);
                // console.log(verif1)
                console.log(verif1);
                this.banca.ganador.combinacion = verif1[0].horse_number;
                this.banca.perfecta.combinacion = `${verif1[0].horse_number}-${verif2[0].horse_number}`;
                this.banca.trifecta.combinacion = `${verif1[0].horse_number}-${verif2[0].horse_number}-${verif3[0].horse_number}`;

            },
            guardarCombinaciones: async function(e) {
                e.preventDefault();
                let body = await fetch('/hipismo/fixture_race_horses/combinacion-save/' + race_id, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify(this.banca)
                })
                res = await body.json()

                if (res.valid) {
                    this.toast(res.message, 5000);
                    // location.reload()
                } else {
                    this.toast(res.message, 5000);
                }
            },

            addItem: function() {
                let count = this._horses.length + 1
                const horse = {
                    "horse_number": '',
                    "horse_name": '',
                    "status": 1,
                    "jockey_name": '',
                    "fixture_race_id": race_id
                }
                this._horses.push(horse);
            },
            removeHorse: async function(e, i, horse_id) {
                e.preventDefault();
                let con = confirm('Seguro deseas eliminar este registro?');
                if (con) {
                    let body = await fetch(`/hipismo/fixture_race_horses/${horse_id}/remove`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                        }
                    })
                    res = await body.json()
                    if (res.valid) {
                        this.toast('Eliminado correctamente');
                        location.reload();
                    }
                }
            },
            removeHorseNoSave: function(e, i) {
                e.preventDefault();
                this._horses.splice(i, 1)
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
            save: async function(e) {
                e.preventDefault();
                this.handleBtnSave = true;
                let body = await fetch('/hipismo/fixture_race_horses/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify(this._horses)
                })
                res = await body.json()

                if (res.valid) {
                    this.toast(res.message, 5000);
                    location.reload()
                } else {
                    this.toast(res.message, 5000);
                }
            },
            remateWinner: async function(e, horse_id) {
                e.preventDefault();
                this.handleBtnSave = true;
                let body = await fetch(`/hipismo/fixture_race_horses/${horse_id}/remate_winner`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify(this._horses)
                })
                res = await body.json()

                if (res.valid) {
                    this.toast(res.message, 5000);
                    location.reload()
                } else {
                    this.toast(res.message, 5000);
                }
            },
            disable: async function(e, horse_id) {
                e.preventDefault();
                this.handleBtnSave = true;
                let body = await fetch(`/hipismo/fixture_race_horses/${horse_id}/disable`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify(this._horses)
                })
                res = await body.json()

                if (res.valid) {
                    this.toast(res.message, 5000);
                    location.reload()
                } else {
                    this.toast(res.message, 5000);
                }
            },
            remove: async function(e, horse_id) {
                e.preventDefault();
                this.handleBtnSave = true;
                let body = await fetch(`/hipismo/fixture_race_horses/${horse_id}/remove`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify(this._horses)
                })
                res = await body.json()

                if (res.valid) {
                    this.toast(res.message, 5000);
                    location.reload()
                } else {
                    this.toast(res.message, 5000);
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