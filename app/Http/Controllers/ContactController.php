<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Messages;
use Session;

class ContactController extends Controller
{

    public function __construct()
    {
    }

    public function getContact(Request $request)
    {
        return view('public/contact');
    }

    public function postContact(Request $request)
    {
        $this->validate($request, [
                'email' => 'email|required|max:120',
                'message' => 'required|max:255',
                'hipercaptcha' => 'hipercaptcha',
        ]);


        $message = new Messages;
        $message->email = $request->email;
        $message->message = $request->message;
        $message->readed = false;
        $message->ip = $request->getClientIp();
        $message->save();

        Session::flash('flash_message', trans("app.contact.success"));
        return redirect()->back();
    }
}
