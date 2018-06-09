<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\AddDataFromApi;

class Apifetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:edamam';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call Edamam API to update database where queries failed';

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
     * @return mixed
     */
    public function handle()
    {
        $add_from_api = new AddDataFromApi;
        $add_from_api->update_db();

    }
}

