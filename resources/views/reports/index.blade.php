@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Reportes
                </div>
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger mt-2" role="alert">
                        <span class="strong">{{$errors->first()}}</span>
                    </div>
                    @endif
                    <div class="row row-cols-3">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="text-center">Reporte General</h3>
                                    <div class="d-grid gap-1 mt-1">
                                        <a href="/reports/general" class="btn btn-primary"><i class="fa-solid fa-file-lines"></i></a>
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

<script>
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