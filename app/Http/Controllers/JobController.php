<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Job;

function convertToObject($array) {
    $object = new \stdClass();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $value = convertToObject($value);
        }
        $object->$key = $value;
    }
    return $object;
}

/*
    Performs a select query on the database in the 'jobs' table. Will return results based on the input parameters.
*/
class JobController extends Controller
{
    private $displayLimit = 10;

    public function index()
    {
        // Pull the possible status code names from the database.
        $statusCodes = DB::table('status')
        ->selectRaw('status.id, status.name')
        ->get();

        $statusArray = array();
        $statusArray[0] = "Any";
        foreach($statusCodes as $code)
        {
            $statusArray[$code->id] = $code->name;
        }

        // Either show paginated result or default page.
        if(request('page'))
        {
            $pageid = request('page');

            return view('joblist', ["page" => $pageid, "statusCodes" => $statusArray]);
        }
        else
        {
            return view('joblist', ["page" => 0, "statusCodes" => $statusArray]);
        }

        //
    }

    public function readData()
    {
        // Check filters for validitity.
        if(!request('filter'))
            $filter = "";
        else
            $filter = request('filter');

        if(!request('statusCode'))
            $statusCode = 0;
        else
            $statusCode = request('statusCode');

        // Build Query.
        $jobQuery = DB::table('jobs')
        ->join('clients', 'jobs.clientid', '=', 'clients.id')
        ->join('status', 'jobs.status', '=', 'status.id')
        ->join('companies', 'clients.companyid', '=', 'companies.id')
        ->selectRaw('jobs.name as jobname, jobs.created_at, jobs.price, status.id as statusid, status.name as statusname,
                     clients.id as clientid, clients.name as clientname, clients.surname as clientsurname, companies.name as companyname');
        
        // Conditional execution of filters.
        if($statusCode != 0)
            $jobQuery->where('status.id', '=', $statusCode);

        if($filter != "")
        {
            $jobQuery->where('jobs.name', 'like', $filter . "%")
            ->orWhere('clients.name', 'like', "%" . $filter . "%")
            ->orWhere('clients.surname', 'like', "%" . $filter . "%")
            ->orWhere('companies.name', 'like', $filter . "%");
        }

        // Pull results from the database.
        $jobs = $jobQuery->paginate(10)->appends('statusCode', request('statusCode'))->appends('filter', request('filter'));

        // Job count aggregate for each DISPLAYED client.
        $clientAggregates = array();
        foreach($jobs as $j)
        {
            if(!array_key_exists($j->clientid, $clientAggregates))
            {
                $countQuery = DB::table('jobs')
                ->where('jobs.clientid', '=', $j->clientid)->get()->count();

                $clientAggregates[$j->clientid] = $countQuery;
            }
        }

        // Display results.
        return view('results.jobData', [ "jobs" => $jobs, "counts" => $clientAggregates ]); //"numPages" => $numPages
    }
}
