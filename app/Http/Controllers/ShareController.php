<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use stdClass;

class ShareController extends Controller
{

    public function index()
    {

        $tickets = auth()->user()->sharedTickets()->get();
        $obj = new StdClass();
        $arr = array();
        foreach ($tickets as $ticket) {
            $obj->ticket = $ticket;
            $obj->owner = $ticket->owner;
            array_push($arr, $obj);
        }

        return Inertia::render('Shared', [
            "tickets" => $arr
        ]);
    }
}
