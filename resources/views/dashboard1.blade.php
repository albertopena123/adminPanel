<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen">
        <nav class="bg-gray-800 text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <div class="font-bold text-xl">Mi Aplicación</div>
                <div class="flex items-center">
                    <span class="mr-4">Hola, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="container mx-auto p-6">
            <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4">Bienvenido a tu cuenta</h2>
                <p>Este es el panel de control principal.</p>

                @if (Auth::user()->hasRole('admin'))
                    <div class="mt-4 p-4 bg-blue-100 rounded">
                        <h3 class="font-bold text-blue-800">Acciones de Administrador</h3>
                        <ul class="mt-2">
                            <li><a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Panel de
                                    Administración</a></li>
                            <li><a href="{{ route('admin.users.index') }}"
                                    class="text-blue-600 hover:underline">Gestionar Usuarios</a></li>
                        </ul>
                    </div>
                @endif

                <div class="mt-4">
                    <h3 class="font-bold">Tus roles:</h3>
                    <ul class="list-disc ml-6 mt-2">
                        @foreach (Auth::user()->roles as $role)
                            <li>{{ $role->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
