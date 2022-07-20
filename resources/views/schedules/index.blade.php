@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
 </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Horarios</div>
                <div class="card-body">
                    <p class="text-small form-text ml-3">&nbsp;&nbsp;<i class="fa-solid fa-circle-exclamation"></i>&nbsp;Agregar ó Eliminar Horarios directamente desde la base de datos</p>
                    @if($errors->any())
                    <div class="alert alert-danger mt-2" role="alert">
                        <span class="strong">{{$errors->first()}}</span>
                    </div>
                    @endif
                    <table class="table">
                        <tr>
                            <td>Estado</td>
                            <td>Horario Nombre</td>
                            <td>Hora Inicio Hora Local / Hora UTC</td>
                            <td>Hora Fin Hora Local / Hora UTC</td>
                            <td></td>
                        </tr>
                        @foreach($schedules as $schedule)
                        <tr x-data="converter('{{$schedule->interval_start_utc}}','{{$schedule->interval_end_utc}}')">
                            <td>
                                @if($schedule->status == 1)
                                <span class="badge bg-warning text-dark">Activo</span>
                                @else
                                <span class="badge bg-danger">Desactivado</span>
                                @endif
                            </td>
                            <td>{{$schedule->schedule}}</td>
                            <td> <span class="fw-bold" x-text="fecha_inicial"></span> <br> <span class="form-text">{{$schedule->interval_start_utc}}</span></td>
                            <td> <span class="fw-bold" x-text="fecha_cierre"></span> <br> <span class="form-text">{{$schedule->interval_end_utc}}</span></td>
                            <td>
                                <div x-data="listener()" class="btn-group">
                                    <!-- <a href="/{{$resource}}/{{$schedule->id}}/edit" class="btn btn-primary">Editar</a> -->
                                    @if($schedule->status == 1)
                                    <button @click="handleLock" id="{{$schedule->id}}" class="btn btn-danger">Desactivar</button>
                                    @else
                                    <button @click='handleLock' id="{{$schedule->id}}" class="btn btn-warning">Activar</button>
                                    @endif

                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function listener() {
        window.CSRF_TOKEN = '{{ csrf_token() }}';
        return {
            handleLock: async function(e) {
                id = e.target.id
                if (confirm("¿Seguro deseas desactivar este horarios?") == true) {
                    const res = await fetch('/schedules/' + id, {
                        method: 'DELETE',
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-Token": window.CSRF_TOKEN
                        },
                    })

                    location.reload()
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