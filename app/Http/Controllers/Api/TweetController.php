<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TweetRequest;
use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    //データ取得
    function get()
    {
        //「tweets」テーブルのレコードをすべて取得
        // SELECT * FROM tweets;
        $tweets = Tweet::with('user')->get();
        // JSONでレスポンス
        return response()->json($tweets);
    }

    //データ投稿
    function add(Request $request)
    {
        //認証中のUserを取得
        $user = $request->user();

        // User IDが一致したらDB保存
        if ($user->id == $request->user_id) {
            $tweet = Tweet::create($request->all());
            return response()->json($tweet);
        } else {
            return response()->json(
                ['error' => 'invalid tweet'],
                401
            );
        }
    }
}