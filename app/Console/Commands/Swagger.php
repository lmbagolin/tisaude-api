<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OpenApi\Generator;

class Swagger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'documentation:swagger';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $openapi = Generator::scan([app_path()]);

        $file = fopen(public_path("swagger/swagger.yml"), "w");
        fwrite($file, $openapi->toYaml());
        fclose($file);

        $this->info('Documentação atualizada com sucesso!');
        return 0;
    }
}
