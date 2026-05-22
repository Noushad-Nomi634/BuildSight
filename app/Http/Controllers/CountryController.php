<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    /**
     * LIST
     */
    public function index()
    {
        $countries = DB::table('countries')->get();

        return view('countries.index', compact('countries'));
    }

    /**
     * SHOW (VIEW BUTTON FIX)
     */
    public function show($id)
    {
        $country = DB::table('countries')->where('id', $id)->first();

        if (!$country) {
            abort(404);
        }

        return view('countries.show', compact('country'));
    }

    /**
     * CREATE FORM
     */
    public function create()
    {
        return view('countries.create');
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10',
        ]);

        DB::table('countries')->insert([
            'name' => $request->name,
            'code' => $request->code,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('company.countries.index')
            ->with('success', 'Country created successfully');
    }

    /**
     * EDIT FORM
     */
    public function edit($id)
    {
        $country = DB::table('countries')->where('id', $id)->first();

        if (!$country) {
            abort(404);
        }

        return view('countries.edit', compact('country'));
    }

    /**
     * UPDATE
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10',
        ]);

        DB::table('countries')->where('id', $id)->update([
            'name' => $request->name,
            'code' => $request->code,
            'updated_at' => now(),
        ]);

        return redirect()->route('company.countries.index')
            ->with('success', 'Country updated successfully');
    }

    /**
     * DELETE
     */
    public function destroy($id)
    {
        DB::table('countries')->where('id', $id)->delete();

        return redirect()->route('company.countries.index')
            ->with('success', 'Country deleted successfully');
    }
}