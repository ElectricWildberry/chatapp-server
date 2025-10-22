<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\UserRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ChatMessageController extends Controller
{
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|int',
            'room_id' => 'required|int',
            'token' => 'required|string',
            'message' => 'required|string',
            'send_silent' => 'bool',
        ]);

        $responseData = [
            'status' => 0,
        ];

        if ($validator->fails())
        {
            Log::error($validator->errors(), ['file' => __FILE__, 'line' => __LINE__]);

            return response()->json($responseData,400);
        }

        ChatMessage::create([
            'sender_user_id' => $request->user_id,
            'room_id' => $request->room_id,
            'content' => $request->message,
            'send_notification' => $request->send_silent,
        ]);

        $responseData['status'] = 1;

        return response()->json($responseData,200);
    }

    public function get(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|int',
            'room_id' => 'required|int',
            'token' => 'required|string',
            'index' => 'required|int',
        ]);

        if ($validator->fails())
        {
            Log::error($validator->errors(), ['file' => __FILE__, 'line' => __LINE__]);

            return response()->json([],400);
        }

        if (UserRoom::where('user_id', $request->user_id))

        $responseData = ChatMessage::select(['chat_messages.id as id' ,'profile_name', 'content', 'chat_messages.created_at'])
                            ->join('user_profiles', 'user_id', '=', 'sender_user_id')
                            ->where('room_id', $request->room_id)
                            ->orderBy('chat_messages.created_at', 'desc')
                            ->skip($request->index)->take(10)
                            ->get()->toArray();

        return response()->json($responseData,200);
    }

    public function new(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|int',
            'room_id' => 'required|int',
            'token' => 'required|string',
            'index' => 'required|int',
        ]);

        if ($validator->fails())
        {
            Log::error($validator->errors(), ['file' => __FILE__, 'line' => __LINE__]);

            return response()->json([],400);
        }

        if (UserRoom::where('user_id', $request->user_id))

        $responseData = ChatMessage::select(['chat_messages.id as id' ,'profile_name', 'content', 'chat_messages.created_at'])
                            ->join('user_profiles', 'user_id', '=', 'sender_user_id')
                            ->where('room_id', $request->room_id)
                            // ->orderBy('created_at', 'desc')
                            ->where('chat_messages.id', '>', $request->index)
                            ->get()->toArray();

        return response()->json($responseData,200);
    }

    public function edit(Request $request) //TODO
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|int',
            'room_id' => 'required|int',
            'token' => 'required|string',
            'edit_base' => 'required|string',
            'edit_new' => 'required|string',
            'send_silent' => 'bool',
        ]);

        $responseData = [
            'status' => 0,
        ];

        if ($validator->fails())
        {
            Log::error($validator->errors(), ['file' => __FILE__, 'line' => __LINE__]);

            return response()->json($responseData,400);
        }

        ChatMessage::create([
            'sender_user_id' => $request->user_id,
            'room_id' => $request->user_id,
            'content' => $request->message,
            'send_notification' => $request->send_silent,
        ]);

        $responseData['status'] = 1;

        return response()->json($responseData,200);
    }
}