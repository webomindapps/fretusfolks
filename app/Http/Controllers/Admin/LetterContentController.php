<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LetterContent;
use Illuminate\Http\Request;

class LetterContentController extends Controller
{
    public function model()
    {
        return new LetterContent;
    }
    public function index()
    {
        $letter_content = LetterContent::paginate(10);
        return view("admin.ffimasters.letter_content.index",compact("letter_content"));
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
        LetterContent::create([
            'type' => $request->type,
            'letter_type' =>$request->letter_type ,
            'content' => $request->content,
        ]);
        return redirect()->route('admin.letter_content')->with('success', 'Letter Content added successfully');

    }
    public function edit($id)
    {
        $letter_content = $this->model()->find($id);
        return view('admin.ffimasters.letter_content.update', compact('letter_content'));
    }
    public function update(Request $request, $id)
    {
        $letter_content = $this->model()->find($id);
        $letter_content->update([
            'content' => $request->content,
        ]);
        return redirect()->route('admin.letter_content')->with('success','Letter Content Updated successfully');
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
