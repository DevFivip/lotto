@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" x-data="sorteos()" x-init="$watch('numeros', value => choose());$watch('ticket.moneda', value => monedaSelected());$watch('ticket.type_sorteo_id', value => sorteoSelected()); amount()">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10 p-0">
            <div class="card shadow">
                <div class="card-header d-none d-sm-block ">Tripleta</div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12 col-12" style="max-height: 55vh; overflow: auto;">
                            <template x-for="(detalle, index) in ticket.detalles" :key="index">
                                <div class="row mb-3">
                                    <div class="col-md-10 col-10">
                                        <div class="row g-1">
                                            <div class="col-md-2 col-4">
                                                <input x-model="detalle._1ero" @change="validateNumber($event,index,'_1ero')" type="number" placeholder="1er Animalito" class="form-control" />
                                            </div>
                                            <div class="col-md-2 col-4">
                                                <input x-model="detalle._2do" @change="validateNumber($event,index,'_2do')" type="number" placeholder="2do Animalito" class="form-control" />
                                            </div>
                                            <div class="col-md-2 col-4">
                                                <input x-model="detalle._3ero" @change="validateNumber($event,index,'_3ero')" type="number" placeholder="3er Animalito" class="form-control" />
                                            </div>
                                            <div class="col-md-2 col-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1" x-text="_monedaSelected.simbolo"></span>
                                                    <input x-model="detalle._monto" type="number" step="0.01" class="form-control" placeholder="Monto" @change="calcularTotal($event)" />
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-6">
                                                <select x-model="detalle._sorteo_type" class='form-select' name="" id="">
                                                    <option value="null"> --Seleccione--</option>
                                                    <template x-for="(sorteo, index) in sorteos" :key="index">
                                                        <option :value="sorteo.id.toString()" x-text="sorteo.name"></option>
                                                    </template>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-2">
                                        <button class="btn btn-danger" style="width: 100%; height:100%;" @click="deleteItem(detalle)"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </div>
                            </template>

                            <div class="row mt-5">
                                <div class="d-grid gap-2">

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="ReglamentoYNormas" tabindex="-1" aria-labelledby="ReglamentoYNormasLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ReglamentoYNormasLabel">Reglamento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        1. El jugador debe seleccionar tres animalitos de los 38 disponibles en la ruleta <br>

                        2. La apuesta por cada 1 Bs. apostado ganas 50 Bs. <br>
                        3. La apuesta se realiza en cualquier momento del día antes del sorteo inmediatamente posterior a la hora de la apuesta, y es válida para los siguientes 11 sorteos. <br>
                        4. Los tres animalitos seleccionados deben ser resultado de los 11 sorteos posteriores al sorteo e inmediatamente posterior a la hora de la apuesta, sin importar si los sorteos pertenecen al mismo día o al día siguiente. <br>
                        5. Si los tres animalitos seleccionados son resultado de los 11 sorteos posteriores al sorteo inmediatamente posterior a la hora de la apuesta, la combinación de 3 animalitos resulta ganadora <br>

                        6. Si no se cumplen las condiciones anteriores, el jugador pierde la apuesta y no recibe ningún pago. <br>
                        7. Las Tripletas de (Lotto Activo y La Granjita cerraran sus jugadas 20 min antes del sorteo)
                        <!-- Es importante tener en cuenta que las reglas específicas de la apuesta pueden variar según el corredor de apuestas o el casino -->

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


        <div class="fixed-bottom">
            <div class="">
                <div class="row">
                    <div class="col-md-6 mt-1 offset-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mt-1">
                                    <div class="input-group mb-3" x-show="turn">
                                        <select class='form-select' name="" id="" x-model="ticket.moneda">
                                            <template x-for="(moneda, index) in monedas" :key="index">
                                                <option :value="moneda.id.toString()" x-text="`${moneda.simbolo} ${moneda.nombre}`"></option>
                                            </template>
                                        </select>
                                        <input x-model="total" readonly type="number" class="form-control" placeholder="Monto" aria-label="Monto" min="0.10">
                                    </div>
                                    <div class="d-grid gap-1 mt-1">
                                        <button class="btn btn-primary" @click="addItem()" type="button"><i class="fa-solid fa-plus"></i> Agregar Nueva Tripleta
                                        </button>
                                        <button x-bind:disabled="handleBtnSave" class="btn btn-success" data-bs-toggle="modal" @click="guardar()"><i class="fa-solid fa-floppy-disk"></i> Guardar <span x-text="_monedaSelected.simbolo"></span> <span x-text="total"></span></button>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a x-bind:href="'/tickets/create'" class="btn btn-primary"><i class="fa-solid fa-receipt"></i> Animalitos</a>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ReglamentoYNormas"><i class="fa-solid fa-bars"></i> Reglamento</button>
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
    </div>
</div>
<script type="text/javascript">
    function sorteos() {
        var monedas = @json($monedas);
        var sorteos = @json($sorteos);
        return {
            ticket: {
                moneda: "1",
                detalles: [{
                    _1ero: '',
                    _2do: '',
                    _3ero: '',
                    _monto: 0,
                    _sorteo_type: false,
                }],
                total: 0,
            },
            _monedaSelected: {},
            monto: '',
            total: 0,
            turn: true,
            numeros: '',
            monedas: monedas,
            sorteos: sorteos,
            handleBtnSave: false,
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
            validateItems: function() {
                isNull = this.ticket.detalles.find(e => e._sorteo_type == false);
                // console.log(isNull)
                // debugger
                if (isNull) {
                    this.toast(`Seleccione un sorteo valido`, 6000);
                    return false
                }
                if (this.total > 100) {
                    this.toast(`Limite Total debe ser Menor o Igual a 100`, 6000);
                    return false
                }
                empty1 = this.ticket.detalles.find(e => e._1ero == '');
                empty2 = this.ticket.detalles.find(e => e._2do == '');
                empty3 = this.ticket.detalles.find(e => e._3ero == '');

                monto = this.ticket.detalles.find(e => e._monto == '' || e._monto == 0 || e._monto < 0.5);

                if (empty1 == undefined && empty2 == undefined && empty3 == undefined && monto == undefined) {
                    return true
                } else {
                    this.toast(`Verifique un dato del la tripleta no puede estar vacio y el monto en ${this._monedaSelected.simbolo} no puede ser menor a  ${this._monedaSelected.simbolo} 0.50 `, 6000);
                    return false
                }

            },
            deleteItem: function(item) {
                this.ticket.detalles.splice(this.ticket.detalles.indexOf(item), 1);
                this.calcularTotal();
            },
            addItem: function() {
                if (!this.validateItems()) {
                    return false
                }

                let tripleta = {
                    _1ero: '',
                    _2do: '',
                    _3ero: '',
                    _monto: 0,
                    _sorteo_type: 1,
                }

                this.ticket.detalles.push(tripleta);
                this.calcularTotal()
            },
            calcularTotal: function($e = false) {
                console.log($e);
                if (!!this.ticket.detalles.length) {
                    this.total = this.ticket.detalles.reduce((a, b) => a + parseFloat(b._monto), 0)
                } else {
                    this.total = 0
                }
                this.ticket.total = this.total
            },
            validateNumber($e, i, m) {
                // console.log($e);
                number = $e.target.value.toString();
                // console.log(number);
                change = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];

                changeFund = change.find(e => e == number);

                if (!!changeFund) {
                    number = `0${changeFund}`;
                }

                permitido = ['0', '00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36'];

                fund = permitido.find(e => e == number);

                if (!fund) {
                    console.log('this')
                    this.toast('Escriba numeros validos entre el 0, 00, 01 ... 36', 5000)
                    return $e.target.value = null;
                } else {
                    this.ticket.detalles[i][m] = number;
                    return $e.target.value = number;
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
            guardar: async function() {
                if (!this.validateItems()) {
                    return false
                }
                this.handleBtnSave = true;
                let body = await fetch('/tripletas', {
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
                            window.open(`/tripletas/print/${res.code}?timezone=${timezone}`, "_blank");
                            location.reload();
                            return true
                        }


                        // if (this.impresion_type == 1) {
                        //     let win = window.open(`/print2/${res.code}?timezone=${timezone}`, "_blank", 'width=400, height=400');
                        //     let q = win.focus();
                        //     let w = win.print();


                        //     // win.close();
                        //     setTimeout(() => {
                        //         win.close();
                        //         location.reload();
                        //     }, 1200);

                        //     return true
                        // }

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
</script>

@endsection