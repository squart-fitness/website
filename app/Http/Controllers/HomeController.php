<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\HomeClasses\ContactManager;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index');
    }

    //save contact information of guest
    public function contactStore(Request $request){
        $data = $request->validate([
                                    'name' => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z\s]+$/'],
                                    'email' => ['required', 'email', 'max:100'],
                                    'subject' => ['required', 'string', 'max:200', 'regex:/^[\w\s\,\.]+$/'],
                                    'message' => ['required', 'string', 'max:100', 'regex:/^[\w\s\,\.\:\"]+$/'],
                                ]);

        $cm = new ContactManager;
        $cm->saveContact($data);

        return redirect()->back();
    }
}
