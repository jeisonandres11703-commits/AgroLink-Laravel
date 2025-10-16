<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define los comandos Artisan de la aplicación.
     */
    protected $commands = [
        // Aquí registras tus comandos personalizados
        \App\Console\Commands\HashUserPasswords::class,

    ];

    /**
     * Define la programación de tareas.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Registra los comandos para Artisan.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}