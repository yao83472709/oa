<?php
/*
采集猪八戒网页数据
*/
namespace App\Console\Commands;

use Illuminate\Console\Command;


class Collection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Collection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collection data';

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
        \Log::info('it works');
    
    }
}
