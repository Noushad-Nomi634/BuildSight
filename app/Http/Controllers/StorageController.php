<?php

namespace App\Http\Controllers;
use App\Models\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StorageController extends Controller
{
    /**
     * Display all records
     */
    public function index()
    {
        $data = DB::table('storage')->get();
        return view('storage.index', compact('data'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $data = Storage::first();
        return view('storage.create',compact('data'));
    }

    /**
     * Store new record
     */
    public function store(Request $request)
    {

        // Optional validation (recommended)
        $request->validate([
            'ip' => 'nullable|string',
            'server' => 'nullable|string',
            'username' => 'nullable|string',
            'password' => 'nullable|string',
            'path' => 'nullable|string',

        ]);

        DB::table('storage')->insert([
            'ip' => $request->ip(),
            'server' => $request->server('HTTP_HOST'), 
            'username' => $request->username,
            'password' => $request->password,
            'path' => $request->path,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.storage.index')
            ->with('success', 'Record added successfully');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $data = DB::table('storage')->where('id', $id)->first();

        return view('storage.edit', compact('data'));
    }

    /**
     * Update record
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ip' => 'nullable|string',
            'server' => 'nullable|string',
            'username' => 'nullable|string',
            'password' => 'nullable|string',
            'path' => 'nullable|string',
        ]);

        DB::table('storage')->where('id', $id)->update([
            'ip' => $request->ip(),
            'server' => $request->server('HTTP_HOST'),
            'username' => $request->username,
            'password' => $request->password,
            'path' => $request->path,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.storage.index')
            ->with('success', 'Record updated successfully');
    }

    /**
     * Delete record
     */
    public function delete($id)
    {
        DB::table('storage')->where('id', $id)->delete();

        return redirect()->route('admin.storage.index')
            ->with('success', 'Record deleted successfully');
    }
}