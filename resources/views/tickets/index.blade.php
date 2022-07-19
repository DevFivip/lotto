@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Clientes</div>
                <div class="card-body">
                    <a href="/tickets/create" class="btn btn-primary">Nuevo Ticket</a>
                    @if($errors->any())
                    <div class="alert alert-danger mt-2" role="alert">
                        <span class="strong">{{$errors->first()}}</span>
                    </div>
                    @endif
                    <table class="table">
                        <tr>
                            <td></td>
                            <td>Codigo</td>
                            <td>Vendedor</td>
                            <td>Total</td>
                            <td></td>
                        </tr>
                        @foreach($tickets as $tickts)
                        <tr>
                            <td>
                                @if($tickts->status === 1)
                                <span class="badge bg-warning text-dark">Activo</span>
                                @else
                                <span class="badge bg-danger">Anulado</span>
                                @endif
                            </td>

                            <td>{{$tickts->code}}</td>
                            <td>{{$tickts->user_id}}</td>
                            <td>{{$tickts->total}} {{$tickts->moneda_id}}</td>

                            <td>
                                <div x-data="listener()" class="btn-group">
                                    <a href="/{{$tickts->id}}/edit" class="btn btn-primary">Editar</a>
                                    @if($tickts->status === 1)
                                    <button @click="handleLock" id="{{$tickts->id}}" class="btn btn-danger">Bloquear</button>
                                    @else
                                    <button @click='eliminar("{{$tickts->id}}")' class="btn btn-warning">Desbloquear</button>
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
                if (confirm("¿Seguro deseas Bloquear?") == true) {
                    const res = await fetch('/tickets/' + id, {
                        method: 'DELETE',
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-Token": window.CSRF_TOKEN
                        },
                    })

                    alert()
                    location.reload()
                }
            }
        }
    }


    // window.CSRF_TOKEN = '{{ csrf_token() }}';
    // async function eliminar(id) {
    //     if (confirm("¿Seguro deseas Bloquear?") == true) {
    //         const res = await fetch('/tickets/' + id, {
    //             method: 'DELETE',
    //             headers: {
    //                 "Content-Type": "application/json",
    //                 "Accept": "application/json",
    //                 "X-Requested-With": "XMLHttpRequest",
    //                 "X-CSRF-Token": window.CSRF_TOKEN
    //             },
    //         })

    //         location.reload()
    //     }
    // }
</script>

@endsection