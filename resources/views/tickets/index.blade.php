@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" x-data="sorteos()" x-init="$watch('numeros', value => choose())">
        <div class="col-md-2">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10 p-0">
            <div class="card shadow">
                <div class="card-header d-none d-sm-block">Ticket</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">

                            <div class="row row-cols-6">
                                <template x-for="(schedule, index) in schedules">
                                    <div class="d-grid gap-1 mt-1">
                                        <button :class="!!!schedule.selected ? 'btn-light': 'btn-dark' " class="btn fw-bold" @click="schedule.selected = !schedule.selected" x-text="schedule.schedule"> </button>
                                    </div>
                                </template>
                            </div>

                            <div class="mt-2">
                                <div class="row row-cols-4">
                                    <template x-for="(animal, index) in animals">
                                        <div class="d-grid gap-1 mt-1">
                                            <button :class="!!!animal.selected ? 'btn-warning': 'btn-dark' " class="btn fw-bold" @click="handleClick(animal.number,animal.selected)">
                                                <p class="p-0 m-0" x-text="animal.number"></p>
                                                <p class="p-0 m-0" style="font-size: 8px;" x-text="animal.nombre"></p>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <div class="row d-none">
                                    <div class="col-md-6 mt-1">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="mt-1">
                                                    <label for="" class="form-label">Monto</label>
                                                    <div class="input-group mb-3">
                                                        <input type="number" class="form-control" placeholder="Monto" aria-label="Monto" aria-describedby="basic-addon2">
                                                        <span class="input-group-text" id="ads">S/ 89</span>
                                                    </div>
                                                    <button class="mt-1 btn btn-primary btn-block">Agregar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-none">
                            <div class="card">
                                <div class="card-header">Detalles del Ticket</div>
                                <div class="card-body">
                                    <div x-data="{show:false};" class="dropdown">
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-dark" type="button" @click="show = ! show">
                                                Seleccione Cliente <i class="fa-solid fa-magnifying-glass"></i>
                                            </button>
                                        </div>
                                        <templete x-data="searchCustomer()">
                                            <ul x-show="show" style="display:none;" x-transition @click.outside="show = false" class="show dropdown-menu dropdown-menu-end dropdown-menu-lg-start p-1">
                                                <li><input x-model="search" type="search" placeholder="Buscar" class="form-control" /></li>
                                                <template x-for="customer in filteredCustomers()" :key="customer.id">
                                                    <li><a class="dropdown-item" href="#" x-text="customer.nombre"></a></li>
                                                </template>
                                            </ul>
                                        </templete>
                                    </div>

                                    <div class="mt-2">
                                        <label for="exampleFormControlInput1" class="form-label">Metodo de Pago</label>
                                        <select class="form-select">
                                            @foreach($payments as $payment)
                                            <option value="{{$payment->id}}">{{$payment->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mt-2">
                                        <label for="exampleFormControlInput1" class="form-label">Moneda</label>
                                        <select class="form-select">
                                            @foreach($monedas as $moneda)
                                            <option value="{{$moneda->id}}">{{$moneda->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mt-2">
                                        <ul class="list-group">
                                            <li class="list-group-item d-flex justify-content-between align-items-center font-monospace lh-1">
                                                <span>0 Delfin <br> <span class="text-muted"> 10 AM</span> </span>
                                                <span class="">$ 100,000.00</span>
                                            </li>

                                            <li class="list-group-item d-flex justify-content-between align-items-center font-monospace lh-1">
                                                <span>1 Carnero <br> <span class="text-muted"> 10 AM</span> </span>
                                                <span class="">$ 100,000.00</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="mt-2">
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-primary">Guardar Ticket</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed-bottom">
            <div class="">
                <div class="row">
                    <div class="col-md-6 mt-1">
                        <div class="card">
                            <div class="card-body">
                                <div class="mt-1">
                                    <span class="float-end">Total: <span class="fw-bold">$ 150</span></span>
                                    <span x-text="numeros"></span>
                                    <span>asdsad</span>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">#</span>
                                        <input x-model="numeros" type="text" class="form-control" placeholder="Numeros" aria-label="Numeros">
                                        <span class="input-group-text">$</span>
                                        <input x-model="monto" type="text" class="form-control" placeholder="Monto" aria-label="Monto">
                                    </div>
                                    <div class="btn-group">
                                        <button class="mt-1 btn btn-primary">Agregar</button>
                                        <button class="mt-1 btn btn-primary">Agregar</button>
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
    function searchCustomer() {
        return {
            qq: @json($customers),
            search: '',
            filteredCustomers: function() {
                return this.qq.filter(customer => customer.nombre.toLowerCase().includes(this.search.toLowerCase()))
            }
        }
    }



    function sorteos() {
        var kk = @json($schedules);
        var aa = @json($animals);

        return {
            monto: 0,
            numeros: '',
            _numeros: [],
            schedules: kk,
            animals: aa,
            choose: function() {
                console.log('>', this.numeros);
                this._numeros = this.numeros.split(' ');
                this.animals = this.animals.filter(v => {
                    console.log(this._numeros);
                    if (this._numeros.indexOf(v.number) >= 0) {
                        v.selected = true;
                        return v
                    } else {
                        v.selected = false;
                        return v
                    }
                })
            },
            handleClick: function(number, st) {
                if (!st) {
                    this.animals = this.animals.map((v, k) => {
                        if (v.number == number) {
                            v.selected = true;
                            this._numeros.push(number)
                            this.numeros = this._numeros.join(' ');
                            return v;
                        } else {
                            return v
                        }
                    })
                } else {
                    this.animals = this.animals.map((v, k) => {
                        if (v.number == number) {
                            v.selected = false;
                            this._numeros = this._numeros.filter(v => v !== number)
                            this.numeros = this._numeros.join(' ');
                            return v;
                        } else {
                            return v
                        }
                    })
                }
            }
        }

    }


    function converter(q, k) {
        date = new Date(q);
        w = date.getTimezoneOffset()
        yourDate = new Date(date.getTime() - (w * 60 * 1000))
        f1 = yourDate.toLocaleDateString();
        f2 = yourDate.toLocaleTimeString();

        if (!!k) {
            date = new Date(k);
            r = date.getTimezoneOffset()
            yourDate = new Date(date.getTime() - (r * 60 * 1000))
            f3 = yourDate.toLocaleDateString();
            f4 = yourDate.toLocaleTimeString();

        } else {
            f3 = '';
            f4 = '';
        }


        return {
            fecha_inicial: f1 + ' ' + f2,
            fecha_cierre: f3 + ' ' + f4,
        }
    }
</script>

@endsection