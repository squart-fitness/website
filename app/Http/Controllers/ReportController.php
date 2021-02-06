<?php

namespace App\Http\Controllers;

// created packages import
use App\Http\Controllers\EnquiryClasses\EnquiryManager;

//laravel packages import
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(){
    	$this->middleware(['auth', 'gymstatus']);
    }

    //show enquiry convergence report to user
    public function enquiryConvergence(){
        $eqm = new EnquiryManager;
        $enquiry = $eqm->getEnquiryConvergence();
        return view('reports.enquiry_convergence')->with('reports', $enquiry);
    }
}
