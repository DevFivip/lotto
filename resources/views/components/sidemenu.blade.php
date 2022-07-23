<div class="list-group">
    <a href="/home" class="list-group-item list-group-item-action">Inicio</a>
    @if(auth()->user()->role_id == 3 || auth()->user()->role_id == 1)
    <a href="/tickets/create" class="list-group-item list-group-item-action">Taquilla</a>
    @endif
    <a href="/tickets" class="list-group-item list-group-item-action">Tickets</a>
    @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
    <a href="/usuarios" class="list-group-item list-group-item-action">Usuarios</a>
    @endif
    <a href="/cajas" class="list-group-item list-group-item-action">Cajas</a>
    @if(auth()->user()->role_id == 1)
    <a href="/customers" class="list-group-item list-group-item-action">Clientes</a>
    <a href="/animals" class="list-group-item list-group-item-action">Animales</a>
    <a href="/payments" class="list-group-item list-group-item-action">Metodos de Pago</a>
    <a href="/schedules" class="list-group-item list-group-item-action">Horarios</a>
    <a href="/resultados" class="list-group-item list-group-item-action">Resultados</a>
    @endif
    <a href="/reports" class="list-group-item list-group-item-action">Reportes</a>
</div>