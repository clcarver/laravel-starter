<?php


namespace App\Http\Controllers;


use App\Assignments;
use App\Catalog;
use App\CompletedActivities;
use App\Exception;
use App\Imports\AssignmentImport;
use App\Imports\CatalogImport;
use App\Imports\CompletedActivitiesImport;
use App\Imports\ExceptionImport;
use App\Imports\LmsUserImport;
use App\Imports\RegistrationImport;
use App\LmsUser;
use App\Registration;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ExcelUploadController extends Controller
{
    public function store(Request $request)
    {
        $run = [];

        foreach ($request->file('dropFiles') as $file) {
            $file->move(storage_path() . '/reports/', $file->getClientOriginalName());
            $run[] = $file->getClientOriginalName();
            $test[$file->getClientOriginalName()] = $file;
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

            if($item == 'Employee_Data_Report.xlsx') {
                LmsUser::truncate();
                Excel::import(new LmsUserImport(), storage_path() . '/reports/' . $item);
            }

            if($item == 'Activity_Assignment_Report.xlsx') {
                Assignments::truncate();
                Excel::import(new AssignmentImport(), storage_path() . '/reports/' . $item);
            }

            if($item == 'Exception_Report.xlsx') {
                Exception::truncate();
                Excel::import(new ExceptionImport(), storage_path() . '/reports/' . $item);
            }

            if($item == 'All Courses.xlsx') {
                Catalog::truncate();
                Excel::import(new CatalogImport(), storage_path() . '/reports/' . $item);
            }
        }
//        Excel::import(new CompletedActivitiesImport(), asset('reports/Facilities_Learning_Activity_Completion_Report.xlsx'));

        return 'all set';
    }
}
