<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DeleteNonAdminUsers extends Command
{
    protected $signature = 'users:delete-non-admin';
    protected $description = 'Elimina todos los usuarios excepto el administrador (admin@example.com).';

    public function handle(): int
    {
        $adminEmail = 'admin@example.com';
        $toDelete = User::where('email', '!=', $adminEmail)->get();
        $count = $toDelete->count();

        if ($count === 0) {
            $this->info('No hay usuarios que eliminar. Solo existe el administrador.');
            return self::SUCCESS;
        }

        foreach ($toDelete as $user) {
            $user->delete();
        }

        $this->info("Eliminados {$count} usuario(s). Solo queda el administrador: {$adminEmail}");
        return self::SUCCESS;
    }
}
