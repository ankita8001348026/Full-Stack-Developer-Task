<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProjectStatusRequest;
use App\Mail\ApprovalEmail;
use App\Models\Approval;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class ProjectStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $project = $request->project;
        if ($request->ajax()) {
            $limit = $request->length;
            $start = $request->start;
            $query = Approval::where('project_id', $project)->orderBy('id', 'desc');
            $totalFiltered = $query->count();
            $items = $query->offset($start)->limit($limit)->get();

            $data = [];
            if (count($items) > 0) {
                foreach ($items as $key => $item) {
                    $nestedData['title'] =  $item->project->title;
                    $nestedData['note'] =  $item->note ?? 'N/A';
                    if ($item->status == 0) {
                        $nestedData['status'] = '<span class="badge badge-warning p-1">Pending</span>';
                    } elseif ($item->status == 1) {
                        $nestedData['status'] = '<span class="badge badge-success p-1">Approved</span>';
                    } else {
                        $nestedData['status'] = '<span class="badge badge-danger p-1">Rejected</span>';
                    }
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
        return view('backend.project_status.index', compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $project_id = $request->project;
        $status = Approval::where('project_id', $project_id)->orderBy('id', 'desc')->first();
        return view('backend.project_status.create', compact('project_id', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectStatusRequest $request)
    {
        try {
            $approval = new Approval();



            $approval->project_id = $request->project_id;
            $approval->user_id = auth()->user()->id;
            $approval->status = $request->status;
            $approval->note = $request->note;
            $approval->save();
            Mail::to('ankitashit10@gmail.com')->send(new ApprovalEmail($approval));


            return redirect()->route('backend.project-status.index', ['project' => $request->project_id])->with('success', 'Item(s) created successfully.');
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
        $approval = Approval::findOrFail($id);
        return view('backend.project_status.update', compact('approval'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectStatusRequest $request, $id)
    {
        try {
            $approval = Approval::findOrFail($id);
            $approval->user_id = auth()->user()->id;
            $approval->status = $request->status;
            $approval->note = $request->note;
            $approval->save();


            return redirect()->route('backend.project-status.index', ['project' => $approval->project_id])->with('success', 'Item(s) created successfully.');
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
        Approval::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Item(s) deleted successfully.');
    }
}
