<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CompanyController extends Controller
{
    //
    public function index()
    {
        $company = DB::table('companies')
                        ->leftJoin('clients', 'clients.companyid', '=', 'companies.id')
                        ->leftJoin('jobs', 'jobs.clientid', '=', 'clients.id')
                        ->selectRaw("companies.id as cid, companies.name as cname, SUM(jobs.price) as prices")
                        ->groupBy('skoopdb.companies.id')
                        ->groupBy('skoopdb.companies.name')
                        ->orderBy('prices', 'desc')
                        ->paginate(10);

        return view('companylist', ['companies' => $company]);
    }
}
