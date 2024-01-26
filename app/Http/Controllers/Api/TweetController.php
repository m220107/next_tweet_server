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
        // SELECT * FROM tweets 
        // JOIN user ON user.id = tweet.user_id 
        // ORDER BY created_at DESC
        // OFFSET 0;
        // LIMIT 25;
        $tweets = Tweet::with('user')
            ->orderBy('created_at', 'DESC')
            ->limit(25)
            ->get();
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
            // ここになにか追加するっぽい
            // ツイートに関連するユーザー情報を取得
            $tweetWithUser = $tweet->load('user');
            return response()->json($tweet);
        } else {
            return response()->json(
                ['error' => 'invalid tweet'],
                401
            );
        }
    }
}