<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Deja en la base de datos solo dos roles: Admin y User.
     * Reasigna usuarios de roles antiguos (Administrador, Usuario, Editor, Lector) a Admin o User y elimina el resto de roles.
     */
    public function up(): void
    {
        $adminId = DB::table('roles')->where('nombre', 'Admin')->value('id');
        $userId = DB::table('roles')->where('nombre', 'User')->value('id');

        if (!$adminId) {
            $adminId = DB::table('roles')->insertGetId([
                'nombre' => 'Admin',
                'descripcion' => 'Administrador del sistema.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        if (!$userId) {
            $userId = DB::table('roles')->insertGetId([
                'nombre' => 'User',
                'descripcion' => 'Usuario estándar.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $rolesAdmin = DB::table('roles')->whereIn('nombre', ['Admin', 'Administrador'])->pluck('id')->all();
        $userIds = DB::table('role_user')->distinct()->pluck('user_id');

        foreach ($userIds as $uid) {
            $tieneAdmin = DB::table('role_user')
                ->where('user_id', $uid)
                ->whereIn('role_id', $rolesAdmin)
                ->exists();
            $nuevoRolId = $tieneAdmin ? $adminId : $userId;
            DB::table('role_user')->where('user_id', $uid)->delete();
            DB::table('role_user')->insert(['user_id' => $uid, 'role_id' => $nuevoRolId]);
        }

        DB::table('roles')->whereNotIn('nombre', ['Admin', 'User'])->delete();
    }

    public function down(): void
    {
        //
    }
};
