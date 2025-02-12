<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\HRMasters;
use App\Models\MuserMaster;
use Illuminate\Http\Request;
use App\Models\ClientManagement;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function model()
    {
        return new MuserMaster;
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
                foreach ($searchColumns as $key => $value)
                    ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        // sorting
        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $users = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        return view('admin.ffimasters.usermasters.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $clients = ClientManagement::all();

        return view('admin.ffimasters.usermasters.create', compact('roles', 'clients'));
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
            $latestUser = $this->model()->latest('id')->first();
            $newRefNo = 'FFI' . str_pad(($latestUser ? intval(substr($latestUser->ref_no, 2)) + 1 : 1), 3, '0', STR_PAD_LEFT);

            $user = $this->model()->create([
                'user_type' => 1,
                'emp_id' => $request->emp_id,
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'enc_pass' => Hash::make($request->enc_pass),
                'email' => $request->email,
                'date' => now(),
                'ref_no' => $newRefNo,
                'status' => $request->status ?? 0,
            ]);
            $user->assignRole($request->user_type);


            if ($request['user_type'] === 'HR Operations') {
                $selectedClients = $request->input('clients', []);

                foreach ($selectedClients as $clientId) {
                    HRMasters::create([
                        'user_id' => $user->id,
                        'client_id' => $clientId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
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
            $category = $this->model()->find($item);
            if ($type == 1) {
                $category->delete();
            } else if ($type == 2) {
                $category->update(['status' => $status]);
            }
        }
        return response()->json(['success' => 'Bulk operation is completed']);
    }

    public function edit($id)
    {
        $roles = Role::all();
        $user = $this->model()->findorfail($id);
        $clients = ClientManagement::all();
        $assignedClients = HRMasters::where('user_id', $user->id)
            ->pluck('client_id')
            ->toArray();

        return view('admin.ffimasters.usermasters.edit', compact('roles', 'user', 'clients', 'assignedClients'));
    }
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'role' => 'required',
                'emp_id' => 'required',
                'name' => 'required',
                'username' => 'required',
                'email' => 'required|email',
            ]
        );

        $user = MuserMaster::findOrFail($id);

        $user->update([
            'emp_id' => $request->emp_id,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        $user->syncRoles($request->role);

        if ($request->role === 'HR Operations') {
            HRMasters::where('user_id', $user->id)->delete();

            $selectedClients = $request->input('clients', []);
            foreach ($selectedClients as $clientId) {
                HRMasters::create([
                    'user_id' => $user->id,
                    'client_id' => $clientId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } else {
            HRMasters::where('user_id', $user->id)->delete();
        }

        return redirect()->route('admin.usermasters')->with('success', 'User Masters updated successfully');
    }
    public function delete($id)
    {
        $user = $this->model()->findOrFail($id);
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
