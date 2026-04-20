<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Mail\ApprovalEmail;
use App\Models\Approval;
use App\Models\Project;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    use ImageUploadTrait;

    public function list(Request $request)
    {
        $projects = Project::when(function ($query) {
            if (auth()->user()->hasRole('user')) {
                return $query->where('user_id', auth()->id());
            }
        })->get();
        $data['projects'] = ProjectResource::collection($projects);
        return response()->json(['status' => 'success', 'msg' => 'Item(s) fetched successfully.', 'data' => $data]);
    }

    public function store(Request $request)
    {
        $create = new Project();
        if (!empty($request->image)) {
            $create->image = $this->base64([
                'image' => $request->image,
                'path' => 'public/images/project',
                'save_path' => 'images/project'
            ]);
        }

        $create->title = $request->title;
        $create->description = $request->description;
        $create->status = $request->status;
        $create->save();

        $status = new Approval();
        $status->project_id = $create->id;
        $status->user_id = $create->user_id;
        $status->status = 0;
        $status->save();

        Mail::to('ankitashit10@gmail.com')->queue(new ApprovalEmail($status));

        return response()->json(['status' => 'success', 'msg' => 'Item(s) created successfully.', 'data' => null]);
    }

    public function edit($id)
    {
        $project = Project::find($id);
        $data['project'] = new ProjectResource($project);
        return response()->json(['status' => 'success', 'msg' => 'Item(s) fetched successfully.', 'data' => $data]);
    }

    public function update(Request $request)
    {
        $update = Project::find($request->id);
        if (!empty($request->image)) {
            $image = $this->base64([
                'image' => $request->image,
                'path' => 'public/images/project',
                'save_path' => 'images/project',
                'old_image' => $update->image
            ]);
            $update->image = $image;
        }

        $update->title = $request->title;
        $update->description = $request->description;
        $update->status = $request->status;
        $update->save();

        $status = Approval::where('project_id', $update->id)->orderBy('id', 'desc')->first();
        Mail::to('ankitashit10@gmail.com')->queue(new ApprovalEmail($status));

        return response()->json(['status' => 'success', 'msg' => 'Item(s) updated successfully.', 'data' => null]);
    }

    public function destroy(Request $request, $id)
    {
        $project = Project::find($id);
        Storage::disk('public')->delete($project->image);
        $project->delete();
        return response()->json(['status' => 'success', 'msg' => 'Item(s) deleted successfully.', 'data' => null]);
    }
}
