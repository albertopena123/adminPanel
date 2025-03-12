<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="{{ route('dashboard') }}" class="sidebar-logo">
            <!-- Logo modo claro -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 80" class="main-logo light-logo">
                <g>
                    <rect width="320" height="80" fill="white" opacity="0" />
                    <path d="M20,20 h40 v10 h-30 v10 h25 v10 h-25 v10 h30 v10 h-40 z" fill="#2563EB" />
                    <path d="M70,20 h10 v40 h-10 z" fill="#2563EB" />
                    <path d="M90,20 h40 v10 h-15 v30 h-10 v-30 h-15 z" fill="#2563EB" />
                    <path d="M140,20 h40 v10 h-30 v10 h25 v10 h-25 v10 h30 v10 h-40 z" fill="#2563EB" />
                    <path d="M190,20 h10 v40 h-10 z" fill="#2563EB" />
                    <path
                        d="M210,20 c0,0 10,0 20,0 c10,0 20,10 20,20 c0,10 -10,20 -20,20 c-10,0 -20,0 -20,0 z M220,30 v20 c0,0 5,0 10,0 c5,0 10,-5 10,-10 c0,-5 -5,-10 -10,-10 c-5,0 -10,0 -10,0 z"
                        fill="#2563EB" />
                    <path d="M260,20 h40 v10 h-15 v30 h-10 v-30 h-15 z" fill="#2563EB" />
                </g>
            </svg>

            <!-- Logo modo oscuro - CORREGIDO: eliminado style="display:none" -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 80" class="main-logo dark-logo">
                <g> <!-- Eliminado el id="logo-dark" y style="display:none" -->
                    <rect width="320" height="80" fill="#1E293B" opacity="0" />
                    <path d="M20,20 h40 v10 h-30 v10 h25 v10 h-25 v10 h30 v10 h-40 z" fill="#60A5FA" />
                    <path d="M70,20 h10 v40 h-10 z" fill="#60A5FA" />
                    <path d="M90,20 h40 v10 h-15 v30 h-10 v-30 h-15 z" fill="#60A5FA" />
                    <path d="M140,20 h40 v10 h-30 v10 h25 v10 h-25 v10 h30 v10 h-40 z" fill="#60A5FA" />
                    <path d="M190,20 h10 v40 h-10 z" fill="#60A5FA" />
                    <path
                        d="M210,20 c0,0 10,0 20,0 c10,0 20,10 20,20 c0,10 -10,20 -20,20 c-10,0 -20,0 -20,0 z M220,30 v20 c0,0 5,0 10,0 c5,0 10,-5 10,-10 c0,-5 -5,-10 -10,-10 c-5,0 -10,0 -10,0 z"
                        fill="#60A5FA" />
                    <path d="M260,20 h40 v10 h-15 v30 h-10 v-30 h-15 z" fill="#60A5FA" />
                </g>
            </svg>

            <!-- Logo icono - CORREGIDO: eliminado style="display:none" -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 80" class="mobile-logo">
                <g> <!-- Eliminado el id="logo-icon" y style="display:none" -->
                    <rect width="320" height="80" fill="white" opacity="0" />
                    <circle cx="160" cy="40" r="35" fill="#2563EB" />
                    <path d="M140,25 h40 v7 h-40 z" fill="white" />
                    <path d="M140,35 h40 v7 h-40 z" fill="white" />
                    <path d="M140,45 h40 v7 h-40 z" fill="white" />
                    <path d="M140,55 h15 v-37 h7 v37 h-22 z" fill="white" transform="translate(0,-10)" />
                </g>
            </svg>
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

            <!-- Agregar después de la sección de Contenido y antes de la sección de Configuración -->

            @if (Auth::user()->hasPermission('view-catalogo-siga'))
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="solar:box-outline" class="menu-icon"></iconify-icon>
                        <span>SIGA SIF</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('siga.catalogo.index') }}"><i
                                    class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                                Catálogo de Bienes</a>
                        </li>
                        @if (Auth::user()->hasPermission('update-bienes-siga'))
                            <li>
                                <a href="{{ route('siga.bienes.update') }}"><i
                                        class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                                    Actualizar Bienes</a>
                            </li>
                        @endif
                        @if (Auth::user()->hasPermission('modify-catalogo-siga'))
                            <li>
                                <a href="{{ route('siga.catalogo.modify') }}"><i
                                        class="ri-circle-fill circle-icon text-success-main w-auto"></i>
                                    Modificar Catálogo</a>
                            </li>
                        @endif
                        @if (Auth::user()->hasPermission('manage-unidades-siga'))
                            <li>
                                <a href="{{ route('siga.unidades.index') }}"><i
                                        class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                                    Unidades de Medida</a>
                            </li>
                        @endif
                        @if (Auth::user()->hasPermission('admin-siga-complete'))
                            <li>
                                <a href="{{ route('siga.admin') }}"><i
                                        class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
                                    Administración SIGA</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

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
