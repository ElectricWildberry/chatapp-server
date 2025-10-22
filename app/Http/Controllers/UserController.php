<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\LoginToken;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserRoom;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|string',
            'password' => 'required|string',
        ]);

        $responseData = [
            'status' => 0,
        ];

        if ($validator->fails())
        {
            Log::error($validator->errors(), ['file' => __FILE__, 'line' => __LINE__]);

            return response()->json($responseData,400);
        }

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->user_name,
                'password' => $request->password,
            ]);

            UserProfile::create([
                'user_id' => $user->id,
                'profile_name' => $request->user_name,
                'comment' => '',
                'color_primary' => '000000',
                'color_secondary' => 'FFFFFF',
            ]);
            
            UserRoom::create([
                'user_id' => $user->id,
                'room_id' => 1,
            ]);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json($responseData,500);
        }

        $responseData['status'] = 1;

        return response()->json($responseData,200);
    }

    public function login(Request $request) //TODO
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
            'token' => 'required|string',
        ]);

        $responseData = [];

        if ($validator->fails())
        {
            Log::error($validator->errors(), ['file' => __FILE__, 'line' => __LINE__]);

            return response()->json($responseData,400);
        }

        $user = User::where('name', $request->username)->where('password', $request->password)->get()->first();

        if (!empty($user)) 
        {
            $token = LoginToken::where('user_id', $user->id)->get()->first();

            if (empty($token))
            {
                $token = LoginToken::create([
                    'user_id' => $user->id,
                    'token' => $this->getRandomStringRand(16),
                    'valid_until' => Carbon::tomorrow(),
                ]);

                $responseData = [
                    'user_id' => $user->id,
                    'token' => $token->token,
                ];

                return response()->json($responseData,200);
            }

            if ($token->valid_until < Carbon::now())
            {
                $token->token = $this->getRandomStringRand(16);
                $token->valid_until = Carbon::tomorrow();
                $token->update();

                $responseData = [
                    'user_id' => $user->id,
                    'token' => $token->token,
                ];

                return response()->json($responseData,200);
            }

            if ($token->token == $request->token)
            {
                $responseData = [
                    'user_id' => $user->id,
                    'token' => $token->token,
                ];

                return response()->json($responseData,200);
            }
        }

        //user has changed token, or doesn't exist
        $responseData = [
            'user_id' => 0,
            'token' => '',
        ];

        return response()->json($responseData,400);
    }

    public function getRandomStringRand($length = 16)
    {
        $stringSpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $stringLength = strlen($stringSpace);
        $randomString = '';
        for ($i = 0; $i < $length; $i ++) {
            $randomString = $randomString . $stringSpace[rand(0, $stringLength - 1)];
        }
        return $randomString;
    }
}