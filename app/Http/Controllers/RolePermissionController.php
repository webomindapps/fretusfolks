<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function model()
    {
        return new Role;
    }
    public function index()
    {
        $searchColumns = ['id', 'name'];
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

        $roles = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

        return view("admin.roles.index", compact("roles"));
    }
}
