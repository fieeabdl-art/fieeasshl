<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProjectStageRequest;
use App\Http\Requests\Admin\UpdateProjectStageRequest;
use App\Http\Resources\Api\ProjectStageResource;
use App\Models\Project;
use App\Models\ProjectStage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AdminProjectStageController extends Controller
{
    public function index(Project $project): JsonResponse
    {
        $stages = $project->stages()->get();

        return response()->json([
            'success' => true,
            'message' => 'Project stages retrieved successfully',
            'data' => ProjectStageResource::collection($stages),
        ]);
    }

    public function store(StoreProjectStageRequest $request, Project $project): JsonResponse
    {
        $data = $request->validated();
        $data['project_id'] = $project->id;
        $data['updated_by'] = Auth::id();

        $stage = ProjectStage::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Project stage created successfully',
            'data' => new ProjectStageResource($stage),
        ], 201);
    }

    public function show(Project $project, ProjectStage $stage): JsonResponse
    {
        $this->ensureStageBelongsToProject($project, $stage);

        return response()->json([
            'success' => true,
            'message' => 'Project stage retrieved successfully',
            'data' => new ProjectStageResource($stage),
        ]);
    }

    public function update(UpdateProjectStageRequest $request, Project $project, ProjectStage $stage): JsonResponse
    {
        $this->ensureStageBelongsToProject($project, $stage);

        $data = $request->validated();
        $data['updated_by'] = Auth::id();

        $stage->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Project stage updated successfully',
            'data' => new ProjectStageResource($stage),
        ]);
    }

    public function destroy(Project $project, ProjectStage $stage): JsonResponse
    {
        $this->ensureStageBelongsToProject($project, $stage);

        $stage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project stage deleted successfully',
        ]);
    }

    protected function ensureStageBelongsToProject(Project $project, ProjectStage $stage): void
    {
        if ($stage->project_id !== $project->id) {
            abort(404, 'Stage not found for this project');
        }
    }
}
