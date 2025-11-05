{{-- Este partial se incluye en create.blade.php y edit.blade.php --}}
@csrf 

<div class="space-y-6">
    {{-- Campo: Nombre --}}
    <div>
        <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Nombre del Tipo <span class="text-red-500">*</span>
        </label>
        <input type="text" id="nombre" name="nombre" 
               value="{{ old('nombre', $tipo->nombre ?? '') }}" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('nombre') border-red-500 @enderror" 
               required maxlength="100" placeholder="Ej: Virus, Bacteria, Hongo, Parásito">
        @error('nombre')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Campo: Descripción --}}
    <div>
        <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Descripción Detallada
        </label>
        <textarea id="descripcion" name="descripcion" rows="4" 
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('descripcion') border-red-500 @enderror"
                  placeholder="Definición o características principales de este tipo de patógeno.">{{ old('descripcion', $tipo->descripcion ?? '') }}</textarea>
        @error('descripcion')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-end mt-4">
        <button type="submit" class="px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
            {{ $submitButtonText }} 
        </button>
    </div>
</div>