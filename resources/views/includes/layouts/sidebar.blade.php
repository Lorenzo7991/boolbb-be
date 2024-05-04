<div id="sidebar">
    <ul class="list-group">
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between gap-5 align-items-center" href="{{ url('/admin') }}">
                <span class="d-none ">Dashboard</span> <i class="fa-solid fa-tachometer-alt fa-lg fa-fw"></i>
            </a>
        </li>
        <li class="nav-item">
            <a @class([
    'nav-link',
    'd-flex',
    'justify-content-between',
    'gap-5',
    'align-items-center',
    'active' => Request::is('apartments*'),
]) href="{{ url('/apartments') }}">
                <span class="d-none">Appartamenti</span> <i class="fa-solid fa-building fa-lg fa-fw"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between gap-5 align-items-center" href="{{ url('/messages') }}">
                <span class="d-none">Messaggi</span> <i class="fa-solid fa-message fa-lg fa-fw"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between gap-5 align-items-center" href="{{url('/apartments/sponsored')}}">
                <span class="d-none">Sponsor</span> <i class="fa-solid fa-sack-dollar fa-lg fa-fw"></i>
            </a>
        </li>
        <li class="nav-item">

            <a @class([
    'nav-link',
    'd-flex',
    'justify-content-between',
    'gap-5',
    'align-items-center',
    'active' => Request::is('profile*'),
]) href="{{ url('profile') }}">
                <span class="d-none">Profilo</span> <i class="fa-solid fa-user fa-lg fa-fw"></i>
            </a>
        </li>
    </ul>
</div>
