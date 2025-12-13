<?php

class Controller_Login extends Controller
{
    // ログイン処理
    public function action_index()
    {
        // 既にログイン済みならトップへ
        if (Auth::check()) {
            Response::redirect('recommender/index');
        }

        $view = View::forge('auth/login');

        if (Input::method() == 'POST') {
            // Authの機能でログイン試行
            if (Auth::login(Input::post('username'), Input::post('password'))) {
                // 成功
                Response::redirect('recommender/index');
            } else {
                // 失敗
                $view->error = 'ユーザー名またはパスワードが間違っています。';
            }
        }

        return $view;
    }
}