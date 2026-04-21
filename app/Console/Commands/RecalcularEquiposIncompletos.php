<?php

namespace App\Console\Commands;

use App\Models\Equipo;
use Illuminate\Console\Command;

class RecalcularEquiposIncompletos extends Command
{
    protected $signature   = 'equipos:recalcular-incompletos';
    protected $description = 'Recalcula el flag datos_incompletos para todos los equipos';

    public function handle(): int
    {
        $equipos     = Equipo::all();
        $completos   = 0;
        $incompletos = 0;

        foreach ($equipos as $equipo) {
            $equipo->save(); // el evento saving recalcula datos_incompletos
            $equipo->datos_incompletos ? $incompletos++ : $completos++;
        }

        $this->info("Recalculado: {$completos} completos, {$incompletos} incompletos.");

        return Command::SUCCESS;
    }
}
