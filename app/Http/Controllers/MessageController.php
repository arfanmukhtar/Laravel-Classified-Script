<?php

namespace App\Http\Controllers;

use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MessageController extends Controller
{
    public function index()
    {
        $threads = Thread::forUser(Auth::id())->groupBy('participants.thread_id')->latest('updated_at')->get();
        $title = 'My Messages';

        return view('account.messages', compact('title', 'threads'));
    }

    public function show($id)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: '.$id.' was not found.');

            return redirect()->route('messages');
        }

        // show current user in list if not a current participant
        // $users = User::whereNotIn('id', $thread->participantsUserIds())->get();

        // don't show the current user in list
        $userId = Auth::id();
        $users = \App\Models\User::whereNotIn('id', $thread->participantsUserIds($userId))->get();

        $thread->markAsRead($userId);

        return view('account.message_detail', compact('thread', 'users'));
    }

    public function replyMessage(Request $request)
    {
        $input = $request->all();
        Message::create([
            'thread_id' => $input['thread_id'],
            'user_id' => Auth::id(),
            'body' => $input['message'],
        ]);

        echo 'success';

    }

    public function sendMessage(Request $request)
    {
        $input = $request->all();

        $thread_id = DB::table('threads')->insertGetId([
            'post_id' => $input['post_id'],
            'subject' => $input['subject'],
        ]);

        // Message
        Message::create([
            'thread_id' => $thread_id,
            'user_id' => Auth::id(),
            'body' => $input['message'],
        ]);

        // Sender
        Participant::create([
            'thread_id' => $thread_id,
            'user_id' => Auth::id(),
            'last_read' => gmdate('Y-m-d H:i:s'),
        ]);
        Participant::create([
            'thread_id' => $thread_id,
            'user_id' => $input['user_id'],
            'last_read' => gmdate('Y-m-d H:i:s'),
        ]);

        echo 'success';
    }

    public function deleteThread(Request $request)
    {
        $id = $request->input('thread_id');
        try {
            $thread = Thread::findOrFail($id);

        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'Error');

            return redirect()->route('messages');
        }

        $message = Message::where('thread_id', $thread->id)->delete();
        $participants = Participant::where('thread_id', $thread->id)->delete();

        $thread->delete();

    }
}
