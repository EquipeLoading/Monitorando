<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Monitoria;
use App\Models\User;
use Carbon\Carbon;
use Date;
use DateTime;
use DateInterval;

class DataMonitorias extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:monitorias';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para alterar automaticamente a data das monitorias';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $monitorias = Monitoria::all();
            foreach($monitorias as $monitoria) {
                $data1 = new DateTime($monitoria->data.' '.$monitoria->hora_fim);
                $data2 = new DateTime('now');
                if(($data1 < $data2) && ($monitoria->periodo != 0)) {
                    $monitoriaNova = new Monitoria();

                    $periodo = $monitoria->periodo;
                    $data = null;
                    $resultado = null;
                    if(isset($periodo)){
                        $data = new DateTime($monitoria->data);
                        $data = $data->add(new DateInterval('P'.$periodo.'D'));
                        $resultado = $data->format('Y-m-d H:i:s');
                        $resultado = explode(' ', $resultado);
                    }

                    $monitoriaNova->fill([
                        'codigo' => $monitoria->codigo,
                        'conteudo' => $monitoria->conteudo,
                        'data' => $resultado[0],
                        'hora_inicio' => $monitoria->hora_inicio,
                        'hora_fim' => $monitoria->hora_fim,
                        'num_inscritos' => 0,
                        'descricao' => $monitoria->descricao,
                        'disciplina' => $monitoria->disciplina,
                        'monitor' => $monitoria->monitor,
                        'local' => $monitoria->local,
                        'periodo' => $monitoria->periodo
                    ])->save();

                    $monitoria->update(['periodo' => 0]);

                    $monitores = explode(' e ', $monitoria->monitor);

                    $criador = $monitoria->usuarios()->wherePivot('tipo', 'Criador')->get()->first();
                    User::find($criador->id)->monitorias()->attach($monitoriaNova->id, ['tipo' => 'Criador']);

                    foreach($monitores as $monitorNovo){
                        $monitor = User::where('prontuario', $monitorNovo)->get()->first();
                        User::find($monitor->id)->monitorias()->attach($monitoriaNova->id, ['tipo' => 'Monitor']);
                    }
                }
            }
    }
}
