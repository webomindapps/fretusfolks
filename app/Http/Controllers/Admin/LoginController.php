<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\CFISModel;
use App\Models\CMSLabour;
use App\Models\FHRMSModel;
use Illuminate\Http\Request;
use App\Models\ClientManagement;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\HRMasters;
use App\Models\OfferLetter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.auth.login', compact('roles'));
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            if (auth()->user()->status != 0) {
                Auth::guard('web')->logout();
                return back()->with('danger', 'User is not active');
            }
            if (auth()->user()->hasRole($request->role)) {
                return to_route('admin.dashboard')->with('success', 'You have successfully logged in.');
            }
            return back()->with('danger', 'User is not active');
        }
        return back()->with('danger', 'Invalid credentials.');
    }
        public function dashboard(Request $request)
        {
            $userRole = Auth::user()->getRoleNames()->first();
            $today = Carbon::today();
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            if ($from_date && $to_date) {
                // $cdms = ClientManagement::whereBetween('modify_by', [$from_date, $to_date])->count();
                $active_cdms = ClientManagement::whereBetween('modify_by', [$from_date, $to_date])->where('active_status', '0')->count();
                $inactive_cdms = ClientManagement::whereBetween('modify_by', [$from_date, $to_date])->where('active_status', '1')->count();
                $fhrms = FHRMSModel::whereBetween('modified_date', [$from_date, $to_date])->count();
                $cfis = CFISModel::whereBetween('created_at', [$from_date, $to_date])->groupBy('client_id')->get();
                $clients = ClientManagement::whereBetween('modify_date', [$from_date, $to_date])->with(['client' => function ($query) {
                    $query->select('id', 'client_id', 'status');
                }])->get();
                $labour = CMSLabour::whereBetween('created_at', [$from_date, $to_date])->groupBy('client_id')->get();
            } else {
                $cdms = ClientManagement::all();
                $active_cdms = ClientManagement::where('active_status', '0')->count();
                $inactive_cdms = ClientManagement::where('active_status', '1')->count();
                $fhrms = FHRMSModel::all();
                // $cfis = CFISModel::with('client')->distinct('client_id')->get();
                $clients = ClientManagement::with(['client' => function ($query) {
                    $query->select('id', 'client_id', 'status');
                }])->get();;
                $labour = CMSLabour::with('client', 'state')->distinct('client_id')->get();
            }
            $birthdays = FHRMSModel::whereMonth('dob', '>=', $today->month)
                ->whereYear('dob', '<=', $today->year)
                ->orderByRaw("MONTH(dob), DAY(dob)")
                ->limit(5)
                ->get();

            $hr = HRMasters::where('user_id', Auth::user()->id)->get();
            $offerlettercount = 0;
            $esicNumbers = 0;
            $uanNumbers = 0;
            if ($hr) {
                foreach ($hr as $hrs)
                    $offerlettercount = OfferLetter::
                        whereIn('company_id', function ($query) use ($hrs) {
                            $query->select('client_id')
                                ->from('hr_masters')
                                ->where('client_id', $hrs->client_id);
                        })
                        ->count();
            }

            if ($hr) {
                foreach ($hr as $hrs)
                    $esicNumbers = CFISModel::whereIn('client_id', function ($query) {
                            $query->select('client_id')
                                ->from('hr_masters')
                                ->where('user_id', Auth::id());
                        })
                        ->pluck('esic_no')->count();
            }
            $onboardingCount = CFISModel::where('hr_approval', 1)
                ->where('comp_status', 1)
                ->whereIn('client_id', function ($query) {
                    $query->select('client_id')
                        ->from('hr_masters')
                        ->where('user_id', Auth::id());
                })
                ->count();
            if ($hr) {
                foreach ($hr as $hrs)
                    $uanNumbers = CFISModel::whereIn('client_id', function ($query) {
                            $query->select('client_id')
                                ->from('hr_masters')
                                ->where('user_id', Auth::id());
                        })
                        ->pluck('uan_no')->count();
            }

            $pendingdocumentscount = CFISModel::whereIn('hr_approval', [0, 2])
                ->whereIn('client_id', function ($query) {
                    $query->select('client_id')
                        ->from('hr_masters')
                        ->where('user_id', Auth::id()); // Filter by logged-in HR
                })->count();

            $hrtotalclients = ClientManagement::whereIn('id', function ($query) {
                $query->select('client_id')
                    ->from('hr_masters')
                    ->where('user_id', Auth::id());
            })->count();

            $hractiveclient = ClientManagement::where('active_status', 0)
                ->wherein('id', function ($query) {
                    $query->select('client_id')
                        ->from('hr_masters')
                        ->where('user_id', Auth::id());
                })->count();
            $hrinactiveclient = ClientManagement::where('active_status', 1)
                ->wherein('id', function ($query) {
                    $query->select('client_id')
                        ->from('hr_masters')
                        ->where('user_id', Auth::id());
                })->count();

            $hrclients = ClientManagement::whereIn('id', function ($query) {
                $query->select('client_id')
                    ->from('hr_masters')
                    ->where('user_id', Auth::id());
            })->with('client')->get();


            $hrclients->each(function ($client) {
                $client->active_employees = $client->client->where('status', 1)->count();
                $client->inactive_employees = $client->client->where('status', 0)->count();
            });
            return view('admin.dashboard', compact('active_cdms', 'inactive_cdms', 'fhrms', 'clients', 'birthdays', 'labour', 'userRole', 'offerlettercount', 'esicNumbers', 'onboardingCount', 'uanNumbers', 'pendingdocumentscount', 'hrtotalclients', 'hractiveclient', 'hrinactiveclient', 'hrclients'));
        }
    public function logout()
    {
        Auth::logout();
        return to_route('admin.login');
    }
}
