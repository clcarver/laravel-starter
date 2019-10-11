<?php


namespace App\Http\Controllers;


use App\LmsUser;
use Illuminate\Support\Facades\DB;

class LmsUserController extends Controller
{
    public function index()
    {
        return LmsUser::select([
            'organization',
            'position',
            DB::raw('count(*) as total')
        ])->groupBy(['organization', 'position'])
            ->get()->transform(function($group) {
                return [
                    'organization' => $this->org($group['organization']),
                    'position' => $group['position'],
                    'count' => $group['total']
                ];
            });
    }

    protected function org($org)
    {
        switch ($org) {
            case "SS FAC BUILD SVS":
                return "Building Services";
            case "SS FAC BUSINESS SYS":
                return "Business Systems";
            case "SS FAC CHEM":
                return 'Chems';
            case "SS FAC ELEC":
                return 'Electrical';
            case "SS FAC FAB MECH":
                return 'Mechanical';
            case "SS FAC GAS":
                return 'Gas';
            case "SS FAC I&C":
                return 'IC';
            case "SS FAC MICRO":
                return 'Micro Contamination';
            case "SS FAC PROCESS SYS UPW WWT":
                return 'UPW and Waste Water';
        }
    }
}
