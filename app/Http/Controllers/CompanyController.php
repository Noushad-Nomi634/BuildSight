<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index()
    {
        setPermissionsTeamId(session('company_id'));

        return view('company.dashbaord');
    }

    // CREATE COMPANY FORM
    public function createCompany()
    {
        $countries = Country::all();

        // Cities using Query Builder (NO MODEL needed)
        $cities = DB::table('cities')->get();

        return view('admin.company.create', compact('countries', 'cities'));
    }

    // STORE COMPANY (optional but usually needed)
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Company::create([
            'name' => $request->name,
            'created_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Company created successfully');
    }
}