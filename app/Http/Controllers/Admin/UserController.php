<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MuserMaster;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function model()
    {
        return  new MuserMaster;
    }
    public function index()
    {
        $searchColumns = ['id', 'name', 'user_type'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->query();

        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }
        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        // sorting
        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $users = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        return view('admin.ffimasters.usermasters.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.ffimasters.usermasters.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'user_type' => 'required',
                'emp_id' => 'required',
                'name' => 'required',
                'username' => 'required',
                'password' => 'required|same:enc_pass',
                'enc_pass' => 'required',
                'email' => 'required|email|unique:muser_master,email',
            ],
            [
                'password.same' => 'the password and confirm password should be same',

            ]
        );

        DB::beginTransaction();

        try {
            $latestUser = MuserMaster::latest('id')->first();
            $newRefNo = 'FFI' . str_pad(($latestUser ? intval(substr($latestUser->ref_no, 2)) + 1 : 1), 3, '0', STR_PAD_LEFT);

            $user = new MuserMaster();
            $user->user_type = 1;
            $user->emp_id = $request->emp_id;
            $user->name = $request->name;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->enc_pass = Hash::make($request->enc_pass);
            $user->email = $request->email;
            $user->date = now();
            $user->ref_no = $newRefNo;
            $user->status = $request->status ?? 0;
            $user->save();
            $user->assignRole($request->user_type);
            DB::commit();

            return redirect()->route('admin.usermasters')->with('success', 'User Masters added successfully');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function bulk(Request $request)
    {
        $type = $request->type;
        $selectedItems = $request->selectedIds;
        $status = $request->status;

        foreach ($selectedItems as $item) {
            $category = MuserMaster::find($item);
            if ($type == 1) {
                $category->delete();
            } else if ($type == 2) {
                $category->update(['status' => $status]);
            }
        }
        return response()->json([ 'success' => 'Bulk operation is completed']);
    }

    public function edit($id)
    {
        $roles = Role::all();
        $user = MuserMaster::findorfail($id);
        return view('admin.ffimasters.usermasters.edit', compact('roles', 'user'));
    }
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'role' => 'required',
                'emp_id' => 'required',
                'name' => 'required',
                'username' => 'required',
                'email' => 'required',
            ],
        );
        $user = MuserMaster::findOrFail($id);
        $user->update($request->all());
        $user->syncRoles($request->role);
        return redirect()->route('admin.usermasters')->with('success', 'User Masters updated successfully');
    }
    public function delete($id)
    {
        $user = MuserMaster::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.usermasters')->with('success', 'User Masters deleted successfully');
    }
    public function toggleStatus($id)
    {
        $user = $this->model()->findOrFail($id);
        $user->status = !$user->status;
        $user->save();
        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
