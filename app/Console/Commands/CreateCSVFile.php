<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\CSV;
use Carbon\Carbon;

class CreateCSVFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adding new CSV to directory';

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
        $month = Carbon::now();
        $nextMonth = $month->modify( 'next month' );
        $csv = new CSV('amatelic');
        $labels = $csv->getRowLabels();
        foreach ($labels as $key => $label) {
          if ($key === 0) {
            $labels[$key] = array_merge([$label], range(1, $nextMonth->daysInMonth));
          } else {
            $labels[$key] = array_merge([$label], array_fill(0, $nextMonth->daysInMonth , "0"));
          }
        }
        $csv->createCSV(sprintf("%02d", $nextMonth->month), $labels);
    }
}
