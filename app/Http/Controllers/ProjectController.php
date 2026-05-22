<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProjectController extends Controller
{
    private function companyId(): int
    {
        return session('company_id');
    }

    public function index()
    {
        $projects = Project::where('company_id', $this->companyId())
            ->latest()
            ->paginate(15);

        return view('company.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('company.projects.create');
    }

    public function store(Request $request)
    {

    
        // ✅ FIX: empty string handling
        $request->merge([
            'lat' => $request->lat === '' ? null : $request->lat,
            'lng' => $request->lng === '' ? null : $request->lng,
            'start_date' => $request->start_date ?: null,
            'end_date' => $request->end_date ?: null,
            'ftp_folder' => $request->ftp_folder ?: null,
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'project_code' => 'nullable|string|max:100',
            'description' => 'nullable|string',

            // LOCATION
            'lat' => 'nullable|numeric|between:-90,90',
            'lng' => 'nullable|numeric|between:-180,180',

            'address_1' => 'nullable|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'state_province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',

            // DATES
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',

            'alerts_email' => 'nullable|email|max:255',

            // STATUS (MATCH YOUR BLADE)
            'status' => 'required|in:active,inactive',

            'priority' => 'required|in:low,medium,high,urgent',

            // FTP (FIXED - NO REGEX ISSUE)
            'ftp_folder' => 'nullable|string|max:100',
        ]);

        try {
            $validated['company_id'] = $this->companyId();
            $validated['created_by'] = auth()->id();

            Project::create($validated);

            return redirect()
                ->route('company.projects.index')
                ->with('success', 'Project created successfully.');

        } catch (Throwable $th) {

            Log::error('Project Create Error: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);

            return redirect()
                ->route('company.projects.index')
                ->with('error', 'Something went wrong.');
        }
    }

   

    public function show(Project $project)
{
            $this->authorizeProject($project);

    $project->load(['cameras', 'members']);
 
    return view('company.projects.show', compact('project'));
}

    public function edit(Project $project)
    {
        $this->authorizeProject($project);
        return view('company.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorizeProject($project);

        // ✅ FIX: empty string handling
        $request->merge([
            'lat' => $request->lat === '' ? null : $request->lat,
            'lng' => $request->lng === '' ? null : $request->lng,
            'start_date' => $request->start_date ?: null,
            'end_date' => $request->end_date ?: null,
            'ftp_folder' => $request->ftp_folder ?: null,
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'project_code' => 'nullable|string|max:100',
            'description' => 'nullable|string',

            // LOCATION
            'lat' => 'nullable|numeric|between:-90,90',
            'lng' => 'nullable|numeric|between:-180,180',

            'address_1' => 'nullable|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'state_province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',

            // DATES
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',

            'alerts_email' => 'nullable|email|max:255',

            // STATUS (MATCH BLADE)
           'status' => 'required|in:active,inactive,on_hold,planning,completed,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',

            // FTP FIXED
            'ftp_folder' => 'nullable|string|max:100',
        ]);

        $project->update($validated);

        return redirect()
            ->route('company.projects.show', $project)
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $this->authorizeProject($project);

        $project->delete();

        return redirect()
            ->route('company.projects.index')
            ->with('success', 'Project deleted.');
    }

    private function authorizeProject(Project $project): void
    {
        abort_unless(
            $project->company_id === $this->companyId(),
            403,
            'This project does not belong to your company.'
        );
    }
}