<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Models\Notifications;

class NotificationsController extends Controller
{
    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',  // Ensure that message is a string (HTML)
        ]);

        try {
            $emailData = $request->only('email', 'subject', 'message', 'userId');

            // Send the email
            Mail::to($emailData['email'])->send(new SendEmail($emailData['subject'], $emailData['message']));

            // Save email data to notification table
            Notifications::create([
                'email' => $emailData['email'],
                'subject' => $emailData['subject'],
                'message' => $emailData['message'],
                'userId' => $emailData['userId'],
            ]);

            return response()->json(['success' => 'Email sent and notification saved successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send email. ' . $e->getMessage()], 500);
        }
    }


    public function showNotification()
    {
        $user = auth()->user();
        if ($user->role == 'Team-Member') {
            $not = Notifications::where('userId', $user->id)
                ->orderBy("id", "desc")
                ->paginate(10);
        } else {
            $not = Notifications::orderBy("id", "desc")
                ->paginate(10);
        }

        return NotificationsResource::collection($not);
    }

    public function editNotfication(string $id){
        $not = Notifications::findOrFail($id);
        return new NotificationsResource($not);
    }
    public function UpdateNotfication(Request $request, string $id){
        $not = Notifications::findOrFail($id);
        $not->userId = $request->userId;
        $not->email = $request->email;
        $not->subject = $request->subject;
        $not->message = $request->message;

        $not->save();

        return response()->json(['success' => 'Notification Update Successfully']);
    }
    public function deleteNotfication(string $id){
        $not = Notifications::findOrFail($id);
        $not->delete();
        return response()->json(['success' => 'Notification Delete Successfully']);
    }
    public function NotificationSearch(Request $request)
    {
        $query = $request->input('query.query');

        $results = Notifications::where('email', 'like', "%$query%")
            ->orWhere('subject', 'like', "%$query%")
            ->limit(5)
            ->get();

        return NotificationsResource::collection($results);
    }
}
