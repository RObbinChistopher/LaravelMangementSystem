<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReplyResource;
use App\Http\Resources\TicketResource;
use App\Models\Reply;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function allTicket()
    {
        $ticket = Ticket::paginate(10);
        return TicketResource::collection($ticket);
    }
    public function showTicket()
    {
        $user = Auth::user();
        $ticket = Ticket::where('user_id', $user->id)->paginate(10);
        return TicketResource::collection($ticket);
    }
    public function createTicket(Request $request)
    {
        Ticket::create([
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'open',
        ]);

        return response()->json(['success' => 'Ticket created successfully.']);
    }

    public function getTicketId(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        return new TicketResource($ticket);
    }
    public function AllTicketRely(string $id)
    {
        $reply = Reply::where('ticket_id', $id)->get();
        return ReplyResource::collection($reply);
    }

    public function gaveReply(Request $request)
    {
        $reply = new Reply();
        $ticket = Ticket::where('id', $request->ticket_id)->first(); // Fetch the ticket

        if (!$ticket) {
            return response()->json(['error' => 'Ticket not found.'], 404);
        }

        $ticket->status = $request->Ticketstatus; // Update the status
        $ticket->save(); // Save the updated ticket

        $user = Auth::user();
        $reply->ticket_id = $request->ticket_id;
        $reply->user_id = $user->id;
        $reply->message = $request->message;
        $reply->role = $request->role;
        $reply->status = $request->status;
        $reply->save();

        return response()->json(['success' => 'Reply sent successfully.']);
    }

    public function updateTicketStatusForAdmin()
    {
        $user = Auth::user();
        $hasOpenTickets = Ticket::where('status', 'open')->exists();
        $hasPendingTickets = Ticket::where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();
        $response = [];

        if ($hasOpenTickets) {
            $response['message'] = 'support';
        } else {
            $response['message'] = 'no support';
        }

        if ($hasPendingTickets) {
            $response['admin_message'] = 'admin-support';
        } else {
            $response['admin_message'] = 'no admin support';
        }

        return response()->json($response);
    }
}
