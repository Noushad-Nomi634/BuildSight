<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }


    // create a company 
    public function createCompany()
    {
        return view('admin.company.create');
    }



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
            'country' => 'nullable|string|max:100',
            'state_province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',

            'status' => 'required|in:active,inactive',
            'logo' => 'nullable|image|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // upload logo
            if ($request->hasFile('logo')) {
                $validated['logo'] = $request->file('logo')->store('companies/logos', 'public');
            }

            $validated['created_by'] = auth()->id();

            /*
             * 1. Create company FIRST
             */

            /*
             * 2. Create user (company owner/admin user)
             */
            $company = Company::create($validated);
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'] ?? null,
                'password' => Hash::make('12345678'),
                'company_id' => $company->id,
            ]);

            Log::info('company user', [
                'user' => $user,
                'comapny' => $company
            ]);     
            /*
                         * 4. Assign role (Spatie multi-tenant context)
                         */
            setPermissionsTeamId($company->id);

            $role = Role::firstOrCreate([
                'name' => 'company',
                'guard_name' => 'web',

            ]);

            $user->assignRole($role);

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Company created successfully.');

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Company creation failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Something went wrong while creating company.');
        }
    }
}
