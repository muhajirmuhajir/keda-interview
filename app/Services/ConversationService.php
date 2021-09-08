<?php

namespace App\Services;

use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class ConversationService
{
    public function create($receiver_id, $content , $type)
    {
        // find conversation to related user
        $conversation = Conversation::where(['user_id_1' => Auth::user()->id, 'user_id_2' => $receiver_id])->first();
        if (!$conversation) {
            $conversation = Conversation::where(['user_id_1' => $receiver_id, 'user_id_2' => Auth::user()->id])->first();
        }

        // if null then create new
        if (!$conversation) {
            $conversation = Conversation::create([
                'user_id_1' => Auth::user()->id,
                'user_id_2' => $receiver_id,
            ]);
        }

        // put the new message to the conversation
        $conversation->messages()->create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $receiver_id,
            'type' => $type ?? Message::TYPE_TEXT,
            'content' => $content
        ]);

        return $this->show($conversation);

    }

    public function show(Conversation $conversation)
    {
        return $conversation->load('messages');
    }

    public function showAllConvesation()
    {
        return Conversation::with('messages')->get();
    }

    public function showMyConversation()
    {
        return Conversation::where('user_id_1', Auth::user()->id)->orWhere('user_id_2', Auth::user()->id)->get();
    }
}
