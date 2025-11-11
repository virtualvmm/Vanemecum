<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Valida los datos necesarios para crear un nuevo Patógeno.
 *
 * Utiliza los nombres de campos de la base de datos (e.g., 'tipo_patogeno_id', 'fuente_id')
 * y las listas de IDs de las relaciones Muchos a Muchos (e.g., 'tratamientos').
 */
class StorePatogenoRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta petición.
     * En un contexto de administración, esto suele ser 'true' o comprobar permisos específicos.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Asumiendo que solo los usuarios autenticados pueden crear patógenos.
        // Si tienes Gates o Policies, deberías usarlos aquí, pero por defecto, asumimos true.
        return true; 
    }

    /**
     * Obtiene las reglas de validación que se aplican a la petición.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // El nombre debe ser único en la tabla 'patogenos'.
            'nombre' => ['required', 'string', 'max:150', 'unique:patogenos,nombre'],
            
            // Relación N:1 a TipoPatogeno. El campo debe ser requerido y existir.
            'tipo_patogeno_id' => ['required', 'exists:tipo_patogenos,id'],

            // Relación N:1 a Fuente (opcional). Debe existir si se proporciona.
            'fuente_id' => ['nullable', 'exists:fuentes_informacion,id'],
            
            'descripcion' => ['nullable', 'string'],
            
            // El campo del archivo es el que viaja en el request, por eso lo llamamos 'image_url'.
            'image_url' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], // 2MB max

            // Imágenes adicionales (múltiples)
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:4096'],

            // Campo booleano (checkbox). Puede ser 'null' si no está marcado.
            'is_active' => ['nullable', 'boolean'], 

            // Relaciones Muchos a Muchos (arrays de IDs)
            'tratamientos' => ['nullable', 'array'],
            'tratamientos.*' => ['exists:tratamientos,id'], // Cada elemento del array debe existir
            
            'sintomas' => ['nullable', 'array'],
            'sintomas.*' => ['exists:sintomas,id'], // Cada elemento del array debe existir
        ];
    }

    /**
     * Personaliza los mensajes de error (opcional).
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nombre.unique' => 'Ya existe un patógeno con ese nombre.',
            'tipo_patogeno_id.required' => 'Debe seleccionar un tipo de patógeno.',
            'tipo_patogeno_id.exists' => 'El tipo de patógeno seleccionado no es válido.',
            'image_url.image' => 'El archivo debe ser una imagen válida (jpeg, png, jpg, gif, svg).',
            'image_url.max' => 'El tamaño máximo de la imagen es 2MB.',
        ];
    }
}
