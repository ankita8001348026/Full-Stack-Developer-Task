<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProjectRequest;
use App\Mail\ApprovalEmail;
use App\Models\Approval;
use App\Models\Project;
use App\Traits\ImageUploadTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $limit = $request->length;
            $start = $request->start;
            $query = Project::when(function ($query) {
                if (auth()->user()->hasRole('user')) {
                    return $query->where('user_id', auth()->id());
                }
            })->orderBy('id', 'desc');
            // Filter by start & end date
            if ($request->start_date && $request->end_date) {
                $query->whereBetween('created_at', [
                    $request->start_date,
                    $request->end_date
                ]);
            }

            // Filter by project status (from approval table)
            if ($request->project_status !== null && $request->project_status !== '') {
                $query->whereHas('approval', function ($q) use ($request) {
                    $q->where('status', $request->project_status);
                });
            }

            // Filter by submitter (user name/email)
            if ($request->submitter) {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->submitter . '%')
                        ->orWhere('email', 'like', '%' . $request->submitter . '%');
                });
            }
            $totalFiltered = $query->count();
            $items = $query->offset($start)->limit($limit)->get();

            $data = [];
            if (count($items) > 0) {
                foreach ($items as $key => $item) {
                    $nestedData['image'] = '<img src="' . asset('storage/' . $item->image) . '" class="type-1">';
                    $nestedData['title'] = $item->title;
                    if ($item->status == 1) {
                        $nestedData['status'] = '<span class="badge badge-success p-1">Active</span>';
                    } else {
                        $nestedData['status'] = '<span class="badge badge-danger p-1">Inactive</span>';
                    }
                    $nestedData['action'] = (string)View::make('backend.project.action', ['item' => $item])->render();
                    $data[$key] = $nestedData;
                }
            }

            $json_data = [
                'draw' => $request->query('draw'),
                'recordsTotal' => count($data),
                'recordsFiltered' => $totalFiltered,
                'data' => $data
            ];
            return response()->json($json_data);
        }
        return view('backend.project.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        try {
            $project = new Project();

            if (!empty($request->image)) {
                $project->image = $this->uploadFile([
                    'image' => $request->image,
                    'path' => 'images/project',
                    'save_path' => 'images/project'
                ]);
            }

            $project->title = $request->title;
            $project->description = $request->description;
            $project->status = $request->status;
            $project->save();
            $status = new Approval();
            $status->project_id = $project->id;
            $status->user_id = $project->user_id;
            $status->status = 0;
            $status->save();
            Mail::to('ankitashit10@gmail.com')->send(new ApprovalEmail($status));

            return redirect()->route('backend.project.index')->with('success', 'Item(s) created successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('backend.project.update', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, $id)
    {
        try {
            $project = Project::findOrFail($id);

            if (!empty($request->image)) {
                $project->image = $this->uploadFile([
                    'image' => $request->image,
                    'path' => 'images/project',
                    'save_path' => 'images/project',
                    'old_image' => $project->image
                ]);
            }

            $project->title = $request->title;
            $project->description = $request->description;
            $project->status = $request->status;
            $project->save();
            $status = Approval::where('project_id', $project->id)->orderBy('id', 'desc')->first();

            Mail::to('ankitashit10@gmail.com')->send(new ApprovalEmail($status));


            return redirect()->route('backend.project.index')->with('success', 'Item(s) updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Project::findOrFail($id)->delete();
        Approval::where('project_id', $id)->delete();
        return redirect()->back()->with('success', 'Item(s) deleted successfully.');
    }
}
