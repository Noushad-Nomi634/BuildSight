<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CameraController extends Controller
{
    /*
    |--------------------------------------------------
    | 📌 1. INDEX - All Cameras List
    |--------------------------------------------------
    */
    public function index()
    {
        $cameras = DB::table('cameras')
            ->join('projects', 'cameras.project_id', '=', 'projects.id')
            ->select(
                'cameras.*',
                'projects.name as project_name'
            )
            ->orderByDesc('cameras.id')
            ->get();

        return view('company.cameras.index', compact('cameras'));
    }

    /*
    |--------------------------------------------------
    | 📌 2. SHOW - Single Camera Detail
    |--------------------------------------------------
    */
    public function show($id)
    {
        $camera = DB::table('cameras')
            ->join('projects', 'cameras.project_id', '=', 'projects.id')
            ->select(
                'cameras.*',
                'projects.name as project_name'
            )
            ->where('cameras.id', $id)
            ->first();

        if (!$camera) {
            return redirect()->route('company.cameras.index')
                ->with('error', 'Camera not found!');
        }

        return view('company.cameras.show', compact('camera'));
    }

    /*
    |--------------------------------------------------
    | 📌 3. STORE - Add New Camera
    |--------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'project_id'   => 'required|exists:projects,id',
            'name'         => 'required|string|max:255',
            'ip_address'   => 'nullable|string',
            'port'         => 'nullable|numeric',
            'username'     => 'nullable|string',
            'password'     => 'nullable|string',
            'snapshot_url' => 'nullable|string',
            'upload_method'=> 'nullable|string',
            'is_active'    => 'nullable|boolean',
        ]);

        // safe whitelist
        $allowedMethods = ['ftp', 'http', 'onvif'];

        $uploadMethod = in_array($request->upload_method, $allowedMethods)
            ? $request->upload_method
            : 'ftp';

        DB::table('cameras')->insert([
            'project_id'   => $request->project_id,
            'name'         => $request->name,
            'ip_address'   => $request->ip_address,
            'port'         => $request->port ?? 80,
            'username'     => $request->username,
            'password'     => $request->password,
            'snapshot_url' => $request->snapshot_url,
            'upload_method'=> $uploadMethod,
            'is_active'    => $request->is_active ?? 0,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return redirect()->back()->with('success', 'Camera added successfully!');
    }

    /*
    |--------------------------------------------------
    | 📌 4. EDIT - Edit Form
    |--------------------------------------------------
    */
    public function edit($id)
    {
        $camera = DB::table('cameras')->where('id', $id)->first();

        if (!$camera) {
            return redirect()->route('company.cameras.index')
                ->with('error', 'Camera not found!');
        }

        $projects = DB::table('projects')->get();

        return view('company.cameras.edit', compact('camera', 'projects'));
    }

    public function create()
{
    $projects = DB::table('projects')->get();

    return view('company.cameras.create', compact('projects'));
}

    /*
    |--------------------------------------------------
    | 📌 5. UPDATE - Save Edited Camera
    |--------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $camera = DB::table('cameras')->where('id', $id)->first();

        if (!$camera) {
            return redirect()->route('company.cameras.index')
                ->with('error', 'Camera not found!');
        }

        DB::table('cameras')->where('id', $id)->update([
            'name'         => $request->name,
            'ip_address'   => $request->ip_address,
            'port'         => $request->port,
            'username'     => $request->username,
            'password'     => $request->password,
            'snapshot_url' => $request->snapshot_url,
            'upload_method'=> $request->upload_method,
            'is_active'    => $request->is_active ?? 0,
            'updated_at'   => now(),
        ]);

        return redirect()->route('company.cameras.index')
            ->with('success', 'Camera updated successfully!');
    }

    /*
    |--------------------------------------------------
    | 📌 6. DESTROY - Delete Camera
    |--------------------------------------------------
    */
    public function destroy($id)
    {
        $camera = DB::table('cameras')->where('id', $id)->first();

        if (!$camera) {
            return redirect()->back()->with('error', 'Camera not found!');
        }

        DB::table('cameras')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Camera deleted successfully!');
    }
}