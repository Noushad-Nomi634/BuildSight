<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
class CompanyController extends Controller
{
    public function index()
    {
        setPermissionsTeamId(session('company_id'));

        // Auth::user()->getRoleNames()
        return view('company.dashbaord');
    }


}
