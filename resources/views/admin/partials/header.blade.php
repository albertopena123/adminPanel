<div class="navbar-header">
    <div class="row align-items-center justify-content-between">
        <div class="col-auto">
            <div class="d-flex flex-wrap align-items-center gap-4">
                <button type="button" class="sidebar-toggle">
                    <iconify-icon icon="heroicons:bars-3-solid" class="icon text-2xl non-active"></iconify-icon>
                    <iconify-icon icon="iconoir:arrow-right" class="icon text-2xl active"></iconify-icon>
                </button>
                <button type="button" class="sidebar-mobile-toggle">
                    <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
                </button>
                <form class="navbar-search">
                    <input type="text" name="search" placeholder="Buscar">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>
            </div>
        </div>
        <div class="col-auto">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <button type="button" data-theme-toggle
                    class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"></button>

                <!-- Solo si es administrador ve el botón de notificaciones -->
                @if (Auth::user()->hasRole('admin'))
                    <div class="dropdown">
                        <button
                            class="has-indicator w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"
                            type="button" data-bs-toggle="dropdown">
                            <iconify-icon icon="iconoir:bell" class="text-primary-light text-xl"></iconify-icon>
                        </button>
                        <div class="dropdown-menu to-top dropdown-menu-lg p-0">
                            <div
                                class="m-16 py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                                <div>
                                    <h6 class="text-lg text-primary-light fw-semibold mb-0">Notificaciones</h6>
                                </div>
                                <span
                                    class="text-primary-600 fw-semibold text-lg w-40-px h-40-px rounded-circle bg-base d-flex justify-content-center align-items-center">05</span>
                            </div>

                            <div class="max-h-400-px overflow-y-auto scroll-sm pe-4">
                                <a href="javascript:void(0)"
                                    class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between">
                                    <div
                                        class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3">
                                        <span
                                            class="w-44-px h-44-px bg-success-subtle text-success-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
                                            <iconify-icon icon="bitcoin-icons:verify-outline"
                                                class="icon text-xxl"></iconify-icon>
                                        </span>
                                        <div>
                                            <h6 class="text-md fw-semibold mb-4">Nuevo usuario registrado</h6>
                                            <p class="mb-0 text-sm text-secondary-light text-w-200-px">Un nuevo usuario
                                                se ha registrado en el sistema</p>
                                        </div>
                                    </div>
                                    <span class="text-sm text-secondary-light flex-shrink-0">23 Mins</span>
                                </a>
                                <!-- Más notificaciones -->
                            </div>

                            <div class="text-center py-12 px-16">
                                <a href="javascript:void(0)" class="text-primary-600 fw-semibold text-md">Ver todas</a>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="dropdown">
                    <button class="d-flex justify-content-center align-items-center rounded-circle" type="button"
                        data-bs-toggle="dropdown">
                        @if (isset(Auth::user()->profile_image) && Auth::user()->profile_image)
                            <img src="{{ asset(Auth::user()->profile_image) }}" alt="{{ Auth::user()->name }}"
                                class="w-40-px h-40-px object-fit-cover rounded-circle">
                        @else
                            <div
                                class="w-40-px h-40-px rounded-circle bg-primary-600 d-flex justify-content-center align-items-center text-white fw-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </button>
                    <div class="dropdown-menu to-top dropdown-menu-sm">
                        <div
                            class="py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                            <div>
                                <h6 class="text-lg text-primary-light fw-semibold mb-2">{{ Auth::user()->name }}</h6>
                                <span class="text-secondary-light fw-medium text-sm">
                                    @foreach (Auth::user()->roles as $role)
                                        {{ $role->name }}{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                </span>
                            </div>
                            <button type="button" class="hover-text-danger">
                                <iconify-icon icon="radix-icons:cross-1" class="icon text-xl"></iconify-icon>
                            </button>
                        </div>
                        <ul class="to-top-list">
                            <li>
                                <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"
                                    href="{{ route('profile') }}">
                                    <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon> Mi
                                    Perfil</a>
                            </li>

                            @if (Auth::user()->hasRole('admin'))
                                <li>
                                    <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"
                                        href="{{ route('admin.dashboard') }}">
                                        <iconify-icon icon="icon-park-outline:setting-two"
                                            class="icon text-xl"></iconify-icon> Admin Panel</a>
                                </li>
                            @endif

                            <li>
                                <form id="logout-form-header" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                                <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-danger d-flex align-items-center gap-3"
                                    href="javascript:void(0)"
                                    onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();">
                                    <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon> Cerrar
                                    Sesión</a>
                            </li>
                        </ul>
                    </div>
                </div><!-- Profile dropdown end -->
            </div>
        </div>
    </div>
</div>
