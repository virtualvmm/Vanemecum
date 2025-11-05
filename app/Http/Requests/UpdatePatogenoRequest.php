<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * UpdatePatogenoRequest
 *
 * Clase para manejar la validación y autorización al actualizar un Patógeno existente.
 * La clave es usar Rule::unique()->ignore() para permitir que el nombre actual del
 * patógeno permanezca sin generar un error de unicidad.
 */
class UpdatePatogenoRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta petición.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Al igual que en Store, asumimos que el usuario está autorizado
        // para editar patógenos.
        return true; 
    }

    /**
     * Obtiene las reglas de validación que se aplican a la petición.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // Accedemos al modelo Patogeno que Laravel ha inyectado en la ruta
        // usando $this->route('patogeno').
        $patogenoId = $this->route('patogeno')->id;

        return [
            // REGLA CLAVE: El nombre debe ser único, PERO IGNORANDO el ID del patógeno actual.
            'nombre' => [
                'required', 
                'string', 
                'max:150', 
                Rule::unique('patogenos', 'nombre')->ignore($patogenoId)
            ],
            
            // Relación 1:N con TipoPatogeno
            'tipo_patogeno_id' => ['required', 'exists:tipo_patogenos,id'],
            
            // Relación 1:N con Fuente (puede ser nula)
            'fuente_id' => ['nullable', 'exists:fuentes,id'], 
            
            'descripcion' => ['nullable', 'string'],
            
            // El campo de imagen es opcional. Si se envía, debe ser un archivo de imagen.
            'image_url' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], 
            
            'is_active' => ['nullable', 'boolean'],

            // Relaciones Muchos a Muchos (M:M)
            'tratamientos' => ['nullable', 'array'],
            'tratamientos.*' => ['exists:tratamientos,id'],
            
            'sintomas' => ['nullable', 'array'],
            'sintomas.*' => ['exists:sintomas,id'],
        ];
    }

    /**
     * Personaliza los mensajes de error de validación.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nombre.unique' => 'Ya existe otro patógeno con este nombre en la base de datos.',
            'tipo_patogeno_id.required' => 'Debe seleccionar un tipo de patógeno.',
            'image_url.image' => 'El archivo debe ser una imagen válida.',
            'image_url.max' => 'El tamaño de la imagen no debe superar los 2MB.',
        ];
    }
}