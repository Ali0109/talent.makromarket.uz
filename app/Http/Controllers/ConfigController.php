<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use App\Models\User;
use App\Services\CsvService;
use Illuminate\Support\Facades\App;

class ConfigController extends Controller
{
    public function changeLang($locale)
    {
        session(['locale' => $locale]);
        App::setlocale($locale);
        return redirect()->back();
    }

    public function add_employees_list()
    {
        $csvFileName = 'list_employees_3.csv';
        $csvFileSrc = public_path('csv/' . $csvFileName);
        $employees = CsvService::readCSV($csvFileSrc, array('delimiter' => ';'));

//        $employee_without_numbers = [];
//        foreach ($employees as $employee) {
//            if(empty($employee[1]) && empty($employee[2]) && empty($employee[3])) {
//                array_push($employee_without_numbers, $employee);
//            }
//        }
//        dd($employee_without_numbers);

        foreach ($employees as $employee) {
            if(empty($employee[1]) && empty($employee[2]) && empty($employee[3])) {
                continue;
            } else {
                $user = User::create([
                    'name' => $employee[0]
                ]);

                if (!empty($employee[1]) && strlen($employee[1]) == 9 && $employee[1] >= 8) {
                    $phone1 = '998' . $employee[1];
                    Phone::create([
                        'number' => $phone1,
                        'user_id' => $user->id,
                    ]);
                }

                if (!empty($employee[2]) && strlen($employee[2]) == 9 && $employee[2] >= 8) {
                    $phone2 = '998' . $employee[2];
                    Phone::create([
                        'number' => $phone2,
                        'user_id' => $user->id,
                    ]);
                }

                if (!empty($employee[3]) && strlen($employee[3]) == 9 && $employee[3] >= 8) {
                    $phone3 = '998' . $employee[3];
                    Phone::create([
                        'number' => $phone3,
                        'user_id' => $user->id,
                    ]);
                }
            }

        }

        dd("OK!");
    }
}
