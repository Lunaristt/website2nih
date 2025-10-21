<!-- Navbar -->
<nav class="navbar navbar-expand-lg" style="background-color:#8b0d18;">
    <div class="container-fluid">
        <a class="navbar-brand text-white fw-bold" href="{{ route('home') }}">☰ Toko Sumber Rejeki</a>

        <div class="dropdown ms-auto">
            <button class="btn btn-outline-light dropdown-toggle fw-bold" type="button" id="userMenu"
                data-bs-toggle="dropdown" aria-expanded="false">
                {{ $authUser->Nama ?? 'Pengguna' }} 👤
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                @if(isset($authUser) && $authUser->Role === 'Admin')
                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                @endif
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger fw-semibold">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>