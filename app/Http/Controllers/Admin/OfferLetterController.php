<?php

namespace App\Http\Controllers\Admin;

// use Barryvdh\DomPDF\PDF;
use App\Models\CFISModel;
use App\Models\OfferLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OfferLetterController extends Controller
{
    public function model()
    {
        return new OfferLetter();
    }

    public function index()
    {
        $searchColumns = ['id', 'emp_name', 'date', 'phone1', 'email'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->with('employee');

        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        if ($search != '') {
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) {
                    $key == 0 ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                }
            });
        }

        if ($order == '') {
            $query->orderByDesc('id');
        } else {
            $query->orderBy($order, $orderBy);
        }

        $offer = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

        return view("admin.adms.offer_letter.index", compact("offer"));
    }
    public function edit($id)
    {
        $employee = $this->model()->findOrFail($id);
        return view("admin.adms.offer_letter.edit", compact('employee'));
    }
    public function generateOfferLetterPdf($id)
    {
        $offerLetter = $this->model()->with('employee')->findOrFail($id);

        $data = [
            'offerLetter' => $offerLetter,
        ];

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'chroot' => public_path()
        ])->loadView('admin.adms.offer_letter.formate', $data);
        // ->setPaper('A4', 'portrait')
        // ->setOptions(['margin-top' => 10, 'margin-bottom' => 10, 'margin-left' => 15, 'margin-right' => 15]);


        return $pdf->stream('offer_letter_' . $offerLetter->id . '.pdf');
    }

    public function destroy($id)
    {
        $this->model()->destroy($id);
        return redirect()->route('admin.offer_letter')->with('success', 'Successfully deleted!');
    }
}
