<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Monitoria;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('professor', function() {
            $usuario = Auth::user();
            $professor = false;
            if($usuario->tipo == 'Professor'){
                $professor = true;
            }
            
            return $professor;
        });

        Gate::define('criador', function(User $user, Monitoria $monitoria) {
            $usuariosCriadores = $user->monitorias()->wherePivot('tipo', 'Criador')->get();
            $criador = false;

            foreach($usuariosCriadores as $usuarioCriador) {
                if($usuarioCriador->id === $monitoria->id){
                    $criador = true;
                }
            }

            return $criador;
        });

        Gate::define('monitor', function(User $user, Monitoria $monitoria) {
            $monitorias = $user->monitorias()->wherePivot('tipo', 'Monitor')->get();
            $monitor = false;

            foreach($monitorias as $usuarioMonitor) {
                if($usuarioMonitor->id === $monitoria->id){
                    $monitor = true;
                }
            }

            return $monitor;
        });
    }
}
