<div id="sidebar">
    <ul class="list-group">
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between gap-5 align-items-center" href="{{ url('/admin') }}">
                <span>Dashboard</span> <i class="fa-solid fa-tachometer-alt fa-lg fa-fw"></i>
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
                <span>Appartamenti</span> <i class="fa-solid fa-building fa-lg fa-fw"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between gap-5 align-items-center" href="{{ url('/messages') }}">
                <span>Messaggi</span> <i class="fa-solid fa-message fa-lg fa-fw"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between gap-5 align-items-center" href="{{url('/apartments/sponsored')}}">
                <span>Sponsor</span> <i class="fa-solid fa-sack-dollar fa-lg fa-fw"></i>
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
                <span>Profilo</span> <i class="fa-solid fa-user fa-lg fa-fw"></i>
            </a>
        </li>
    </ul>
</div>
