<?php

namespace App\Http\Controllers\Backend;

use Exception;
use App\Models\{User, Area, UserAddress};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CustomerController extends Controller
{
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
            $query = User::type(2)->when(is_numeric($request->status), function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
                ->when($request->query('search_keyword'), function ($query) use ($request) {
                    return $query->where('first_name', 'like', '%' . $request->search_keyword . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search_keyword . '%');
                })
                ->when($request->query('start_date') && $request->query('end_date'), function ($query) use ($request) {
                    return $query->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
                })
                ->orderBy('id', 'desc');
            $totalFiltered = $query->count();
            $items = $query->offset($start)->limit($limit)->get();

            $data = [];
            if (count($items) > 0) {
                foreach ($items as $key => $item) {
                    $nestedData['name'] = $item->first_name . ' ' . $item->middle_name . ' ' . $item->last_name;
                    $nestedData['email'] = $item->email;
                    $nestedData['mobile'] = $item->mobile ?? '-';
                    $nestedData['registered_at'] = Carbon::parse($item->created_at)->format('Y-m-d g:i A');
                    $nestedData['action'] = (string)View::make('backend.customer.action', ['item' => $item])->render();
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
        return view('backend.customer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|numeric|min:10|unique:users,mobile',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password'
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'email.unique' => 'Email should be unique',
            'mobile.required' => 'Mobile is required',
            'mobile.numeric' => 'Mobile is invalid',
            'mobile.min' => 'Mobile must be 10 digits long',
            'mobile.unique' => 'Mobile must be unique',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be 8 characters long',
            'password_confirmation.required' => 'Password confirmation is required',
            'password_confirmation.same' => 'Password confirmation must match password',
            'password_confirmation.min' => 'Password confirmation must be 8 characters long',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('danger', $validator->errors()->first());
        }

        // create user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = $request->password;
        $user->status = 1;
        $user->save();

        // assign role to user
        $user->assignRole('user');

        // login user using user id
        Auth::loginUsingId($user->id);
        return redirect()->route('backend.dashboard')->with('success', 'Item(s) created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('userAddress')->find($id);
        return view('backend.customer.update', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'number' => 'required|numeric|unique:users,mobile,' . $id,
            'gender' => 'required|numeric',
            'status' => 'required|numeric',
        ]);
        try {
            $update = User::findOrFail($id);
            $update->first_name = $request->first_name;
            $update->middle_name = $request->middle_name;
            $update->last_name = $request->last_name;
            $update->mobile = $request->number;
            $update->gender = $request->gender;
            $update->email = $request->email;
            $update->status = $request->status;
            $update->save();

            $user_address = UserAddress::where('user_id', $update->id)->first();
            if (empty($user_address)) {
                $user_address = new UserAddress();
                $user_address->user_id = $update->id;
            }
            $user_address->block = $request->block;
            $user_address->street = $request->street;
            $user_address->house_number = $request->house_number;
            $user_address->apartment = $request->apartment ?? null;
            $user_address->floor = $request->floor;
            $user_address->other = $request->jadda;
            $user_address->save();

            return redirect()->route('backend.customers.index')->with('success', 'Item(s) updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->back()->with('success', 'Item(s) deleted successfully.');
    }
}
