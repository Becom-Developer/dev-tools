<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditCsvRequest;
use App\Http\Requests\UpdateCreditCsvRequest;
use App\Models\CreditCsv;
use Illuminate\Support\Facades\Process;

class CreditCsvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $path = base_path('pylogic');
        $commond = '.venv/bin/python3 credit_csv.py';
        $result = Process::path($path)->run($commond);
        $output = $result->output();
        if ($result->failed()) {
            logger('credit-csv: ', [
                'successful' => $result->successful(),
                'failed' => $result->failed(),
                'exitCode' => $result->exitCode(),
                'output' => $result->output(),
                'errorOutput' => $result->errorOutput(),
            ]);
            $output = $result->errorOutput();
        }
        return view('credit-csv', ['output' => $output]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCreditCsvRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CreditCsv $creditCsv)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CreditCsv $creditCsv)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCreditCsvRequest $request, CreditCsv $creditCsv)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CreditCsv $creditCsv)
    {
        //
    }
}
