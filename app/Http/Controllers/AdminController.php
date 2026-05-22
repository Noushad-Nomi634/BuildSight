<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use App\Models\Camera;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /*
    |-----------------------------------------
    | DASHBOARD
    |-----------------------------------------
    */
    public function index()
    {
        $totalCameras = Camera::count();
        $totalProjects = Project::count();
        $totalCompanies = Company::count();

        $companies = Company::latest()->get();
        $projects = Project::latest()->get();

        return view('admin.dashboard', compact(
            'totalCameras',
            'totalProjects',
            'totalCompanies',
            'companies',
            'projects'
        ));
    }

    /*
    |-----------------------------------------
    | COMPANY LIST PAGE
    |-----------------------------------------
    */
    public function listCompany()
    {
        $companies = Company::latest()->get();

        $totalCompanies = Company::count();
        $totalProjects = Project::count();
        $totalCameras = Camera::count();

        return view('admin.company.index', [
            'companies' => $companies,
            'totalCompanies' => $totalCompanies,
            'totalProjects' => $totalProjects,
            'totalCameras' => $totalCameras,
        ]);
    }

    /*
    |-----------------------------------------
    | CREATE COMPANY PAGE
    |-----------------------------------------
    */
    public function createCompany()
    {
        return view('admin.company.create');
    }

    /*
    |-----------------------------------------
    | STORE COMPANY
    |-----------------------------------------
    */
    public function storeCompany(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['nullable', 'max:255'],
            'phone' => ['nullable', 'regex:/^\+?[0-9]{7,15}$/'],
            'mobile' => ['nullable', 'regex:/^\+[1-9][0-9]{7,14}$/'],
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'address_1' => 'nullable|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'country_id' => 'nullable|exists:countries,id',
            'state_province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
            'logo' => 'nullable|image|max:2048',
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('logo')) {
                $validated['logo'] = $request->file('logo')->store('companies/logos', 'public');
            }

            $validated['created_by'] = auth()->id();

            $company = Company::create($validated);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'] ?? null,
                'password' => Hash::make('12345678'),
                'company_id' => $company->id,
            ]);

            Log::info('Company created', [
                'user' => $user,
                'company' => $company
            ]);

            setPermissionsTeamId($company->id);

            $role = Role::firstOrCreate([
                'name' => 'company',
                'guard_name' => 'web',
            ]);

            $user->assignRole($role);

            DB::commit();

            return redirect()->route('admin.company.index')
                ->with('success', 'Company created successfully.');

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Company creation failed', [
                'message' => $e->getMessage()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong.');
        }
    }

    /*
    |-----------------------------------------
    | SHOW COMPANY
    |-----------------------------------------
    */
    public function show($id)
    {
        $company = Company::findOrFail($id);
        return view('admin.company.show', compact('company'));
    }

    /*
    |-----------------------------------------
    | EDIT COMPANY
    |-----------------------------------------
    */
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('admin.company.edit', compact('company'));
    }

    /*
    |-----------------------------------------
    | UPDATE COMPANY (EMPTY FOR NOW)
    |-----------------------------------------
    */
    public function update(Request $request, $id)
    {
        // update logic here later
    }

    /*
    |-----------------------------------------
    | DELETE COMPANY
    |-----------------------------------------
    */
    public function destroy($id)
    {
        Company::where('id', $id)->delete();

        return redirect()->back()
            ->with('success', 'Company deleted successfully.');
    }
}