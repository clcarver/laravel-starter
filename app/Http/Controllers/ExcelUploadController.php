<?php


namespace App\Http\Controllers;


use App\CompletedActivities;
use App\Imports\CompletedActivitiesImport;
use App\Imports\RegistrationImport;
use App\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


class ExcelUploadController extends Controller
{
    public function store(Request $request)
    {
        $run = [];

        foreach ($request->file('dropFiles') as $file) {
            $file->move(storage_path() . '/reports/', $file->getClientOriginalName());
            $run[] = $file->getClientOriginalName();
        }

        foreach ($run as $item) {
            if($item == 'Facilities_Learning_Activity_Completion_Report.xlsx') {
                CompletedActivities::truncate();
                Excel::import(new CompletedActivitiesImport(), storage_path() . '/reports/' . $item);
            }

            if($item == 'Class_Registrations_Report.xlsx') {
                Registration::truncate();
                Excel::import(new RegistrationImport(), storage_path() . '/reports/' . $item);
            }
        }
//        Excel::import(new CompletedActivitiesImport(), asset('reports/Facilities_Learning_Activity_Completion_Report.xlsx'));

        return 'all set';
    }
}
