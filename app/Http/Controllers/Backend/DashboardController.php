<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\Order;
use App\Models\Package;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{

    public function __construct() {}


    public function dashboard(Request $request)
    {
        $data['total_projects'] = Project::where('status', 1)->count();
        $data['total_projects_percent'] = $data['total_projects'] > 0
            ? round(($data['total_projects'] / $data['total_projects']) * 100, 2)
            : 0;
        $data['pending_projects'] = Approval::where('status', 0)->count();
        $data['pending_projects_percent'] = $data['pending_projects'] > 0
            ? round(($data['pending_projects'] / $data['total_projects']) * 100, 2)
            : 0;
        $data['approved_projects'] = Approval::where('status', 1)->count();
        $data['approved_projects_percent'] = $data['approved_projects'] > 0
            ? round(($data['approved_projects'] / $data['total_projects']) * 100, 2)
            : 0;
        $data['rejected_projects'] = Approval::where('status', 2)->count();
        $data['rejected_projects_percent'] = $data['rejected_projects'] > 0
            ? round(($data['rejected_projects'] / $data['total_projects']) * 100, 2)
            : 0;


        if ($request->ajax()) {
            $limit = $request->length;
            $start = $request->start;
            $query = Project::with('user', 'approval')->when(function ($query) {
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
                    $nestedData['id'] = $item->id;
                    $nestedData['title'] = $item->title;
                    $nestedData['submitter'] = "Name: " . $item->user->name . "<br>Email: " . $item->user->email . "<br>Phone: " . $item->user->mobile;
                    $nestedData['submission_date'] = $item->created_at->format('d-m-Y');
                    if ($item->approval[0]['status'] == 1) {
                        $nestedData['status'] = '<span class="badge badge-success p-1">Approved</span>';
                    } elseif ($item->approval[0]['status'] == 2) {
                        $nestedData['status'] = '<span class="badge badge-danger p-1">Rejected</span>';
                    } else {
                        $nestedData['status'] = '<span class="badge badge-warning p-1">Pending</span>';
                    }
                    $nestedData['last_updated_timestamp'] = $item->approval[0]['updated_at']->format('d-m-Y');
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
        return view('backend.dashboard.dashboard', compact('data'));
    }
}
