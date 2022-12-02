@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" x-data="sorteos()" x-init="$watch('numeros', value => choose());$watch('ticket.moneda', value => monedaSelected());$watch('ticket.type_sorteo_id', value => sorteoSelected()); amount()">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10 p-0">
            <div class="card shadow">
                <div class="card-header d-none d-sm-block">Ticket</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col">

                                    @foreach($sorteos as $sorteo)
                                    <div class="form-check form-check-inline">
                                        <input x-model="ticket.type_sorteo_id" class="form-check-input" type="radio" value="{{$sorteo->id}}" id="{{str_replace(' ','',$sorteo->name)}}">
                                        <label class="form-check-label" for="{{str_replace(' ','',$sorteo->name)}}">{{$sorteo->name}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row row-cols-6">

                                @foreach($sorteos as $sorteo)
                                <template x-if="ticket.type_sorteo_id == {{$sorteo->id}}">
                                    <template x-for="(schedule, index) in schedules">
                                        <template x-if="schedule.sorteo_type_id == {{$sorteo->id}}">
                                            <div class="d-grid gap-1 mt-1" x-init="index == 0 ? schedule.selected = true : schedule.selected = false">
                                                <button :class="!!!schedule.selected ? 'btn-light': 'btn-dark' " class="btn fw-bold" @click="schedule.selected = !schedule.selected" x-text="schedule.schedule"> </button>
                                            </div>
                                        </template>
                                    </template>
                                </template>
                                @endforeach
                            </div>
                            <div class="mt-2" x-show="!turn" style="display: none;">
                                <div class="alert alert-warning" role="alert">
                                    Se han acabado los sorteos del dia de hoy. Vuelve mañana 👋
                                </div>
                            </div>
                            <div class="mt-2" x-show="turn" style="display: none;">
                                <div class="row row-cols-4">
                                    <template x-for="(animal, index) in animals">
                                        <template x-if="animal.sorteo_type_id == ticket.type_sorteo_id">
                                            <div class="d-grid gap-1 mt-1">
                                                <button :class="!!!animal.selected ? 'btn-warning': 'btn-dark' " class="btn fw-bold" @click="handleClick(animal.number,animal.selected)">
                                                    <p class="p-0 m-0" x-text="animal.number"></p>
                                                    <p class="p-0 m-0" style="font-size: 8px;" x-text="animal.nombre"></p>
                                                </button>
                                            </div>
                                        </template>
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
                                                                <span><span x-text="item.number+' '+ item.nombre"></span> <br> <span class="text-muted" x-text="item.schedule"></span> <span class="text-muted" x-text="item.type.name"></span> </span>
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
                    <div class="col-md-6 mt-1 offset-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mt-1">
                                    <div x-data="schedules.lenght"></div>
                                    <div class="input-group mb-3" x-show="turn" style="display: none;">
                                        <span class="input-group-text">#</span>
                                        <input x-model="numeros" type="text" class="form-control" placeholder="Numeros" aria-label="Numeros">
                                        <span class="input-group-text" x-text="_monedaSelected.simbolo"></span>
                                        <input x-model="monto" type="number" class="form-control" placeholder="Monto" aria-label="Monto" min="0.10">
                                        <button class="btn btn-primary" type="button" id="button-addon2" @click="addItem()">Agregar</button>
                                    </div>
                                    <div class="d-grid gap-1 mt-1">
                                        <button x-show="turn" style="display: none;" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#checkOut"><i class="fa-solid fa-floppy-disk"></i> Guardar <span x-text="_monedaSelected.simbolo"></span> <span x-text="total"></span></button>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <!-- <a href="/tickets" class="btn btn-primary"><i class="fa-solid fa-receipt"></i> Listado</a> -->
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#payTicketModal"><i class="fa-solid fa-money-bill-1-wave"></i> Pagar</button>
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#repeatTicketModal"><i class="fa-solid fa-repeat"></i> Repetir</button>
                                            <a x-bind:href="'/reports/general?fecha_inicio='+fechaHoy+'&fecha_fin='+fechaHoy" class="btn btn-primary"><i class="fa-solid fa-print"></i> Reportes</a>
                                            <a href="/balance-caja/{{$caja->id}}" class="btn btn-primary"><i class="fa-solid fa-cash-register"></i> Caja</a>
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

        <div class="modal fade" id="repeatTicketModal" tabindex="-1" aria-labelledby="repeatTicketModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="repeatTicketModalLabel">Buscar ticket para Repetir</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/tickets-repeat" method="GET">
                            <div class="">
                                <label for="exampleFormControlInput1" class="form-label">Código del Ticket</label>
                                <input type="text" name="code" class="form-control" id="codetickt">
                            </div>
                            <div class="d-grid gap-2 mt-1">
                                <button class="btn btn-dark" type="submit">
                                    Buscar <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
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
        console.log(kk, kk.length, !!kk.length)
        var aa = @json($animals);
        var mm = @json($monedas);
        return {
            turn: !!kk.length,
            ticket: {
                type_sorteo_id: !!!localStorage.getItem('sorteo') ? 1 : localStorage.getItem('sorteo'),
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
            fechaHoy: (new Date()).toISOString().split('T')[0],
            ticketToSearch: '',
            impresion_type: !!!localStorage.getItem('impresion_type') ? 0 : localStorage.getItem('impresion_type'),
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
            sorteoSelected: function() {
                // let moneda = this.monedas.filter((v) => v.id == parseInt(this.ticket.moneda))
                // this._monedaSelected = moneda[0];
                this.clearForm()
                localStorage.setItem('sorteo', this.ticket.type_sorteo_id)
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
                        if (parseInt(v?.type?.id) == parseInt(this.ticket?.type_sorteo_id)) {
                            console.log(v.type.id)
                            if (v.number == number) {
                                v.selected = true;
                                this._numeros.push(number)
                                this.numeros = this._numeros.join(' ');
                                return v;
                            } else {
                                return v
                            }
                        } else {
                            return v
                        }

                    })
                } else {
                    this.animals = this.animals.map((v, k) => {
                        if (parseInt(v.type.id) == parseInt(this.ticket.type_sorteo_id)) {
                            if (v.number == number) {
                                v.selected = false;
                                this._numeros = this._numeros.filter(v => v !== number)
                                this.numeros = this._numeros.join(' ');
                                return v;
                            } else {
                                return v
                            }
                        } else {
                            return v
                        }
                    })
                }
            },
            validateItems: function() {
                _sorteos = this.schedules.filter(v => !!v.selected)

                if (!this.ticket.type_sorteo_id) {
                    this.toast('⚠ Debes Seleccionar Sorteo 🦝', 2500)
                    return false
                }

                if (_sorteos.length == 0) {
                    this.toast('⚠ Debes Seleccionar un Horario ⏲', 2500)
                    return false
                }

                if (this.numeros.length == 0) {
                    this.toast('⚠ Debes Seleccionar un Animalito 🦝', 2500)
                    return false
                }

                if (isNaN(parseFloat(this.monto))) {
                    this.toast('⚠ Debes escribir un Monto Válido 💸', 2500)
                    return false
                }

                if (parseFloat(this.monto) < 0.10) {
                    this.toast('⚠ El monto debe ser mayor a 0.10 💸', 2500)
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

                _sorteos = this.schedules.filter(v => !!v.selected);
                //    _sorteos = this.sorteos.filter(v => parseInt(v.type.id) === parseInt(this.ticket.type_sorteo_id));
                __sorteos = _sorteos.map(v => {
                    return {
                        schedule: v.schedule,
                        id: v.id
                    }
                })

                __animals = JSON.parse(JSON.stringify(this.animals.filter(v => !!v.selected && parseInt(v?.type?.id) === parseInt(this.ticket.type_sorteo_id))));
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
                    if (localStorage.getItem('printer') && localStorage.getItem('printer_url')) {

                        const ticket = this.checkTypesDetalle(res.ticket);
                        const k = Object.keys(res.ticket_detalles)
                        const td = []

                        for (let i = 0; i < k.length; i++) {
                            const grupo = res.ticket_detalles[k[i]];
                            td[i] = []
                            const grupo_keys = Object.keys(grupo)
                            for (let g = 0; g < grupo_keys.length; g++) {
                                td[i][g] = grupo[grupo_keys[g]]
                                const horario = grupo[grupo_keys[g]];
                                const horario_keys = Object.keys(horario)

                                for (let h = 0; h < horario_keys.length; h++) {
                                    const animalito = horario[horario_keys[h]];
                                    td[i][g][h] = this.checkTypesAnimalito(animalito);
                                }
                            }
                        }

                        const st = await this.printDirect(localStorage.getItem('printer'), localStorage.getItem('printer_url'), ticket, td, localStorage.getItem('paper_width'))

                        this.toast('Imprimiendo...', 5000)

                        setTimeout(() => {
                            location.reload();
                        }, 1500);

                    } else {

                        if (this.impresion_type == 0) {
                            window.open(`/print/${res.code}?timezone=${timezone}`, "_blank");
                            location.reload();
                            return true
                        }


                        if (this.impresion_type == 1) {
                            let win = window.open(`/print2/${res.code}?timezone=${timezone}`, "_blank", 'width=400, height=400');
                            let q = win.focus();
                            let w = win.print();


                            // win.close();
                            setTimeout(() => {
                                win.close();
                                location.reload();
                            }, 1200);

                            return true
                        }

                    }


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
            checkTypesDetalle: function(detalle) {
                // debugger
                fecha = converter2(detalle.created_at);
                _detalle = {};
                _detalle.id = parseInt(detalle.id)
                _detalle.code = (detalle.code).toString()
                _detalle.caja_id = parseInt(detalle.caja_id)
                _detalle.user_id = parseInt(detalle.user_id)
                _detalle.admin_id = parseInt(detalle.admin_id)
                _detalle.total = parseFloat(detalle.total)
                _detalle.has_winner = parseInt(detalle.has_winner)
                _detalle.status = parseInt(detalle.status)
                _detalle.created_at = (fecha.fecha_inicial).toString()
                _detalle.updated_at = (detalle.updated_at).toString()
                _detalle.user = this.checkTypesUser(detalle.user)
                _detalle.moneda = detalle.moneda
                _detalle.moneda_id = parseInt(detalle.moneda_id)
                _detalle.caja = this.checkTypesCaja(detalle.caja)
                return _detalle
            },
            checkTypesUser: function(user) {
                _user = {};
                _user.id = parseInt(user.id);
                _user.taquilla_name = user.taquilla_name;
                _user.name = user.name;
                _user.email = user.email;
                _user.email_verified_at = user.email_verified_at;
                _user.parent_id = parseInt(user.parent_id);
                _user.monedas = user.monedas;
                _user.created_at = user.created_at;
                _user.updated_at = user.updated_at;
                _user.role_id = parseInt(user.role_id);
                _user.status = parseInt(user.status);
                _user.comision = parseInt(user.comision);
                return _user;
            },
            checkTypesCaja: function(caja) {
                _caja = {};
                _caja.id = parseInt(caja.id);
                _caja.user_id = parseInt(caja.user_id);
                _caja.close_user_id = parseInt(caja.close_user_id);
                _caja.fecha_apertura = caja.fecha_apertura;
                _caja.fecha_cierre = caja.fecha_cierre;
                _caja.balance_inicial = caja.balance_inicial;
                _caja.balance_final = caja.balance_final;
                _caja.entrada = caja.entrada;
                _caja.status = caja.status;
                _caja.referencia = caja.referencia;
                _caja.created_at = caja.created_at;
                _caja.updated_at = caja.updated_at;
                _caja.admin_id = parseInt(caja.admin_id);
                return _caja;
            },
            checkTypesAnimalito: function(animalito) {
                _animalito = {};
                _animalito.id = parseInt(animalito.id);
                _animalito.register_id = parseInt(animalito.register_id);
                _animalito.animal_id = parseInt(animalito.animal_id);
                _animalito.schedule = this.checkTypeSchedule(animalito.schedule);
                _animalito.schedule_id = parseInt(animalito.schedule_id);
                _animalito.admin_id = parseInt(animalito.admin_id);
                _animalito.winner = parseInt(animalito.winner);
                _animalito.monto = parseFloat(animalito.monto);
                _animalito.moneda_id = parseInt(animalito.moneda_id);
                _animalito.created_at = animalito.created_at;
                _animalito.updated_at = animalito.updated_at;
                _animalito.user_id = parseInt(animalito.user_id);
                _animalito.caja_id = parseInt(animalito.caja_id);
                _animalito.status = parseInt(animalito.status);
                _animalito.sorteo_type_id = parseInt(animalito.sorteo_type_id);
                _animalito.type = animalito.type;
                _animalito.animal = this.checkTypeAnimal(animalito.animal);

                return _animalito;
            },
            checkTypeSchedule: function(schedule) {
                _schedule = {};
                _schedule.id = parseInt(schedule.id);
                _schedule.schedule = schedule.schedule;
                _schedule.interval_start_utc = schedule.interval_start_utc;
                _schedule.interval_end_utc = schedule.interval_end_utc;
                _schedule.status = parseInt(schedule.status);
                _schedule.created_at = schedule.created_at;
                _schedule.updated_at = schedule.updated_at;
                _schedule.sorteo_type_id = parseInt(schedule.sorteo_type_id);
                return _schedule;
            },
            checkTypeAnimal: function(animal) {
                _animal = {};
                _animal.id = parseInt(animal.id)
                _animal.number = (animal.number).toString()
                _animal.nombre = (animal.nombre).toString()
                _animal.limit_cant = animal.limit_cant
                _animal.limit_price_usd = animal.limit_price_usd
                _animal.status = animal.status
                _animal.created_at = animal.created_at
                _animal.updated_at = animal.updated_at
                _animal.sorteo_type_id = animal.sorteo_type_id
                return _animal
            },
            setType: function(e, want) {

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
            },
            printDirect: async function(printer, url, detalles, ticket, paper_width) {
                let res;
                axios(`${url}/print`, {
                    method: 'POST',
                    mode: 'no-cors',
                    data: {
                        printer,
                        detalles,
                        ticket,
                        paper_width
                    }
                }).then(({
                    data
                }) => {
                    this.toast('✌', 3000)
                    res = data;
                    // console.log(data);
                }).catch((e) => {
                    this.toast('Verifica el la url del pluggin', 3000)
                    this.toast('Asegurate que tengas instalado el pluggin de impresion en tu computadora local', 3000)
                    res = false;
                    // console.log(e);
                });
                return res;

            }

        }

    }


    function converter2(q, k) {
        date = new Date(q);
        w = date.getTimezoneOffset()
        yourDate = new Date(date.getTime())
        f1 = yourDate.toLocaleDateString();
        f2 = yourDate.toLocaleTimeString();

        if (!!k) {
            date = new Date(k);
            r = date.getTimezoneOffset()
            yourDate = new Date(date.getTime())
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