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
        $user = Auth::user();
        $userRole = $user->getRoleNames()->first();
        $today = Carbon::today();

        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $dateFilter = $from_date && $to_date;

        $hrClients = HRMasters::where('user_id', $user->id)->pluck('client_id');

        $clientQuery = ClientManagement::with('client:id,client_id,status');

        if ($dateFilter) {
            $clientQuery->whereBetween('modify_date', [$from_date, $to_date]);
        }

        $clients = $clientQuery->get();
        $clientStats = $clientQuery->selectRaw("
            SUM(active_status = 0) as active_count,
            SUM(active_status = 1) as inactive_count
        ")->first();

        $fhrmsQuery = FHRMSModel::query();
        if ($dateFilter) {
            $fhrmsQuery->whereBetween('modified_date', [$from_date, $to_date]);
        }
        $fhrms = $fhrmsQuery->count();

        $cfisQuery = CFISModel::query();
        if ($dateFilter) {
            $cfisQuery->whereBetween('created_at', [$from_date, $to_date]);
        }
        $cfis = $cfisQuery->select('client_id')->distinct()->get();

        $labourQuery = CMSLabour::with('client', 'state');
        if ($dateFilter) {
            $labourQuery->whereBetween('created_at', [$from_date, $to_date]);
        }
        $labour = $labourQuery->selectRaw('client_id, MAX(id) as labour_group')->groupBy('client_id')->get();

        // Upcoming Birthdays
        $birthdays = FHRMSModel::whereMonth('dob', '>=', $today->month)
            ->whereYear('dob', '<=', $today->year)
            ->orderByRaw("MONTH(dob), DAY(dob)")
            ->limit(5)
            ->get();

        // HR Specific Data (Using Single CFIS Query)
        $cfisHRQuery = CFISModel::whereIn('client_id', $hrClients);

        $offerlettercount = OfferLetter::whereIn('company_id', $hrClients)->count();
        $esicNumbers = $cfisHRQuery->distinct('esic_no')->count();
        $uanNumbers = $cfisHRQuery->distinct('uan_no')->count();
        $onboardingCount = $cfisHRQuery->where('hr_approval', 1)->where('comp_status', 1)->count();
        $pendingdocumentscount = $cfisHRQuery->whereIn('hr_approval', [0, 2])->count();

        // HR Client Counts
        $hrclientsQuery = ClientManagement::whereIn('id', $hrClients)
            ->with('client')
            ->selectRaw("
            COUNT(*) as total_clients, 
            SUM(active_status = 0) as active_clients, 
            SUM(active_status = 1) as inactive_clients
        ")
            ->first();

        $hrclients = ClientManagement::whereIn('id', $hrClients)->with('client')->get();

        // Assigning optimized counts
        $hrtotalclients = $hrclientsQuery->total_clients;
        $hractiveclient = $hrclientsQuery->active_clients;
        $hrinactiveclient = $hrclientsQuery->inactive_clients;

        $hrclients->each(function ($client) {
            $client->active_employees = $client->client->where('status', 1)->count();
            $client->inactive_employees = $client->client->where('status', 0)->count();
        });

        return view('admin.dashboard', compact(
            'clientStats',
            'fhrms',
            'clients',
            'birthdays',
            'labour',
            'userRole',
            'offerlettercount',
            'esicNumbers',
            'onboardingCount',
            'uanNumbers',
            'pendingdocumentscount',
            'hrtotalclients',
            'hractiveclient',
            'hrinactiveclient',
            'hrclients',
            'cfis'
        ));
    }
    
    public function logout()
    {
        Auth::logout();
        return to_route('admin.login');
    }
}
