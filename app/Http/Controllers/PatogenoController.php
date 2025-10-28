<?php

namespace App\Http\Controllers;

use App\Models\Patogeno;
use App\Models\TipoPatogeno;
use App\Models\Tratamiento;
use App\Models\Sintoma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

/**
 * PatogenoController
 * Controlador para la administración CRUD (Crear, Leer, Actualizar, Eliminar)
 * de Patógenos. Protegido por autenticación.
 */
class PatogenoController extends Controller
{
    /**
     * Muestra el listado de patógenos para la administración.
     * Incluye búsqueda y paginación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = $request->input('query');

        $patogenos = Patogeno::with('tipo');

        // Aplicar filtro de búsqueda si existe un término
        if ($query) {
            // Buscamos solo por la columna 'nombre', que es la que existe.
            $patogenos->where('nombre', 'LIKE', "%{$query}%");
        }

        // Obtener los patógenos paginados y ordenados.
        $patogenos = $patogenos->orderBy('nombre')->paginate(10);

        return view('patogenos.index', [
            'patogenos' => $patogenos,
            'query' => $query,
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo patógeno.
     * Carga las relaciones (TipoPatogeno, Tratamiento, Sintoma) para los selectores.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Cargamos todas las opciones necesarias para los selectores del formulario.
        $tipos = TipoPatogeno::orderBy('nombre')->get();
        $tratamientos = Tratamiento::orderBy('nombre')->get();
        $sintomas = Sintoma::orderBy('nombre')->get();

        return view('patogenos.create', [
            'tipos' => $tipos,
            'tratamientos' => $tratamientos,
            'sintomas' => $sintomas,
        ]);
    }

    /**
     * Almacena un nuevo patógeno en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:150', 'unique:patogenos,nombre'],
            'tipo_id' => ['required', 'exists:tipo_patogenos,id'],
            'descripcion' => ['nullable', 'string'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Para subir archivos
            'is_active' => ['boolean'],
            'tratamientos' => ['nullable', 'array'],
            'tratamientos.*' => ['exists:tratamientos,id'],
            'sintomas' => ['nullable', 'array'],
            'sintomas.*' => ['exists:sintomas,id'],
            // Las fuentes no se gestionan desde aquí, solo se asigna la 'fuente_id'.
            // Asumimos que la fuente se asigna manualmente o es nullable.
        ]);

        $imageUrl = null;
        // 1. Manejo de la subida de imagen (si existe)
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('patogenos', 'public');
            $imageUrl = Storage::url($path);
        }

        // 2. Crear el Patógeno
        $patogeno = Patogeno::create([
            'nombre' => $request->nombre,
            'tipo_id' => $request->tipo_id,
            'descripcion' => $request->descripcion,
            'image_url' => $imageUrl, // Guardamos la URL de la imagen
            'is_active' => $request->boolean('is_active'),
            // 'fuente_id' se puede asignar aquí si viene en el request
        ]);

        // 3. Sincronizar relaciones Muchos a Muchos
        $patogeno->tratamientos()->sync($request->tratamientos);
        $patogeno->sintomas()->sync($request->sintomas);

        return redirect()->route('patogenos.index')->with('success', 'Patógeno creado exitosamente.');
    }

    /**
     * Muestra la página de detalle de un patógeno (no es necesario en el CRUD admin, pero se mantiene).
     *
     * @param  \App\Models\Patogeno  $patogeno
     * @return \Illuminate\View\View
     */
    public function show(Patogeno $patogeno)
    {
        // Redirigimos al 'show' público o simplemente a 'edit' en admin
        return redirect()->route('patogenos.edit', $patogeno);
    }

    /**
     * Muestra el formulario para editar un patógeno existente.
     * Carga las opciones y las relaciones ya asignadas.
     *
     * @param  \App\Models\Patogeno  $patogeno
     * @return \Illuminate\View\View
     */
    public function edit(Patogeno $patogeno)
    {
        // Cargamos todas las opciones necesarias
        $tipos = TipoPatogeno::orderBy('nombre')->get();
        $tratamientos = Tratamiento::orderBy('nombre')->get();
        $sintomas = Sintoma::orderBy('nombre')->get();

        // Obtenemos los IDs asignados al patógeno para marcar los checkboxes/select
        $patogenoTratamientos = $patogeno->tratamientos->pluck('id')->toArray();
        $patogenoSintomas = $patogeno->sintomas->pluck('id')->toArray();

        return view('patogenos.edit', [
            'patogeno' => $patogeno,
            'tipos' => $tipos,
            'tratamientos' => $tratamientos,
            'sintomas' => $sintomas,
            'patogenoTratamientos' => $patogenoTratamientos,
            'patogenoSintomas' => $patogenoSintomas,
        ]);
    }

    /**
     * Actualiza el patógeno en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patogeno  $patogeno
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Patogeno $patogeno)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:150', Rule::unique('patogenos', 'nombre')->ignore($patogeno->id)],
            'tipo_id' => ['required', 'exists:tipo_patogenos,id'],
            'descripcion' => ['nullable', 'string'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'is_active' => ['boolean'],
            'tratamientos' => ['nullable', 'array'],
            'tratamientos.*' => ['exists:tratamientos,id'],
            'sintomas' => ['nullable', 'array'],
            'sintomas.*' => ['exists:sintomas,id'],
        ]);

        $imageUrl = $patogeno->image_url;

        // 1. Manejo de la subida de imagen
        if ($request->hasFile('image_file')) {
            // Eliminar imagen antigua si existe
            if ($patogeno->image_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $patogeno->image_url));
            }
            // Subir nueva imagen
            $path = $request->file('image_file')->store('patogenos', 'public');
            $imageUrl = Storage::url($path);
        }

        // 2. Actualizar el Patógeno
        $patogeno->update([
            'nombre' => $request->nombre,
            'tipo_id' => $request->tipo_id,
            'descripcion' => $request->descripcion,
            'image_url' => $imageUrl,
            'is_active' => $request->boolean('is_active'),
        ]);

        // 3. Sincronizar relaciones Muchos a Muchos
        $patogeno->tratamientos()->sync($request->tratamientos);
        $patogeno->sintomas()->sync($request->sintomas);

        return redirect()->route('patogenos.index')->with('success', 'Patógeno actualizado exitosamente.');
    }

    /**
     * Elimina un patógeno de la base de datos.
     *
     * @param  \App\Models\Patogeno  $patogeno
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Patogeno $patogeno)
    {
        // Eliminar relaciones Muchos a Muchos (Laravel lo hace automáticamente si se usa 'sync', pero es bueno ser explícito)
        $patogeno->tratamientos()->detach();
        $patogeno->sintomas()->detach();

        // Eliminar imagen del disco
        if ($patogeno->image_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $patogeno->image_url));
        }

        // Eliminar Patógeno
        $patogeno->delete();

        return redirect()->route('patogenos.index')->with('success', 'Patógeno eliminado correctamente.');
    }
}