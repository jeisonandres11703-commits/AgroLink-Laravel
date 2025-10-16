<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HashUserPasswords extends Command
{
    /**
     * El nombre y firma del comando.
     *
     * php artisan users:hash-passwords --temp="clave123"
     */
    protected $signature = 'users:hash-passwords {--temp=}';

    /**
     * Descripción del comando.
     */
    protected $description = 'Hashea todas las contraseñas de tb_users con una contraseña temporal';

    /**
     * Lógica del comando.
     */
    public function handle()
    {
        $temp = $this->option('temp');

        if (!$temp) {
            $this->error('Debes pasar una contraseña temporal con --temp="clave"');
            return Command::FAILURE;
        }

        DB::table('tb_users')->update([
            'user_password' => Hash::make($temp),
        ]);

        $this->info("Todas las contraseñas fueron actualizadas a la clave temporal: {$temp}");
        return Command::SUCCESS;
    }
}