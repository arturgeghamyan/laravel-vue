<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('tickets')->get();

        return Inertia::render('Tickets', [
            "users" => $users
        ]);    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTickets()
    {
        $tickets = Ticket::where('owner_id', auth()->user()->id)->get();
        return $tickets;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ticket = Ticket::create([
            'name' => $request->name,
            'description' => $request->description,
            'owner_id' => auth()->user()->id
        ]);

        $ticket->save();

        return back()->with('status', 'ticket created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ticket = Ticket::where('id', $request->id)->with('users')->get();
        return $ticket;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $ticket = Ticket::find($request->id);

        $ticket->name = $request->name;
        $ticket->description = $request->description;

        $ticket->save();
        

        return back()->with('status', 'ticket created successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Ticket::where('id', $request->id)->delete();
    }

    public function share(Request $request)
    {
        $ticketId = $request->data['ticketId'];
        $ticket = Ticket::find($ticketId);
        foreach ($request->data['userIds'] as $id) {
            if (!in_array($id, $ticket->users()->pluck('user_id')->toArray())) {
                $ticket->users()->attach($id);
            }
        }
    }
}
