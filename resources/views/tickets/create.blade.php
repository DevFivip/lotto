@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" x-data="sorteos()" x-init="$watch('numeros', value => choose());$watch('ticket.moneda', value => monedaSelected()); amount()">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10 p-0">
            <div class="card shadow">
                <div class="card-header d-none d-sm-block">Ticket </span></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row row-cols-6">
                                <template x-for="(schedule, index) in schedules">
                                    <div class="d-grid gap-1 mt-1" x-init="index == 0 ? schedule.selected = true : schedule.selected = false">
                                        <button :class="!!!schedule.selected ? 'btn-light': 'btn-dark' " class="btn fw-bold" @click="schedule.selected = !schedule.selected" x-text="schedule.schedule"> </button>
                                    </div>
                                </template>
                            </div>
                            <div class="mt-2" x-show="!turn" style="display: none;">
                                <div class="alert alert-warning" role="alert">
                                    Se han acabado los sorteos del dia de hoy <a href="/cajas/{{$caja->id}}/edit" class="alert-link">Realiza tu cierre de caja</a>.Y vuelve mañana 👋
                                </div>
                            </div>
                            <div class="mt-2" x-show="turn" style="display: none;">
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

                                <!-- Modal -->
                                <div class="modal fade" id="checkOut" tabindex="-1" aria-labelledby="checkOutLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="checkOutLabel">Detalles del Ticket</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <label for="">Seleccione Moneda</label>
                                                <div class="mt-2">
                                                    <template x-for="(moneda, index) in monedas" :key="index">
                                                        <div class="form-check form-check-inline">
                                                            <input x-model="ticket.moneda" class="form-check-input" type="radio" :value="moneda.id.toString()" :id="moneda.currency">
                                                            <label class="form-check-label" :for="moneda.currency" x-text="moneda.nombre"></label>
                                                        </div>
                                                    </template>
                                                </div>
                                                <div class="mt-2">
                                                    <ul class="list-group">
                                                        <template x-for="(item, index) in ticket.detalles" :key="index">
                                                            <li class="list-group-item d-flex justify-content-between align-items-center font-monospace lh-1">
                                                                <span><span x-text="item.number+' '+ item.nombre"></span> <br> <span class="text-muted" x-text="item.schedule"></span> </span>
                                                                <span class=""><span x-text="_monedaSelected.currency"></span>&nbsp;<span x-text="_monedaSelected.simbolo"></span> <span x-text="item.monto"></span>
                                                                    <button class="btn btn-light text-danger" @click="deleteItem(item)"><i class="fa-solid fa-trash-can"></i></button>
                                                                </span>
                                                            </li>
                                                        </template>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center font-monospace lh-1">
                                                            <span><strong>Total</strong></span>
                                                            <strong>
                                                                <span class=""><span x-text="_monedaSelected.currency"></span>&nbsp;<span x-text="_monedaSelected.simbolo"></span> <span x-text="total"></span></span>
                                                            </strong>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                                <button type="button" class="btn btn-primary" @click="guardar()" x-bind:disabled="handleBtnSave"><i class="fa-solid fa-floppy-disk"></i> Generar Ticket</button>
                                            </div>
                                        </div>
                                    </div>
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
                                    <div x-data="schedules.lenght"></div>
                                    <div class="input-group mb-3" x-show="turn" style="display: none;">
                                        <span class="input-group-text">#</span>
                                        <input x-model="numeros" type="text" class="form-control" placeholder="Numeros" aria-label="Numeros">
                                        <span class="input-group-text" x-text="_monedaSelected.simbolo"></span>
                                        <input x-model="monto" type="number" class="form-control" placeholder="Monto" aria-label="Monto">
                                        <button class="btn btn-primary" type="button" id="button-addon2" @click="addItem()">Agregar</button>
                                    </div>
                                    <div class="d-grid gap-1 mt-1">
                                        <button x-show="turn" style="display: none;" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#checkOut"><i class="fa-solid fa-floppy-disk"></i> Guardar <span x-text="_monedaSelected.simbolo"></span> <span x-text="total"></span></button>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="/tickets" class="btn btn-primary"><i class="fa-solid fa-receipt"></i> Listado</a>
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#payTicketModal"><i class="fa-solid fa-money-bill-1-wave"></i> Pagar</button>
                                            <a href="/report-caja/{{$caja->id}}" class="btn btn-primary"><i class="fa-solid fa-print"></i> Reportes</a>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalMenuSettings"><i class="fa-solid fa-bars"></i> Menu</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ModalMenuSettings" tabindex="-1" aria-labelledby="ModalMenuSettingsLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalMenuSettingsLabel">Menú de Navegación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('components.sidemenu')
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="payTicketModal" tabindex="-1" aria-labelledby="payTicketModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="payTicketModalLabel">Buscar ticket ganador para pagar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <label for="exampleFormControlInput1" class="form-label">Código del Ticket</label>
                            <input type="text" class="form-control" id="codetickt" x-model="ticketToSearch">
                        </div>
                        <div class="d-grid gap-2 mt-1">
                            <button class="btn btn-dark" type="button" @click.prevent="handlePay">
                                Buscar <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
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
        console.log(kk.length, !!kk.length)
        var aa = @json($animals);
        var mm = @json($monedas);
        return {
            turn: !!kk.length,
            ticket: {
                moneda: 0,
                detalles: [],
                total: 0,
            },
            _monedaSelected: {},
            monto: '',
            total: 0,
            numeros: '',
            _numeros: [],
            schedules: kk,
            animals: aa,
            monedas: mm,
            handleBtnSave: false,
            handleBtnPaySearch: false,
            ticketToSearch: '',
            amount: function() {
                let moneda = JSON.parse(localStorage.getItem('moneda'));
                this.ticket.moneda = moneda.id
                this._monedaSelected = moneda
            },
            monedaSelected: function() {
                let moneda = this.monedas.filter((v) => v.id == parseInt(this.ticket.moneda))
                this._monedaSelected = moneda[0];
                localStorage.setItem('moneda', JSON.stringify(moneda[0]))
            },
            choose: function() {
                this._numeros = this.numeros.split(' ');
                this.animals = this.animals.filter(v => {
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
            },
            validateItems: function() {
                _sorteos = this.schedules.filter(v => !!v.selected)

                if (_sorteos.length == 0) {
                    this.toast('⚠ Debes Seleccionar un Horario ⏲', 1500)
                    return false
                }

                if (this.numeros.length == 0) {
                    this.toast('⚠ Debes Seleccionar un Animalito 🦝', 1500)
                    return false
                }

                if (isNaN(parseFloat(this.monto))) {
                    this.toast('⚠ Debes escribir un Monto Válido 💸', 1500)
                    return false
                }

                return true;
            },
            deleteItem: function(item) {
                this.ticket.detalles.splice(this.ticket.detalles.indexOf(item), 1);
                this.calcularTotal();
            },
            addItem: function() {

                if (!this.validateItems()) {
                    return false
                }

                const items = [];

                _sorteos = this.schedules.filter(v => !!v.selected)
                __sorteos = _sorteos.map(v => {
                    return {
                        schedule: v.schedule,
                        id: v.id
                    }
                })

                __animals = JSON.parse(JSON.stringify(this.animals.filter(v => !!v.selected)));
                _ani = [];


                for (let i = 0; i < __sorteos.length; i++) {
                    const s = __sorteos[i];
                    for (let e = 0; e < __animals.length; e++) {
                        let a = __animals[e];
                        a.monto = this.monto
                        s.schedule_id = s.id
                        a = {
                            ...a,
                            ...s
                        }
                        a.id = __animals[e].id
                        _ani.push(a)
                    }
                }

                this.ticket.detalles.push(..._ani);

                this.calcularTotal()
                this.toast('Items Agregados correctamente 👍')
                this.clearForm()

            },
            calcularTotal: function() {
                if (!!this.ticket.detalles.length) {
                    this.total = this.ticket.detalles.reduce((a, b) => a + parseFloat(b.monto), 0)
                } else {
                    this.total = 0
                }
                this.ticket.total = this.total
            },
            clearForm: function() {
                this.animals = this.animals.map(v => {
                    v.selected = false;
                    return v
                });
                this.schedules = this.schedules.map(v => {
                    v.selected = false
                    return v
                });
                this.numeros = ''
                this.monto = ''
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
            guardar: async function() {
                this.handleBtnSave = true;
                let body = await fetch('/ticket-register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify(this.ticket)
                })
                res = await body.json()
                timezone = Intl.DateTimeFormat().resolvedOptions().timeZone
                if (res.valid) {
                    window.open(
                        `/print/${res.code}?timezone=${timezone}`, "_blank");
                    location.reload();
                } else {
                    res.messages.forEach(msg => {
                        this.toast(msg, 5000)
                    });
                    // //errores
                    this.handleBtnSave = false;
                    // this.errors = res.messages
                    // this.handleError = true;
                }
            },
            handlePay: async function() {
                this.handleBtnPaySearch = true;
                let body = await fetch('/ticket-validate/' + this.ticketToSearch, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                    },
                })
                res = await body.json()
                if (!!res.valid) {
                    location.replace('/tickets/pay/' + this.ticketToSearch);
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