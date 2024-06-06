<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ObserversCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    /* protected $signature = 'app:observers-command'; */

    protected $signature = 'make:observerr {name : name of the observer.} {--class= : name of the model} {except?* : generate all Eloquent events except for specific ones.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "
        Une commande qui devrait permettre de créer un
        Observateur avec les méthodes souhaitées qui
        écoutent un modèle tout au long de son cycle de vie"
    ;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
