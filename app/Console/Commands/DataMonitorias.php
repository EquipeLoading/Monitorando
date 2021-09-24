<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Monitoria;
use Carbon\Carbon;
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
                if($data1 < $data2) {
                    $periodo = $monitoria->periodo;
                    if(isset($periodo)){
                        $data = $data1->add(new DateInterval('P'.$periodo.'D'));
                        $monitoria->update(['data' => $data]);
                    }
                }
            }
    }
}
