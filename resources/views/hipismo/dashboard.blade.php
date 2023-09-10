@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-end"> <a href="/hipismo/taquilla" class="btn btn-primary">Nuevo</a></div>
                <div class="card-body">
                    @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{!! \Session::get('success') !!}</li>
                        </ul>
                    </div>
                    @endif

                    @if (\Session::has('error'))
                    <div class="alert alert-danger">
                        <ul>
                            <li>{!! \Session::get('error') !!}</li>
                        </ul>
                    </div>
                    @endif

                    <div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Resumen de Remates</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">Total: {{$totals}}</h6>
                                <h6 class="card-subtitle mb-2 text-body-secondary">Banca: {{$banca}}</h6>
                                <h6 class="card-subtitle mb-2 text-body-secondary">Premios: {{$premios}}</h6>
                            </div>
                        </div>
                    </div>

                    <div class="table_responsive">
                        <table class="table">
                            <tr>
                                <td>Monto</td>
                                <td>Cliente</td>
                                <td></td>
                            </tr>
                            @foreach($remates as $remate)
                            <tr>
                                <td>
                                    Bs. {{$remate->monto}}
                                </td>
                                <td>
                                    {{$remate->cliente}}
                                </td>
                                <td></td>
                            </tr>
                            @endforeach
                        </table>
                    </div>

                    <div class="d-flex">
                        {!! $remates->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>

@endsection