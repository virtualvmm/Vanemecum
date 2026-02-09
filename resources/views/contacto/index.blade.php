<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mensajes de Contacto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asunto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($mensajes as $mensaje)
                                <tr class="{{ !$mensaje->leido ? 'bg-blue-50' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $mensaje->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $mensaje->nombre }}
                                        @if($mensaje->user)
                                            <span class="text-xs text-gray-500">(Usuario registrado)</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $mensaje->email }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $mensaje->asunto }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($mensaje->leido)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Leído
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Nuevo
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button 
                                            onclick="mostrarMensaje('{{ $mensaje->id }}', '{{ addslashes($mensaje->nombre) }}', '{{ addslashes($mensaje->email) }}', '{{ addslashes($mensaje->asunto) }}', '{{ addslashes($mensaje->mensaje) }}', {{ $mensaje->leido ? 'true' : 'false' }})"
                                            class="text-indigo-600 hover:text-indigo-900 mr-4"
                                        >
                                            Ver
                                        </button>
                                        @if(!$mensaje->leido)
                                            <form action="{{ route('admin.contacto.marcar-leido', $mensaje) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:text-green-900">
                                                    Marcar leído
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No hay mensajes de contacto.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $mensajes->links() }}
                </div>

            </div>
        </div>
    </div>

    <!-- Modal para mostrar mensaje completo -->
    <div id="mensajeModal" class="fixed inset-0 z-50 overflow-y-auto hidden" style="display: none;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="cerrarModal()"></div>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modalAsunto"></h3>
                            <div class="mt-2 space-y-2">
                                <p class="text-sm text-gray-500"><strong>De:</strong> <span id="modalNombre"></span> (<span id="modalEmail"></span>)</p>
                                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                    <p class="text-sm text-gray-700 whitespace-pre-wrap" id="modalMensaje"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="cerrarModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function mostrarMensaje(id, nombre, email, asunto, mensaje, leido) {
            document.getElementById('modalNombre').textContent = nombre;
            document.getElementById('modalEmail').textContent = email;
            document.getElementById('modalAsunto').textContent = asunto;
            document.getElementById('modalMensaje').textContent = mensaje;
            document.getElementById('mensajeModal').classList.remove('hidden');
            document.getElementById('mensajeModal').style.display = 'block';
        }

        function cerrarModal() {
            document.getElementById('mensajeModal').classList.add('hidden');
            document.getElementById('mensajeModal').style.display = 'none';
        }
    </script>
</x-app-layout>

