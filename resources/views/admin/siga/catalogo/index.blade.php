@extends('layouts.admin')

@section('title', 'Catálogo de Bienes SIGA SIF')
@push('styles')
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .filter-card {
            border-radius: 0.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }

        .filter-header {
            padding: 0.75rem 1.25rem;
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .filter-body {
            padding: 1.25rem;
        }

        .btn-filter {
            min-width: 100px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .badge-estado {
            padding: 0.5em 0.75em;
            border-radius: 1rem;
            font-weight: 500;
            font-size: 0.75rem;
        }

        .badge-activo {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
        }

        .badge-inactivo {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .badge-tipo {
            padding: 0.35em 0.65em;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.75rem;
        }

        .badge-bien {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
        }

        .badge-servicio {
            background-color: rgba(111, 66, 193, 0.1);
            color: #6f42c1;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.25rem;
        }

        .btn-view {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
        }

        .btn-edit {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
        }

        /* Mejoras de espaciado */
        .main-content {
            padding: 2rem;
        }

        .card {
            margin-bottom: 2rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .card-header {
            padding: 1rem 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .table th,
        .table td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
        }

        .form-control,
        .form-select {
            padding: 0.5rem 1rem;
        }

        /* Mejora para los filtros */
        .filters-container {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid #e9ecef;
        }

        .filters-title {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
            color: #495057;
        }
    </style>
@endpush


@section('content')
    <div class="main-content">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <h5 class="fw-semibold mb-0">Catálogo de Bienes y Servicios</h5>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">SIGA SIF</li>
                <li>-</li>
                <li class="fw-medium">Catálogo</li>
            </ul>
        </div>

        <!-- Filtros con mejor espaciado -->
        <div class="filters-container">
            <h6 class="filters-title">
                <iconify-icon icon="material-symbols:filter-alt" class="me-2"></iconify-icon>
                Filtros de búsqueda
            </h6>
            <form action="{{ route('siga.catalogo.index') }}" method="GET" id="filter-form">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="search" class="form-label">Buscar por código o nombre</label>
                        <input type="text" class="form-control" id="search" name="search" value="{{ $search }}"
                            placeholder="Ingrese código o nombre">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="tipo_bien" class="form-label">Tipo</label>
                        <select class="form-select" id="tipo_bien" name="tipo_bien">
                            <option value="">Todos</option>
                            @foreach ($tiposBien as $tipo)
                                <option value="{{ $tipo->TIPO_BIEN }}"
                                    {{ $tipoBien == $tipo->TIPO_BIEN ? 'selected' : '' }}>
                                    {{ $tipo->DESCRIPCION }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="estado" class="form-label">Estado MEF</label>
                        <select class="form-select" id="estado" name="estado">
                            <option value="">Todos</option>
                            <option value="A" {{ $estado == 'A' ? 'selected' : '' }}>Activo</option>
                            <option value="I" {{ $estado == 'I' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-filter me-2">
                            <iconify-icon icon="material-symbols:filter-alt"></iconify-icon> Filtrar
                        </button>
                        <a href="{{ route('siga.catalogo.index') }}" class="btn btn-outline-secondary btn-filter">
                            <iconify-icon icon="material-symbols:refresh"></iconify-icon> Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla de resultados -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    Catálogo de Bienes y Servicios SIGA SIF
                    <span class="badge bg-primary ms-2">{{ $catalogo->total() }} registros</span>
                </h5>

                {{-- @if (Auth::user()->hasPermission('modify-catalogo-siga'))
                    <a href="{{ route('siga.catalogo.modify') }}" class="btn btn-primary">
                        <iconify-icon icon="lucide:edit"></iconify-icon> Modificar Catálogo
                    </a>
                @endif --}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col" width="30%">Nombre Item</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Unidad</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Estado Entidad</th>
                                <th scope="col">Estado MEF</th>
                                <th scope="col" width="100">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($catalogo as $item)
                                <tr data-codigo="{{ $item->CODIGO_ITEM }}">
                                    <td><strong>{{ $item->CODIGO_ITEM }}</strong></td>
                                    <td>{{ $item->NOMBRE_ITEM }}</td>
                                    <td>
                                        @if ($item->TIPO_BIEN == 'B')
                                            <span class="badge-tipo badge-bien">Bien</span>
                                        @else
                                            <span class="badge-tipo badge-servicio">Servicio</span>
                                        @endif
                                        <br>
                                        <small
                                            class="text-muted">{{ $item->GRUPO_BIEN }}.{{ $item->CLASE_BIEN }}.{{ $item->FAMILIA_BIEN }}.{{ $item->ITEM_BIEN }}</small>
                                    </td>
                                    <td>{{ $item->NOMBRE_UNIDAD }}</td>
                                    <td>S/ {{ number_format($item->PRECIO_COMPRA, 2) }}</td>
                                    <td class="estado-entidad">
                                        @if ($item->ESTADO == 'A')
                                            <span class="badge-estado badge-activo">Activo</span>
                                        @else
                                            <span class="badge-estado badge-inactivo">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="estado-mef">
                                        @if ($item->ESTADO_MEF == 'A')
                                            <span class="badge-estado badge-activo">Activo</span>
                                        @else
                                            <span class="badge-estado badge-inactivo">Inactivo</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- <a href="{{ route('siga.catalogo.index', ['id' => $item->CODIGO_ITEM]) }}"
                                            class="btn-action btn-view" data-bs-toggle="tooltip" title="Ver detalles">
                                            <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                        </a> --}}

                                        @if (Auth::user()->hasPermission('update-bienes-siga'))
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $item->CODIGO_ITEM }}"
                                                class="btn-action btn-edit" data-bs-toggle="tooltip" title="Editar estados">
                                                <iconify-icon icon="lucide:edit"></iconify-icon>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <iconify-icon icon="solar:round-information-linear"
                                                style="font-size: 3rem; color: #6c757d;"></iconify-icon>
                                            <h6 class="mt-3">No se encontraron registros</h6>
                                            <p class="text-muted">Intente con otros criterios de búsqueda</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $catalogo->appends(request()->query())->links() }}
                </div>
            </div>
        </div>

        <!-- Modales de Edición -->
        @foreach ($catalogo as $item)
            <div class="modal fade" id="editModal{{ $item->CODIGO_ITEM }}" tabindex="-1"
                aria-labelledby="editModalLabel{{ $item->CODIGO_ITEM }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="editForm{{ $item->CODIGO_ITEM }}" class="ajax-form">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $item->CODIGO_ITEM }}">
                                    Editar Estados
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="itemName{{ $item->CODIGO_ITEM }}" class="form-label">Item:</label>
                                    <input type="text" class="form-control" id="itemName{{ $item->CODIGO_ITEM }}"
                                        value="{{ $item->NOMBRE_ITEM }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="estado{{ $item->CODIGO_ITEM }}" class="form-label">Estado
                                        Entidad:</label>
                                    <select class="form-select" id="estado{{ $item->CODIGO_ITEM }}" name="estado">
                                        <option value="A" {{ $item->ESTADO == 'A' ? 'selected' : '' }}>Activo
                                        </option>
                                        <option value="I" {{ $item->ESTADO == 'I' ? 'selected' : '' }}>Inactivo
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="estado_mef{{ $item->CODIGO_ITEM }}" class="form-label">Estado
                                        MEF:</label>
                                    <select class="form-select" id="estado_mef{{ $item->CODIGO_ITEM }}"
                                        name="estado_mef">
                                        <option value="A" {{ $item->ESTADO_MEF == 'A' ? 'selected' : '' }}>Activo
                                        </option>
                                        <option value="I" {{ $item->ESTADO_MEF == 'I' ? 'selected' : '' }}>Inactivo
                                        </option>
                                    </select>
                                </div>

                                <!-- Campos ocultos necesarios para la actualización -->
                                <input type="hidden" name="grupo_bien" value="{{ $item->GRUPO_BIEN }}">
                                <input type="hidden" name="clase_bien" value="{{ $item->CLASE_BIEN }}">
                                <input type="hidden" name="familia_bien" value="{{ $item->FAMILIA_BIEN }}">
                                <input type="hidden" name="item_bien" value="{{ $item->ITEM_BIEN }}">
                                <input type="hidden" name="codigo_item" value="{{ $item->CODIGO_ITEM }}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary save-changes-btn"
                                    data-codigo="{{ $item->CODIGO_ITEM }}">
                                    Guardar cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Toast container -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="toastContainer"></div>
    </div>
@endsection

@push('scripts')
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Configuración de Toastr
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Inicializar tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Mostrar mensaje de éxito si existe (para mensajes de sesión después de recargas)
            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif

            // Manejar envío de formularios AJAX
            // Manejar envío de formularios AJAX
            document.querySelectorAll('.save-changes-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const codigoItem = this.getAttribute('data-codigo');
                    const form = document.getElementById('editForm' + codigoItem);
                    const modalElement = document.getElementById('editModal' + codigoItem);

                    // Obtener los valores del formulario
                    const formData = new FormData(form);
                    formData.append('_method', 'PUT'); // Para simular una solicitud PUT

                    // Configurar indicador de carga
                    const loadingText =
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';
                    const originalText = this.innerHTML;
                    this.innerHTML = loadingText;
                    this.disabled = true;

                    // Hacer solicitud AJAX con URL corregida
                    fetch('{{ route('siga.bienes.update.estados', '__ID__') }}'.replace('__ID__',
                            codigoItem), {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Cerrar el modal correctamente
                            const modal = bootstrap.Modal.getInstance(modalElement);
                            modal.hide();

                            // Mostrar mensaje de éxito
                            if (data.success) {
                                toastr.success(data.message);

                                // Actualizar los estados en la tabla sin recargar
                                updateItemStatus(codigoItem, formData.get('estado'), formData
                                    .get('estado_mef'));
                            } else {
                                toastr.error(data.message || 'Ha ocurrido un error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            toastr.error('Ha ocurrido un error al procesar la solicitud');
                        })
                        .finally(() => {
                            // Restaurar el botón
                            this.innerHTML = originalText;
                            this.disabled = false;
                        });
                });
            });

            // Función para actualizar los estados en la tabla sin recargar
            function updateItemStatus(codigoItem, estadoEntidad, estadoMEF) {
                // Encontrar la fila correspondiente
                const row = document.querySelector(`tr[data-codigo="${codigoItem}"]`);
                if (!row) return;

                // Actualizar el estado de la entidad
                const estadoEntidadCell = row.querySelector('.estado-entidad');
                if (estadoEntidadCell) {
                    estadoEntidadCell.innerHTML = '';
                    const badge = document.createElement('span');
                    badge.className = estadoEntidad === 'A' ?
                        'badge-estado badge-activo' :
                        'badge-estado badge-inactivo';
                    badge.textContent = estadoEntidad === 'A' ? 'Activo' : 'Inactivo';
                    estadoEntidadCell.appendChild(badge);
                }

                // Actualizar el estado MEF
                const estadoMEFCell = row.querySelector('.estado-mef');
                if (estadoMEFCell) {
                    estadoMEFCell.innerHTML = '';
                    const badge = document.createElement('span');
                    badge.className = estadoMEF === 'A' ?
                        'badge-estado badge-activo' :
                        'badge-estado badge-inactivo';
                    badge.textContent = estadoMEF === 'A' ? 'Activo' : 'Inactivo';
                    estadoMEFCell.appendChild(badge);
                }
            }
        });
    </script>
@endpush
