<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OpenApi\Generator;
use Symfony\Component\Console\Command\Command as CommandAlias;

class Swagger extends Command
{
    protected $signature = 'swagger';

    protected $description = 'This command generate swagger api documentation';

    public function handle()
    {
        $openApi = Generator::scan([config('swagger.sources')]);
        file_put_contents("public/api-documentation/swagger.json", $openApi->toJson());

        $this->info('Api documentation generated successfully');
        return CommandAlias::SUCCESS;
    }
}
