<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customer;

class EveryMinute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minute:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will update database every minute';

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
        $cust = new Customer;
        $res = $cust->where(['status' => 1])->get();
        var_dump($res);
        return 0;
    }
}
