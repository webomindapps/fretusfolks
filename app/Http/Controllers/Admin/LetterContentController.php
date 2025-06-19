<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\LetterContent;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LetterContentController extends Controller
{
    public function model()
    {
        return new LetterContent;
    }
    public function index()
    {
        $searchColumns = ['id', 'type', 'letter_type'];
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

        $letter_content = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(100)->appends(request()->query());
        return view("admin.ffimasters.letter_content.index", compact("letter_content"));
    }
    public function create()
    {
        return view("admin.ffimasters.letter_content.create");

    }
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'letter_type' => 'required',
            'content' => 'required',

        ]);
        DB::beginTransaction();
        try {
            $this->model()->create([
                'type' => $request->type,
                'letter_type' => $request->letter_type,
                'content' => $request->content,
            ]);
            DB::commit();

            return redirect()->route('admin.letter_content')->with('success', 'Letter Content added successfully');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function edit($id)
    {
        $letter_content = $this->model()->find($id);
        return view('admin.ffimasters.letter_content.update', compact('letter_content'));
    }
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $letter_content = $this->model()->find($id);
            $letter_content->update([
                'content' => $request->content,
            ]);
            DB::commit();

            return redirect()->route('admin.letter_content')->with('success', 'Letter Content Updated successfully');
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
            $tds_code = $this->model()->find($item);
            if ($type == 1) {
                $tds_code->delete();
            } else if ($type == 2) {
                $tds_code->update(['status' => $status]);
            }
        }
        return response()->json(['success' => true, 'message' => 'Bulk operation is completed']);
    }
}
