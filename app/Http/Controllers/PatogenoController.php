<?php

namespace App\Http\Controllers;

use App\Models\Patogeno;
use App\Models\TipoPatogeno;
use App\Models\Tratamiento;
use App\Models\Sintoma;
use App\Models\Fuente;
use App\Http\Requests\StorePatogenoRequest;
use App\Http\Requests\UpdatePatogenoRequest; // Usamos el Request dedicado
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

/**
 * PatogenoController
 * Controlador para la administración CRUD (Crear, Leer, Actualizar, Eliminar)
 * de Patógenos.
 *
 * NOTA PROFESIONAL: Se recomienda implementar una PatogenoPolicy para gestionar
 * la autorización de roles (Admin vs. User) en cada método.
 */
class PatogenoController extends Controller
{
    /**
     * Muestra el listado de patógenos para la administración.
     * Incluye búsqueda y paginación.
     */
    public function index(Request $request)
    {
        // Asumiendo que aquí ya se ha verificado la autorización (ej. PatogenoPolicy::viewAny)
        $query = $request->input('query');

        // Cargamos las relaciones tipo y fuente para mostrarlas en la tabla.
        $patogenos = Patogeno::with(['tipo', 'fuente']);

        // Aplicar filtro de búsqueda por nombre o descripción
        if ($query) {
            $patogenos->where(function ($q) use ($query) {
                $q->where('nombre', 'LIKE', "%{$query}%")
                  ->orWhere('descripcion', 'LIKE', "%{$query}%");
            });
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
     * Carga las relaciones (TipoPatogeno, Fuente, Tratamiento, Sintoma) para los selectores.
     */
    public function create()
    {
        // Asumiendo que aquí ya se ha verificado la autorización (ej. PatogenoPolicy::create)
        
        // Cargamos todas las opciones necesarias para los selectores del formulario.
        $tipos = TipoPatogeno::orderBy('nombre')->get();
        $tratamientos = Tratamiento::orderBy('nombre')->get();
        $sintomas = Sintoma::orderBy('nombre')->get();
        $fuentes = Fuente::orderBy('nombre')->get();

        return view('patogenos.create', [
            'tipos' => $tipos,
            'tratamientos' => $tratamientos,
            'sintomas' => $sintomas,
            'fuentes' => $fuentes,
        ]);
    }

    /**
     * Almacena un nuevo patógeno en la base de datos.
     * Usamos el Form Request dedicado para la validación.
     */
    public function store(StorePatogenoRequest $request)
    {
        // Asumiendo que aquí ya se ha verificado la autorización (ej. PatogenoPolicy::create)

        // 1. Validar los datos y obtener el array limpio
        $data = $request->validated();

        // 2. Manejo de la subida de imagen (si existe)
        $data['image_url'] = null;
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('patogenos', 'public');
            // Almacenamos la URL pública
            $data['image_url'] = Storage::url($path);
        }

        // 3. Normalizar el checkbox is_active
        // Si el checkbox no se envía, su valor es false.
        $data['is_active'] = $request->boolean('is_active');

        // 4. Crear el Patógeno (Excluimos las relaciones M:M antes de crear)
        $patogeno = Patogeno::create([
            'nombre'           => $data['nombre'],
            'tipo_patogeno_id' => $data['tipo_patogeno_id'],
            'fuente_id'        => $data['fuente_id'] ?? null,
            'descripcion'      => $data['descripcion'],
            'image_url'        => $data['image_url'],
            'is_active'        => $data['is_active'],
        ]);

        // 5. Sincronizar relaciones Muchos a Muchos
        // El método sync() puede recibir un array vacío si no se selecciona nada.
        $patogeno->tratamientos()->sync($data['tratamientos'] ?? []);
        $patogeno->sintomas()->sync($data['sintomas'] ?? []);

        return redirect()->route('patogenos.index')->with('success', 'Patógeno creado exitosamente.');
    }

    /**
     * Muestra la página de detalle de un patógeno (normalmente redirige a 'edit' en admin).
     */
    public function show(Patogeno $patogeno)
    {
        // Asumiendo que aquí ya se ha verificado la autorización (ej. PatogenoPolicy::view)

        // Redirigimos al 'edit' para la administración, cargando todas las relaciones.
        return redirect()->route('patogenos.edit', $patogeno);
    }

    /**
     * Muestra el formulario para editar un patógeno existente.
     */
    public function edit(Patogeno $patogeno)
    {
        // Asumiendo que aquí ya se ha verificado la autorización (ej. PatogenoPolicy::update)

        // Eager load para evitar N+1 (tratamientos y sintomas se usan en la vista)
        $patogeno->load(['tratamientos', 'sintomas']);

        // Cargamos todas las opciones necesarias
        $tipos = TipoPatogeno::orderBy('nombre')->get();
        $tratamientos = Tratamiento::orderBy('nombre')->get();
        $sintomas = Sintoma::orderBy('nombre')->get();
        $fuentes = Fuente::orderBy('nombre')->get();

        // IDs asignados al patógeno para marcar los checkboxes/select
        $patogenoTratamientos = $patogeno->tratamientos->pluck('id')->toArray();
        $patogenoSintomas = $patogeno->sintomas->pluck('id')->toArray();
        
        // Obtenemos el ID de la fuente asignada
        $patogenoFuenteId = $patogeno->fuente_id; 

        return view('patogenos.edit', [
            'patogeno' => $patogeno,
            'tipos' => $tipos,
            'tratamientos' => $tratamientos,
            'sintomas' => $sintomas,
            'fuentes' => $fuentes,
            'patogenoTratamientos' => $patogenoTratamientos,
            'patogenoSintomas' => $patogenoSintomas,
            'patogenoFuenteId' => $patogenoFuenteId,
        ]);
    }

    /**
     * Actualiza el patógeno en la base de datos.
     * Usamos el Form Request dedicado para la validación (UpdatePatogenoRequest).
     */
    public function update(UpdatePatogenoRequest $request, Patogeno $patogeno)
    {
        // Asumiendo que aquí ya se ha verificado la autorización (ej. PatogenoPolicy::update)

        // 1. Obtener los datos validados del Form Request
        $data = $request->validated();
        
        $imageUrl = $patogeno->image_url;

        // 2. Manejo de la subida de imagen
        if ($request->hasFile('image_url')) {
            // Eliminar imagen antigua si existe (convertir URL pública a ruta de disco)
            if ($patogeno->image_url) {
                // Obtenemos la ruta relativa al disco eliminando la URL base /storage/
                $pathToDelete = str_replace(Storage::url(''), '', $patogeno->image_url);
                Storage::disk('public')->delete($pathToDelete);
            }
            // Subir nueva imagen
            $path = $request->file('image_url')->store('patogenos', 'public');
            $imageUrl = Storage::url($path);
        }

        // 3. Actualizar el Patógeno
        $patogeno->update([
            'nombre'           => $data['nombre'],
            'tipo_patogeno_id' => $data['tipo_patogeno_id'],
            'fuente_id'        => $data['fuente_id'] ?? null,
            'descripcion'      => $data['descripcion'],
            'image_url'        => $imageUrl,
            'is_active'        => $request->boolean('is_active'),
        ]);

        // 4. Sincronizar relaciones Muchos a Muchos
        $patogeno->tratamientos()->sync($data['tratamientos'] ?? []);
        $patogeno->sintomas()->sync($data['sintomas'] ?? []);

        return redirect()->route('patogenos.index')->with('success', 'Patógeno actualizado exitosamente.');
    }

    /**
     * Elimina un patógeno de la base de datos.
     */
    public function destroy(Patogeno $patogeno)
    {
        // Asumiendo que aquí ya se ha verificado la autorización (ej. PatogenoPolicy::delete)

        // 1. Eliminar relaciones M:M 
        $patogeno->tratamientos()->detach();
        $patogeno->sintomas()->detach();

        // 2. Eliminar imagen del disco
        if ($patogeno->image_url) {
            $pathToDelete = str_replace(Storage::url(''), '', $patogeno->image_url);
            Storage::disk('public')->delete($pathToDelete);
        }

        // 3. Eliminar Patógeno
        $patogeno->delete();

        return redirect()->route('patogenos.index')->with('success', 'Patógeno eliminado correctamente.');
    }
}