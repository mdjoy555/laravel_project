<nav class="sb-topnav navbar navbar-expand navbar-white bg-white">
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i>
            {{auth()->user()->name}}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="dropdown-item" onclick="event.preventDefault();this.closest('form').submit();">Logout</a>
                </form>
            </ul>
        </li>
    </ul>
</nav>
