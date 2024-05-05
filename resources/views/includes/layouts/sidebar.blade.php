<div id="sidebar">
    <ul class="list-group">
        <li class="nav-item">
            <a class="px-lg-3 nav-link d-flex gap-2 align-items-center" href="{{ url('/admin') }}">
                <i class="fa-solid fa-tachometer-alt fa-lg fa-fw"></i><span class="d-none d-lg-inline ">Dashboard</span> 
            </a>
        </li>
        <li class="nav-item">
            <a @class([
                'px-lg-3',
    'nav-link',
    'd-flex',
    'gap-2',
    'align-items-center',
    'active' => Request::is('apartments*'),
]) href="{{ url('/apartments') }}">
                <i class="fa-solid fa-building fa-lg fa-fw"></i><span class="d-none d-lg-inline">Appartamenti</span> 
            </a>
        </li>
        <li class="nav-item">
            <a class="px-lg-3 nav-link d-flex  gap-2  align-items-center" href="{{ url('/messages') }}">
                <i class="fa-solid fa-message fa-lg fa-fw"></i><span class="d-none d-lg-inline">Messaggi</span> 
            </a>
        </li>
        <li class="nav-item">
            <a class="px-lg-3 gap-2 nav-link d-flex  align-items-center" href="{{url('/apartments/sponsored')}}">
                <i class="fa-solid fa-sack-dollar fa-lg fa-fw"></i><span class="d-none d-lg-inline">Sponsor</span> 
            </a>
        </li>
        <li class="nav-item">

            <a @class([
                'px-lg-3',
    'nav-link',
    'd-flex',
    'gap-2',
    'align-items-center',
    'active' => Request::is('profile*'),
]) href="{{ url('profile') }}">
                <i class="fa-solid fa-user fa-lg fa-fw"></i><span class="d-none d-lg-inline">Profilo</span> 
            </a>
        </li>
    </ul>
</div>
