<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function index()
    {
        $cities = DB::table('cities')
            ->join('countries', 'cities.country_id', '=', 'countries.id')
            ->select('cities.*', 'countries.name as country_name')
            ->get();

        return view('cities.index', compact('cities'));
    }

    public function create()
    {
        $countries = DB::table('countries')->get();
        return view('cities.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country_id' => 'required'
        ]);

        DB::table('cities')->insert([
            'name' => $request->name,
            'country_id' => $request->country_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('cities.index')->with('success', 'City created');
    }

    public function edit($id)
    {
        $city = DB::table('cities')->where('id', $id)->first();
        $countries = DB::table('countries')->get();

        return view('cities.edit', compact('city', 'countries'));
    }

    public function update(Request $request, $id)
    {
        DB::table('cities')->where('id', $id)->update([
            'name' => $request->name,
            'country_id' => $request->country_id,
            'updated_at' => now(),
        ]);

        return redirect()->route('cities.index')->with('success', 'City updated');
    }

    public function destroy($id)
    {
        DB::table('cities')->where('id', $id)->delete();
        return back()->with('success', 'City deleted');
    }
}