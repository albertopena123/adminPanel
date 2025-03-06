<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="index.html" class="sidebar-logo">
            <img src="assets/images/logo.png" alt="site logo" class="light-logo">
            <img src="assets/images/logo-light.png" alt="site logo" class="dark-logo">
            <img src="assets/images/logo-icon.png" alt="site logo" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('dashboard') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            Dashboard Principal</a>
                    </li>
                    @if (Auth::user()->hasRole('admin'))
                        <li>
                            <a href="{{ route('admin.dashboard') }}"><i
                                    class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                                Panel de Administración</a>
                        </li>
                    @endif
                </ul>
            </li>

            <li class="sidebar-menu-group-title">Módulos</li>

            @if (Auth::user()->hasPermission('view-users'))
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                        <span>Usuarios</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('admin.users.index') }}"><i
                                    class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                                Lista de Usuarios</a>
                        </li>
                        @if (Auth::user()->hasPermission('create-users'))
                            <li>
                                <a href="{{ route('users.create') }}"><i
                                        class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                                    Añadir Usuario</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (Auth::user()->hasRole('admin'))
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <i class="ri-user-settings-line"></i>
                        <span>Roles y Permisos</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="#"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                                Gestión de Roles</a>
                        </li>
                        <li>
                            <a href="#"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                                Asignar Roles</a>
                        </li>
                        <li>
                            <a href="#"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                                Gestión de Permisos</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (Auth::user()->hasPermission('view-content'))
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="solar:document-text-outline" class="menu-icon"></iconify-icon>
                        <span>Contenido</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="#"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                                Ver Contenido</a>
                        </li>
                        @if (Auth::user()->hasPermission('create-content'))
                            <li>
                                <a href="#"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                                    Añadir Contenido</a>
                            </li>
                        @endif
                        @if (Auth::user()->hasPermission('edit-content'))
                            <li>
                                <a href="#"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i>
                                    Editar Contenido</a>
                            </li>
                        @endif
                        @if (Auth::user()->hasPermission('publish-content'))
                            <li>
                                <a href="#"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
                                    Publicar Contenido</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            <li class="sidebar-menu-group-title">Configuración</li>

            <li>
                <a href="{{ route('profile') }}">
                    <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>
                    <span>Mi Perfil</span>
                </a>
            </li>

            @if (Auth::user()->hasRole('admin'))
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="icon-park-outline:setting-two" class="menu-icon"></iconify-icon>
                        <span>Ajustes del Sistema</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="#"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                                Configuración General</a>
                        </li>
                        <li>
                            <a href="#"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                                Registros del Sistema</a>
                        </li>
                        @if (Auth::user()->hasPermission('system-settings'))
                            <li>
                                <a href="#"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                                    Configuración Avanzada</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            <li>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <a href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();">
                        <iconify-icon icon="solar:logout-3-outline" class="menu-icon"></iconify-icon>
                        <span>Cerrar Sesión</span>
                    </a>
                </form>
            </li>
        </ul>
    </div>
</aside>
