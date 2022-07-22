@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Reportes</div>
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger mt-2" role="alert">
                        <span class="strong">{{$errors->first()}}</span>
                    </div>
                    @endif
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
                    const res = await fetch('/animals/' + id, {
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
    //         const res = await fetch('/animals/' + id, {
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