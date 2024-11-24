<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Country;
use Carbon\Carbon;

class CountriesSeeder extends BaseSeeder
{
    //use WithoutModelEvents;

    /**
     * @return void
     * @throw \RuntimeException
     */
    public function run(): void
    {
        try {
            Country::truncate();
            $file = database_path('countries.csv');
            $handle = fopen($file, 'r');
            $countries = [];
            while (($row = fgetcsv($handle)) !== false) {
                $countries[$row[1]]['name'] = $row[0];
                $countries[$row[1]]['code'] = $row[1];
                $countries[$row[1]]['created_at'] = Carbon::now();
                $countries[$row[1]]['updated_at'] = Carbon::now();
            }
            fclose($handle);
            \DB::table('countries')->insert($countries);
        } catch (\RuntimeException $exception) {
            $this->error($exception->getMessage());
        }
    }
}
