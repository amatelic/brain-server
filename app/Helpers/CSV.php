<?php

namespace App\Helpers;
use Carbon\Carbon;
use Excel;
use File;
use Exception;

/**
 * Basic class for working with tasks
 */
class CSV
{
  public $user;
  public $year;
  public $month;
  function __construct($email = null, $year = null, $month = null)
  {
    if (!isset($email)) {
      throw new Exception('You didn\'t include the csv email');
    }

    $this->email = $email;
    $this->year = isset($year) ? sprintf("%02d", $year) : sprintf("%02d", Carbon::now()->year);
    $this->month = isset($year) ? sprintf("%02d", $month) : sprintf("%02d", Carbon::now()->month);
  }

  public function getFilePath()
  {
    return storage_path('app/' . $this->email .'/' . $this->year. '/' . $this->month . '.csv');
  }

  function getRowLabels() {
    $file = $this->getFilePath();
    $ff = File::get($file);
    $col = explode(PHP_EOL, $ff);
    // return count($col);
    $index = count($col) - 1;

    if (empty($col[$index])) {
      unset($col[$index]);
    }

    $labels = [];
    foreach ($col as $key => $row) {
      $label[] = explode(',', $row)[0];
    }
    return $label;

  }

  public function getExelFile()
  {
    if (File::exists($this->getFilePath()))
    {
      return Excel::load($this->getFilePath())->toArray();
    }
    return [[]];
  }

  public function update($index = null, $data = null)
  {
    if (!isset($data) || !isset($index)) {
      throw new Exception('You didn\'t provide an index or data for the csv file');
    }

    $day =  Carbon::now()->day;
    $file = storage_path('/app/' . $this->email . '/' . $this->year . '/' . $this->month . '.csv');
    $ff = File::get($file);
    $col = explode(PHP_EOL, $ff);
    $row = explode(',', $col[$index]);
    $row[$day] = $data['complited'] ? 1 : 0;
    $new_row = implode(',', $row);
    $col[$index] = $new_row;
    File::put($file, implode(PHP_EOL, $col));

  }

  public function addTask($content)
  {
    $file = File::append($this->getFilePath(), $content . PHP_EOL);
    if ($file === false)
    {
        return ['status' => 404];
    }
    return ['status' => 204];
  }

  public function generateCSV($date = null)
  {
    $exel = $this->getExelFile();
    $dayInMonth = Carbon::now()->daysInMonth;
    $header = array_merge(["tasks"], range(1, $dayInMonth));
    $tasks = array_column($exel[0], 'task');
    $csv[0] = $header;
    foreach ($tasks as $key => $value) {
      $csv[] = array_merge([trim($value)], array_fill(0, $dayInMonth, "0"));
    }

    return $csv;
  }

  public function createCSV($name, $data, $config = null)
  {
    Excel::create($name, function($excel) use($data){
      $excel->sheet('Sheetname', function($sheet) use($data){
          $sheet->fromArray($data, null, 'A1', false, false);
      });
    })->store('csv', storage_path('app/' . $this->email . '/' . $this->year));
  }
}
