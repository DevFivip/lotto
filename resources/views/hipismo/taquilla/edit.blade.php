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
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <button class="nav-link active">Remate Editar</button>
                        </li>
                    </ul>


                    <div class="row mt-2 shadow border" style="padding-bottom: 25vh;" x-show="!!remate.remateSelected" x-transition:enter.duration.500ms x-transition:leave.duration.50ms x-init="$watch('remate.remateHorses', value => calculeTotal(value))">
                        <div class="col-12 col-md-12">
                            <template x-for="(horse, index) in remate.remateHorses" :key="index">
                                <div class="row border-bottom pb-1">
                                    <!-- <pre x-text="JSON.stringify(horse)"></pre> -->
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
                                        <span><strong>Total:</strong> <span x-text="`Bs. ${(Math.round(remate.total * 100) / 100).toFixed(2)}`"></span> <strong> Premio:</strong><input type="number" step="0.01" x-model="remate.premio"></span>
                                    </div>

                                    <div class="d-grid gap-1 mt-1">
                                        <button class="btn btn-primary font-bold" @click="saveAndCreateNewRemate()" type="button"><i class="fa-solid fa-save"></i> Guardar
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

        let detalles = @json($detalles);
        let _remate = @json($remate);

        detalles = detalles.map((v) => {
            v.status = v.horse.status;
            v.horse_number = v.horse.horse_number;
            v.horse_name = v.horse.horse_name;
            v.jockey_name = v.horse.jockey_name;
            v.status_pago = !!v.status_pago == 1;
            return v;
        })

        return {
            remate: {
                remateSelected: true,
                remateHorses: detalles,
                remateEditSelected: false,
                listCodes: [],
                total: _remate.total,
                premio: _remate.pagado,
            },
            cancelar: function(){
                history.back();
            },

            saveAndCreateNewRemate: async function() {
                console.log(this.remate)
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
                        location.replace('/hipismo')
                    } else {
                        this.toast(res.message, 5000);
                    }
                }
            },
            validRemate: function() {
                if (this.remate.total < 1) {
                    this.toast(`Limite Total de ventas debe ser mayor a 1`, 6000);
                    return false
                }

                return true

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
</script>
@endsection