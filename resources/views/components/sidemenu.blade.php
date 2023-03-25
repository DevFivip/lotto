<div class="list-group" x-data="{openBingo:'{{strpos(Route::currentRouteName(),"bingo")}}',openAnimalitos:'{{ strpos(Route::currentRouteName(),"tickets")}}',openTripletas:'{{ strpos(Route::currentRouteName(),"tripletas")}}',openWallet:'{{ strpos(Route::currentRouteName(),"wallets")}}'}">
    <a href="/home" class="list-group-item list-group-item-action"> Inicio</a>
    @if(auth()->user()->role_id == 3 || auth()->user()->role_id == 1)

    <a href="#" class="list-group-item list-group-item-action" @click="openAnimalitos =! openAnimalitos">Animalitos</a>
    <template x-if="openAnimalitos">
        <span style="margin-left: 2vh;">
            <a href="/tickets/create" class="list-group-item list-group-item-action @if(Route::currentRouteName()=='tickets.create') active @endif"> <i class="fa-solid fa-arrow-right"></i> Nuevo</a>
            <a href="/tickets" class="list-group-item list-group-item-action @if(Route::currentRouteName()=='tickets.index') active @endif"> <i class="fa-solid fa-arrow-right"></i> Listado</a>
        </span>
    </template>
    <a href="#" class="list-group-item list-group-item-action" @click="openTripletas =! openTripletas"> Tripletas</a>
    <template x-if="openTripletas">
        <span style="margin-left: 2vh;">
            <a href="/tripletas/create" class="list-group-item list-group-item-action @if(Route::currentRouteName()=='tripletas.create') active @endif"> <i class="fa-solid fa-arrow-right"></i> Nuevo</a>
            <a href="/tripletas" class="list-group-item list-group-item-action @if(Route::currentRouteName()=='tripletas.index') active @endif"> <i class="fa-solid fa-arrow-right"></i> Listado</a>
        </span>
    </template>

    <!-- <a href="#" class="list-group-item list-group-item-action" @click="openBingo =! openBingo">Bingo</a>
    <template x-if="openBingo">
        <span style="margin-left: 2vh;">
            <a href="/bingo/create" class="list-group-item list-group-item-action @if(Route::currentRouteName()=='bingo.create') active  @endif"> <i class="fa-solid fa-arrow-right"></i> Nuevo</a>
            <a href="/bingo" class="list-group-item list-group-item-action @if(Route::currentRouteName()=='bingo.index') active @endif"> <i class="fa-solid fa-arrow-right"></i> Listado</a>
        </span>
    </template>

    <a href="#" class="list-group-item list-group-item-action" @click="openWallet =! openWallet"> <i class="fa-solid fa-wallet"></i> Wallet</a>
    <template x-if="openWallet">
        <span style="margin-left: 2vh;">
            <a href="/wallets" class="list-group-item list-group-item-action @if(Route::currentRouteName()=='wallets.index') active @endif"> <i class="fa-solid fa-arrow-right"></i> Movimientos</a>
            <a href="/wallets/create" class="list-group-item list-group-item-action @if(Route::currentRouteName()=='wallets.create') active  @endif"> <i class="fa-solid fa-arrow-right"></i> Transferencia</a>
            <a href="/wallets/transferencia-bingo-coin" class="list-group-item list-group-item-action @if(Route::currentRouteName()=='wallets.bCoin') active @endif"> <i class="fa-solid fa-arrow-right"></i> Trans. Bingo C.</a>
        </span>
    </template> -->

    @endif
    <!-- <a href="/tickets" class="list-group-item list-group-item-action">Tickets</a> -->
    @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
    <a href="/usuarios" class="list-group-item list-group-item-action">Usuarios</a>
    @endif
    <a href="/cajas" class="list-group-item list-group-item-action">Cajas</a>
    <!-- <a href="/caja-registers" class="list-group-item list-group-item-action">Cajas Register</a> -->
    @if(auth()->user()->role_id == 2)
    <a href="/cash-admins/{{auth()->user()->id}}" class="list-group-item list-group-item-action">Caja Administrativa</a>
    @endif
    @if(auth()->user()->id == 16)
    <a href="/animals" class="list-group-item list-group-item-action">Animales</a>
    @endif
    @if(auth()->user()->role_id == 1)

    <a href="/cash-admins" class="list-group-item list-group-item-action">Cajas Administrativas</a>
    <a href="/customers" class="list-group-item list-group-item-action">Clientes</a>
    <a href="/animals" class="list-group-item list-group-item-action">Animales</a>
    <a href="/payments" class="list-group-item list-group-item-action">Metodos de Pago</a>
    <a href="/schedules" class="list-group-item list-group-item-action">Horarios</a>
    <a href="/sorteos" class="list-group-item list-group-item-action">Sorteos</a>
    <a href="/lottoloko" class="list-group-item list-group-item-action">⭐Lotto Plus</a>
    <a href="/choose" class="list-group-item list-group-item-action">📈 Actividad</a>

    @endif

    <a href="/resultados" class="list-group-item list-group-item-action ">Resultados</a>
    <a href="/reports" class="list-group-item list-group-item-action">Reportes</a>
    <a href="/setting-impresora" class="list-group-item list-group-item-action">Configurar Impresora</a>




</div>