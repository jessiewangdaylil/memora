<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FetchDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        app()->call('App\Http\Controllers\Api\FetchCountryPhoneDataController@getCountryPhoneCodeApi');

        app()->call('App\Http\Controllers\Api\FetchAddrDataController@getAddrApi');
        return Command::SUCCESS;
    }
}