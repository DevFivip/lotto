@extends('layouts.app')

@section('content')
<div class="container" x-data="mounted()" x-init="$watch('ticket', value => groupCheck(value))">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Repetir Ticket</div>
                <div class="card-body">
                    <div class="row row-cols-1">
                        <ul class="list-group list-group-flush" x-data="converter('{{$ticket->created_at}}')">
                            <li class="list-group-item fw-bold">Ticket: <span class="font-monospace"><span x-text="ticket.code"></span></span></li>
                            <li class="list-group-item fw-bold">Fecha y Hora: <span class="font-monospace" x-text="fecha_inicial"></span></li>
                            <li class="list-group-item fw-bold">Monto: <span class="font-monospace">
                                    <span x-text="ticket.moneda.currency"></span>
                                    <span x-text="ticket.moneda.simbolo"></span>
                                    <span x-text="ticket.total.toFixed(2)"></span>
                            </li>
                        </ul>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary fw-bold" @click="guardar()">💾 Guardar</button>
                    </div>

                    <div class="row mt-3" x-data="groupCheck()">
                        <div class="col-md-12">
                            <div class="card mb-5" style="display:none" x-show="visibles[0].st">
                                <div class="card-body">
                                    <div class="card-title fw-bold">9 AM</div>
                                    <templete x-data="{changeTo00:0}">
                                        <select name="" id="" class="form-select" x-model="changeTo00" @change="changeSchedule(1,changeTo00)">
                                            <option value="0">--CAMBIAR HORARIO--</option>
                                            @foreach($schedules as $horario)
                                            <option value="{{$horario->id}}">{{$horario->schedule}}</option>
                                            @endforeach
                                        </select>
                                        <table class="table">
                                            <tr>
                                                <td class="text-center fw-bold"># Animalito</td>
                                                <td class="text-center fw-bold">Sorteo Hora</td>
                                                <td class="text-center fw-bold">Monto</td>
                                                <td class="text-center fw-bold">Premio</td>
                                                <td class="text-center fw-bold">Pago</td>
                                            </tr>

                                            <template x-for="items in ticket.detalles">
                                                <template x-if="items.schedule.id == 1">
                                                    <tr>
                                                        <td class="font-monospace text-center"><span x-text="items.animal.number"></span> <span x-text="items.animal.nombre"></span></td>
                                                        <td class="font-monospace text-center"><span x-text="items.schedule.schedule"></span></td>
                                                        <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span> <span x-text="items.monto"></span></td>
                                                        <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span></td>
                                                        <td class=""> <button class="btn btn-light text-danger" @click="deleteItem(items)"><i class="fa-solid fa-trash-can"></i></button></td>
                                                    </tr>
                                                </template>
                                            </template>
                                        </table>
                                </div>
                            </div>


                            <div class="card mb-5" style="display:none" x-show="visibles[1].st">
                                <div class="card-body">
                                    <div class="card-title fw-bold">10 PM</div>
                                    <templete x-data="{changeTo01:0}">
                                        <select name="" id="" class="form-select" x-model="changeTo01" @change="changeSchedule(1,changeTo01)">
                                            <option value="0">--CAMBIAR HORARIO--</option>
                                            @foreach($schedules as $horario)
                                            <option value="{{$horario->id}}">{{$horario->schedule}}</option>
                                            @endforeach
                                        </select>
                                        <table class="table">
                                            <tr>
                                                <td class="text-center fw-bold"># Animalito</td>
                                                <td class="text-center fw-bold">Sorteo Hora</td>
                                                <td class="text-center fw-bold">Monto</td>
                                                <td class="text-center fw-bold">Premio</td>
                                                <td class="text-center fw-bold">Pago</td>
                                            </tr>

                                            <template x-for="items in ticket.detalles">
                                                <template x-if="items.schedule.id == 2">
                                                    <tr>
                                                        <td class="font-monospace text-center"><span x-text="items.animal.number"></span> <span x-text="items.animal.nombre"></span></td>
                                                        <td class="font-monospace text-center"><span x-text="items.schedule.schedule"></span></td>
                                                        <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span> <span x-text="items.monto"></span></td>
                                                        <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span></td>
                                                        <td class=""> <button class="btn btn-light text-danger" @click="deleteItem(items)"><i class="fa-solid fa-trash-can"></i></button></td>
                                                    </tr>
                                                </template>
                                            </template>
                                        </table>
                                </div>
                            </div>


                            <div class="card mb-5" style="display:none" x-show="visibles[2].st">
                                <div class="card-body">
                                    <div class="card-title fw-bold">11 AM</div>
                                    <templete x-data="{changeTo03:0}">
                                        <select name="" id="" class="form-select" x-model="changeTo03" @change="changeSchedule(2,changeTo03)">
                                            <option value="0">--CAMBIAR HORARIO--</option>
                                            @foreach($schedules as $horario)
                                            <option value="{{$horario->id}}">{{$horario->schedule}}</option>
                                            @endforeach
                                        </select>
                                        <table class="table">
                                            <tr>
                                                <td class="text-center fw-bold"># Animalito</td>
                                                <td class="text-center fw-bold">Sorteo Hora</td>
                                                <td class="text-center fw-bold">Monto</td>
                                                <td class="text-center fw-bold">Premio</td>
                                                <td class="text-center fw-bold">Pago</td>
                                            </tr>

                                            <template x-for="items in ticket.detalles">
                                                <template x-if="items.schedule.id == 3">
                                                    <tr>
                                                        <td class="font-monospace text-center"><span x-text="items.animal.number"></span> <span x-text="items.animal.nombre"></span></td>
                                                        <td class="font-monospace text-center"><span x-text="items.schedule.schedule"></span></td>
                                                        <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span> <span x-text="items.monto"></span></td>
                                                        <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span></td>
                                                        <td class=""> <button class="btn btn-light text-danger" @click="deleteItem(items)"><i class="fa-solid fa-trash-can"></i></button></td>
                                                    </tr>
                                                </template>
                                            </template>
                                        </table>
                                </div>
                            </div>


                            <div class="card mb-5" style="display:none" x-show="visibles[3].st">
                                <div class="card-body">
                                    <div class="card-title fw-bold">12 PM</div>
                                    <templete x-data="{changeTo03:0}">
                                        <select name="" id="" class="form-select" x-model="changeTo03" @change="changeSchedule(4,changeTo03)">
                                            <option value="0">--CAMBIAR HORARIO--</option>
                                            @foreach($schedules as $horario)
                                            <option value="{{$horario->id}}">{{$horario->schedule}}</option>
                                            @endforeach
                                        </select>
                                        <table class="table">
                                            <tr>
                                                <td class="text-center fw-bold"># Animalito</td>
                                                <td class="text-center fw-bold">Sorteo Hora</td>
                                                <td class="text-center fw-bold">Monto</td>
                                                <td class="text-center fw-bold">Premio</td>
                                                <td class="text-center fw-bold">Pago</td>
                                            </tr>

                                            <template x-for="items in ticket.detalles">
                                                <template x-if="items.schedule.id == 4">
                                                    <tr>
                                                        <td class="font-monospace text-center"><span x-text="items.animal.number"></span> <span x-text="items.animal.nombre"></span></td>
                                                        <td class="font-monospace text-center"><span x-text="items.schedule.schedule"></span></td>
                                                        <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span> <span x-text="items.monto"></span></td>
                                                        <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span></td>
                                                        <td class=""> <button class="btn btn-light text-danger" @click="deleteItem(items)"><i class="fa-solid fa-trash-can"></i></button></td>
                                                    </tr>
                                                </template>
                                            </template>
                                        </table>
                                </div>
                            </div>


                            <div class="card mb-5" style="display:none" x-show="visibles[4].st">
                                <div class="card-body">
                                    <div class="card-title fw-bold">01 PM</div>
                                    <templete x-data="{changeTo04:0}">
                                        <select name="" id="" class="form-select" x-model="changeTo04" @change="changeSchedule(5,changeTo04)">
                                            <option value="0">--CAMBIAR HORARIO--</option>
                                            @foreach($schedules as $horario)
                                            <option value="{{$horario->id}}">{{$horario->schedule}}</option>
                                            @endforeach
                                        </select>
                                        <table class="table">
                                            <tr>
                                                <td class="text-center fw-bold"># Animalito</td>
                                                <td class="text-center fw-bold">Sorteo Hora</td>
                                                <td class="text-center fw-bold">Monto</td>
                                                <td class="text-center fw-bold">Premio</td>
                                                <td class="text-center fw-bold">Pago</td>
                                            </tr>

                                            <template x-for="items in ticket.detalles">
                                                <template x-if="items.schedule.id == 5">
                                                    <tr>
                                                        <td class="font-monospace text-center"><span x-text="items.animal.number"></span> <span x-text="items.animal.nombre"></span></td>
                                                        <td class="font-monospace text-center"><span x-text="items.schedule.schedule"></span></td>
                                                        <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span> <span x-text="items.monto"></span></td>
                                                        <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span></td>
                                                        <td class=""> <button class="btn btn-light text-danger" @click="deleteItem(items)"><i class="fa-solid fa-trash-can"></i></button></td>
                                                    </tr>
                                                </template>
                                            </template>
                                        </table>
                                </div>
                            </div>


                            <div class="card mb-5" style="display:none" x-show="visibles[5].st">
                                <div class="card-body">
                                    <div class="card-title fw-bold">02 PM</div>
                                    <templete x-data="{changeTo05:0}">
                                        <select name="" id="" class="form-select" x-model="changeTo05" @change="changeSchedule(6,changeTo05)">
                                            <option value="0">--CAMBIAR HORARIO--</option>
                                            @foreach($schedules as $horario)
                                            <option value="{{$horario->id}}">{{$horario->schedule}}</option>
                                            @endforeach
                                        </select>
                                        <table class="table">
                                            <tr>
                                                <td class="text-center fw-bold"># Animalito</td>
                                                <td class="text-center fw-bold">Sorteo Hora</td>
                                                <td class="text-center fw-bold">Monto</td>
                                                <td class="text-center fw-bold">Premio</td>
                                                <td class="text-center fw-bold">Pago</td>
                                            </tr>

                                            <template x-for="items in ticket.detalles">
                                                <template x-if="items.schedule.id == 6">
                                                    <tr>
                                                        <td class="font-monospace text-center"><span x-text="items.animal.number"></span> <span x-text="items.animal.nombre"></span></td>
                                                        <td class="font-monospace text-center"><span x-text="items.schedule.schedule"></span></td>
                                                        <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span> <span x-text="items.monto"></span></td>
                                                        <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span></td>
                                                        <td class=""> <button class="btn btn-light text-danger" @click="deleteItem(items)"><i class="fa-solid fa-trash-can"></i></button></td>
                                                    </tr>
                                                </template>
                                            </template>
                                        </table>
                                </div>
                            </div>


                            <div class="card mb-5" style="display:none" x-show="visibles[6].st">
                                <div class="card-body">
                                    <div class="card-title fw-bold">03 PM</div>
                                    <templete x-data="{changeTo06:0}">
                                        <select name="" id="" class="form-select" x-model="changeTo06" @change="changeSchedule(7,changeTo06)">
                                            <option value="0">--CAMBIAR HORARIO--</option>
                                            @foreach($schedules as $horario)
                                            <option value="{{$horario->id}}">{{$horario->schedule}}</option>
                                            @endforeach
                                        </select>
                                        <table class="table">
                                            <tr>
                                                <td class="text-center fw-bold"># Animalito</td>
                                                <td class="text-center fw-bold">Sorteo Hora</td>
                                                <td class="text-center fw-bold">Monto</td>
                                                <td class="text-center fw-bold">Premio</td>
                                                <td class="text-center fw-bold">Pago</td>
                                            </tr>

                                            <template x-for="items in ticket.detalles">
                                                <template x-if="items.schedule.id == 7">
                                                    <tr>
                                                        <td class="font-monospace text-center"><span x-text="items.animal.number"></span> <span x-text="items.animal.nombre"></span></td>
                                                        <td class="font-monospace text-center"><span x-text="items.schedule.schedule"></span></td>
                                                        <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span> <span x-text="items.monto"></span></td>
                                                        <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span></td>
                                                        <td class=""> <button class="btn btn-light text-danger" @click="deleteItem(items)"><i class="fa-solid fa-trash-can"></i></button></td>
                                                    </tr>
                                                </template>
                                            </template>
                                        </table>
                                </div>
                            </div>


                            <div class="card mb-5" style="display:none" x-show="visibles[7].st">
                                <div class="card-body">
                                    <div class="card-title fw-bold">04 PM</div>
                                    <templete x-data="{changeTo07:0}">
                                        <select name="" id="" class="form-select" x-model="changeTo07" @change="changeSchedule(8,changeTo07)">
                                            <option value="0">--CAMBIAR HORARIO--</option>
                                            @foreach($schedules as $horario)
                                            <option value="{{$horario->id}}">{{$horario->schedule}}</option>
                                            @endforeach
                                        </select>
                                        <table class="table">
                                            <tr>
                                                <td class="text-center fw-bold"># Animalito</td>
                                                <td class="text-center fw-bold">Sorteo Hora</td>
                                                <td class="text-center fw-bold">Monto</td>
                                                <td class="text-center fw-bold">Premio</td>
                                                <td class="text-center fw-bold">Pago</td>
                                            </tr>

                                            <template x-for="items in ticket.detalles">
                                                <template x-if="items.schedule.id == 8">
                                                    <tr>
                                                        <td class="font-monospace text-center"><span x-text="items.animal.number"></span> <span x-text="items.animal.nombre"></span></td>
                                                        <td class="font-monospace text-center"><span x-text="items.schedule.schedule"></span></td>
                                                        <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span> <span x-text="items.monto"></span></td>
                                                        <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span></td>
                                                        <td class=""> <button class="btn btn-light text-danger" @click="deleteItem(items)"><i class="fa-solid fa-trash-can"></i></button></td>
                                                    </tr>
                                                </template>
                                            </template>
                                        </table>
                                </div>
                            </div>


                            <div class="card mb-5" style="display:none" x-show="visibles[8].st">
                                <div class="card-body">
                                    <div class="card-title fw-bold">05 PM</div>
                                    <templete x-data="{changeTo08:0}">
                                        <select name="" id="" class="form-select" x-model="changeTo08" @change="changeSchedule(9,changeTo08)">
                                            <option value="0">--CAMBIAR HORARIO--</option>
                                            @foreach($schedules as $horario)
                                            <option value="{{$horario->id}}">{{$horario->schedule}}</option>
                                            @endforeach
                                        </select>
                                        <table class="table">
                                            <tr>
                                                <td class="text-center fw-bold"># Animalito</td>
                                                <td class="text-center fw-bold">Sorteo Hora</td>
                                                <td class="text-center fw-bold">Monto</td>
                                                <td class="text-center fw-bold">Premio</td>
                                                <td class="text-center fw-bold">Pago</td>
                                            </tr>

                                            <template x-for="items in ticket.detalles">
                                                <template x-if="items.schedule.id == 9">
                                                    <tr>
                                                        <td class="font-monospace text-center"><span x-text="items.animal.number"></span> <span x-text="items.animal.nombre"></span></td>
                                                        <td class="font-monospace text-center"><span x-text="items.schedule.schedule"></span></td>
                                                        <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span> <span x-text="items.monto"></span></td>
                                                        <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span></td>
                                                        <td class=""> <button class="btn btn-light text-danger" @click="deleteItem(items)"><i class="fa-solid fa-trash-can"></i></button></td>
                                                    </tr>
                                                </template>
                                            </template>
                                        </table>
                                </div>
                            </div>


                            <div class="card mb-5" style="display:none" x-show="visibles[9].st">
                                <div class="card-body">
                                    <div class="card-title fw-bold">06 PM</div>
                                    <templete x-data="{changeTo9:0}">
                                        <select name="" id="9" x-model="changeTo9" class="form-select" @change="changeSchedule(10,changeTo9)">
                                            <option value="0">--CAMBIAR HORARIO--</option>
                                            @foreach($schedules as $horario)
                                            <option value="{{$horario->id}}">{{$horario->schedule}}</option>
                                            @endforeach
                                        </select>
                                    </templete>
                                    <table class="table">
                                        <tr>
                                            <td class="text-center fw-bold"># Animalito</td>
                                            <td class="text-center fw-bold">Sorteo Hora</td>
                                            <td class="text-center fw-bold">Monto</td>
                                            <td class="text-center fw-bold">Premio</td>
                                            <td class="text-center fw-bold">Pago</td>
                                        </tr>

                                        <template x-for="items in ticket.detalles">
                                            <template x-if="items.schedule.id == 10">
                                                <tr>
                                                    <td class="font-monospace text-center"><span x-text="items.animal.number"></span> <span x-text="items.animal.nombre"></span></td>
                                                    <td class="font-monospace text-center"><span x-text="items.schedule.schedule"></span></td>
                                                    <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span> <span x-text="items.monto"></span></td>
                                                    <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span></td>
                                                    <td class=""> <button class="btn btn-light text-danger" @click="deleteItem(items)"><i class="fa-solid fa-trash-can"></i></button></td>
                                                </tr>
                                            </template>
                                        </template>
                                    </table>
                                </div>
                            </div>


                            <div class="card mb-5" style="display:none" x-show="visibles[10].st">
                                <div class="card-body">
                                    <div class="card-title fw-bold">07 PM</div>
                                    <templete x-data="{changeTo10:0}">
                                        <select name="" id="" class="form-select" x-model="changeTo10" @change="changeSchedule(11,changeTo10)">
                                            <option value="0">--CAMBIAR HORARIO--</option>
                                            @foreach($schedules as $horario)
                                            <option value="{{$horario->id}}">{{$horario->schedule}}</option>
                                            @endforeach
                                        </select>
                                    </templete>
                                    <table class="table">
                                        <tr>
                                            <td class="text-center fw-bold"># Animalito</td>
                                            <td class="text-center fw-bold">Sorteo Hora</td>
                                            <td class="text-center fw-bold">Monto</td>
                                            <td class="text-center fw-bold">Premio</td>
                                            <td class="text-center fw-bold">Pago</td>
                                        </tr>

                                        <template x-for="items in ticket.detalles">
                                            <template x-if="items.schedule.id == 11">
                                                <tr>
                                                    <td class="font-monospace text-center"><span x-text="items.animal.number"></span> <span x-text="items.animal.nombre"></span></td>
                                                    <td class="font-monospace text-center"><span x-text="items.schedule.schedule"></span></td>
                                                    <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span> <span x-text="items.monto"></span></td>
                                                    <td class="font-monospace text-end"><span x-text="ticket.moneda.simbolo"></span></td>
                                                    <td class=""> <button class="btn btn-light text-danger" @click="deleteItem(items)"><i class="fa-solid fa-trash-can"></i></button></td>
                                                </tr>
                                            </template>
                                        </template>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary fw-bold" @click="guardar()">💾 Guardar</button>
                    </div>
                    <div class="row row-cols-1">
                        <ul class="list-group list-group-flush" x-data="converter('{{$ticket->created_at}}')">
                            <li class="list-group-item fw-bold">Ticket: <span class="font-monospace"><span x-text="ticket.code"></span></span></li>
                            <li class="list-group-item fw-bold">Fecha y Hora: <span class="font-monospace" x-text="fecha_inicial"></span></li>
                            <li class="list-group-item fw-bold">Monto: <span class="font-monospace">
                                    <span x-text="ticket.moneda.currency"></span>
                                    <span x-text="ticket.moneda.simbolo"></span>
                                    <span x-text="ticket.total.toFixed(2)"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function mounted() {
        window.CSRF_TOKEN = '{{ csrf_token() }}';
        let tick = @json($ticket);
        let det = @json($detalles);
        let schedules = @json($schedules);
        // console.log(det)
        let _detalles = det.map((v) => {
            return {
                id: v.animal_id,
                schedule_id: v.schedule_id,
                schedule: v.schedule,
                monto: v.monto,
                admin_id: v.admin_id,
                user_id: v.user_id,
                caja_id: v.caja_id,
                animal: v.animal,
                sorteo_type_id: v.sorteo_type_id,
                moneda: tick.moneda

            }
        })
        return {
            ticket: {
                // type_sorteo_id: !!!localStorage.getItem('sorteo') ? 1 : localStorage.getItem('sorteo'),
                ...tick,
                moneda: tick.moneda.id,
                detalles: _detalles,
            },
            visibles: [{
                    id: 1,
                    st: false
                },
                {
                    id: 2,
                    st: false
                },
                {
                    id: 3,
                    st: false
                },
                {
                    id: 4,
                    st: false
                },
                {
                    id: 5,
                    st: false
                },
                {
                    id: 6,
                    st: false
                },
                {
                    id: 7,
                    st: false
                },
                {
                    id: 8,
                    st: false
                },
                {
                    id: 9,
                    st: false
                },
                {
                    id: 10,
                    st: false
                },
                {
                    id: 11,
                    st: false
                },
            ],


            groupCheck: function(val) {
                const groupByCategory = this.ticket.detalles.reduce((group, item) => {
                    const {
                        schedule
                    } = item;
                    group[schedule.id] = group[schedule.id] ?? [];
                    group[schedule.id].push(item.id);
                    return group;
                }, {});

                const arry = Object.keys(groupByCategory);

                this.visibles = this.visibles.map((v, k) => {
                    res = arry.find(e => e == v.id)
                    console.log({
                        res
                    })
                    if (!!res) {
                        v.st = true;
                        return v
                    } else {
                        v.st = false;
                        return v
                    }
                })
            },
            deleteItem: function(item) {
                this.ticket.detalles.splice(this.ticket.detalles.indexOf(item), 1);
                this.calcularTotal();
            },

            calcularTotal: function() {
                if (!!this.ticket.detalles.length) {
                    this.total = this.ticket.detalles.reduce((a, b) => a + parseFloat(b.monto), 0)
                } else {
                    this.total = 0
                }
                this.ticket.total = this.total
            },
            changeSchedule: function(from, to) {

                if (to != 0) {


                    _new_schedule = schedules.find((v) => v.id === parseInt(to));

                    console.log({
                        _new_schedule
                    });



                    this.ticket.detalles = this.ticket.detalles.map((v, k) => {
                        if (v.schedule.id === from) {
                            v.schedule = _new_schedule;
                            v.schedule_id = _new_schedule.id
                        }

                        return v

                    })

                }

                console.log(from, to);
            },
            guardar: async function() {
                this.handleBtnSave = true;
                let body = await fetch('/ticket-register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.CSRF_TOKEN
                    },
                    body: JSON.stringify(this.ticket)
                })
                res = await body.json()
                timezone = Intl.DateTimeFormat().resolvedOptions().timeZone
                if (res.valid) {
                    if (localStorage.getItem('printer') && localStorage.getItem('printer_url')) {
                        const st = await this.printDirect(localStorage.getItem('printer'), localStorage.getItem('printer_url'), res.ticket, res.ticket_detalles, localStorage.getItem('paper_width'))
                        console.log({
                            st
                        })
                        this.toast('Imprimiendo...', 5000)
                        location.reload();
                    } else {
                        window.open(
                            `/print/${res.code}?timezone=${timezone}`, "_blank");
                        location.reload();
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