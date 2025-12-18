<?php

class Controller_Login extends Controller
{
    public function action_index()
    {
        // 既にログイン済みならトップへ
        if (Auth::check()) {
            Response::redirect('index');
        }

        $view = View::forge('recommender/login');

        if (Input::method() == 'POST') {
            if (Auth::login(Input::post('username'), Input::post('password'))) {
                // 成功
                Response::redirect('index');
            } else {
                // 失敗
                $view->error = 'ユーザー名またはパスワードが間違っています。';
            }
        }

        return $view;
    }
}