<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;
use Throwable;
use Illuminate\Support\Facades\Log;
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

        // dd($projects);

        return view('company.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('company.projects.create');
    }


    public function edit(Project $project)
    {
        $this->authorizeProject($project);

        return view('company.projects.edit', compact('project'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'project_code' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'lat' => 'nullable|numeric|between:-90,90',
            'lng' => 'nullable|numeric|between:-180,180',
            'address_1' => 'nullable|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'state_province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'alerts_email' => 'nullable|email|max:255',
            'status' => 'required|in:active,planning,on_hold,completed,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'ftp_folder' => ['nullable', 'string', 'max:100', 'regex:/^[a-zA-Z0-9_-]+$/'],
        ]);

        try {
            // dd($request->all(), $validated);
            $validated['company_id'] = $this->companyId();
            $validated['created_by'] = auth()->id();

            $project = Project::create($validated);
            // dd($project);
            return redirect()
                ->route('company.projects.index')
                ->with('success', 'Project created successfully.');
        } catch (Throwable $th) {

            Log::error($th->getMessage(), [
                'stacktrace' => $th->getTraceAsString(),
                'error' => $th
            ]);
            return redirect()
                ->route('company.projects.index')
                ->with('success', 'Something went wrong.');
        }
    }

    public function show(Project $project)
    {
        $this->authorizeProject($project);

        return view('company.projects.show', compact('project'));
    }



    public function update(Request $request, Project $project)
    {
        $this->authorizeProject($project);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'project_code' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'lat' => 'nullable|numeric|between:-90,90',
            'lng' => 'nullable|numeric|between:-180,180',
            'address_1' => 'nullable|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'state_province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'alerts_email' => 'nullable|email|max:255',
            'status' => 'required|in:active,planning,on_hold,completed,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'ftp_folder' => 'nullable|string|max:100'
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

    // ── Private ───────────────────────────────────────────────────────────────

    private function authorizeProject(Project $project): void
    {
        // dd($project->company_id == $this->companyId(), $project->company_id, $this->companyId());
        abort_unless(
            $project->company_id === $this->companyId(),
            403,
            'This project does not belong to your company.'
        );
    }
}
