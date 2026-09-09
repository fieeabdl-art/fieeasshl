<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Workflow;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkflowController extends Controller
{
    public function index(): View
    {
        $workflows = Workflow::query()
            ->orderBy('step')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.workflows.index', compact('workflows'));
    }

    public function create(): View
    {
        return view('admin.workflows.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'step' => ['required', 'integer', 'min:1'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        Workflow::create($validated);

        return redirect()
            ->route('admin.workflows.index')
            ->with('success', 'Alur kerja berhasil ditambahkan.');
    }

    public function edit(Workflow $workflow): View
    {
        return view('admin.workflows.edit', compact('workflow'));
    }

    public function update(
        Request $request,
        Workflow $workflow
    ): RedirectResponse {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'step' => ['required', 'integer', 'min:1'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        $workflow->update($validated);

        return redirect()
            ->route('admin.workflows.index')
            ->with('success', 'Alur kerja berhasil diperbarui.');
    }

    public function destroy(Workflow $workflow): RedirectResponse
    {
        $workflow->delete();

        return redirect()
            ->route('admin.workflows.index')
            ->with('success', 'Alur kerja berhasil dihapus.');
    }
}
