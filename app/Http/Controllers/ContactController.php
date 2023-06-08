<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactNotification;
use Illuminate\Support\Facades\Mail;
use RuntimeException;

class ContactController extends Controller
{
    //
    public function sendMail (Request $request) {
        $name= $request->name;
        $email = $request->input ("email");
        $suggest = $request->input ("suggest");
        try {
            Mail::to("david.martinez@webmaster.com")->send(new ContactNotification($name, $email,$suggest));

        }
        catch (RuntimeException $e) {
            return back() -> with('message', "Error en el envío del correo") -> with ('code', "ERROR");
        }

       
        return back() -> with('message', "Mensaje enviado satisfactoriamente") -> with ('code', "OK");
    }
}
