<?php

use JeroenZwart\CsvSeeder\CsvSeeder;
use Illuminate\Support\Facades\DB;

class ServerSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->tablename = 'servers';
        $this->delimiter = ',';
        $this->file = base_path().'/database/seeds/csv/servers.csv';
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::disableQueryLog();

        parent::run();
    }
}
