@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" x-data="amount()">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Ajustes de la Carrera - {{$race->name}} - {{$race->hipodromo->name}} </div>

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
                        <button class="btn btn-primary" @click="addItem()"> Agregar Fixture</button>
                    </div>
                    <form>
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Numero de Carrera</td>
                                    <td>Fecha y Hora de Inicio</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(fixture,index) in _fixtures" :key="index">
                                    <tr>
                                        <td>
                                            <span x-text="fixture.race_number"></span>
                                        </td>
                                        <td>
                                            <input type="datetime-local" class="form-control" x-model="fixture.start_time">
                                        </td>
                                        <td>
                                            <template x-if="!!fixture.id">
                                                <div>
                                                    <a x-bind:href="`/hipismo/fixture_race_horses/${fixture.id}`" class="btn btn-info">Ejemplares 🐎</a>
                                                    <button @click="removeFixture($event,index,fixture.id)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </template>

                                            <template x-if="!fixture.id">
                                                <button @click="removeFixtureNoSave($event,index)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                            </template>

                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>

                        <div class="alert alert-warning" role="alert">
                            <strong>Atención</strong> para agregar ejemplares a la carrera primero guarde los cambios
                        </div>


                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button @click="save($event)" class="btn btn-primary">
                                    {{ __('Guardar Carreras') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function amount() {
        let fixtures = @json($race->fixtures);
        let race_id = @json($race->id);
        let hipodromo_id = @json($race->hipodromo->id);
        return {
            _fixtures: fixtures,
            addItem: function() {
                let count = this._fixtures.length + 1
                const dateNow = this.formatDate(new Date());
                const fixture = {
                    "race_number": count++,
                    "start_time": dateNow,
                    "status": 1,
                    "race_id": race_id,
                    "hipodromo_id": hipodromo_id
                }
                this._fixtures.push(fixture);
            },
            padTo2Digits: function(num) {
                return num.toString().padStart(2, '0');
            },
            formatDate: function(date) {
                return (
                    [
                        date.getFullYear(),
                        this.padTo2Digits(date.getMonth() + 1),
                        this.padTo2Digits(date.getDate()),
                    ].join('-') +
                    ' ' + [
                        this.padTo2Digits(date.getHours()),
                        this.padTo2Digits(date.getMinutes()),
                        this.padTo2Digits(date.getSeconds()),
                    ].join(':')
                );
            },
            removeFixture: async function(e, i, fixture_id) {
                e.preventDefault();
                let con = confirm('Seguro deseas eliminar este registro?');
                if (con) {
                    let body = await fetch('/hipismo/fixture/' + fixture_id, {
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
            removeFixtureNoSave: function(e, i) {
                e.preventDefault();
                this._fixtures.splice(i, 1)
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
                let body = await fetch('/hipismo/fixture/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify(this._fixtures)
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