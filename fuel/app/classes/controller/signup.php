<?php

class Controller_Signup extends Controller
{   
    public function action_index()
    {
        // 既にログイン済みならトップへ
        if (Auth::check()) {
            Response::redirect('index');
        }

        $view = View::forge('recommender/signup');

        if (Input::method() == 'POST') {

            //バリデーション作成
            $val = Validation::forge();

            //ユーザー名
            $val->add('username', 'ユーザー名')
                ->add_rule('required')
                ->add_rule('max_length', 30);
            
            //パスワード
            $val->add('password', 'パスワード')
                ->add_rule('required')
                ->add_rule('max_length', 255);

            //エラーメッセージ内容
            $val->set_message('required', ':label は必須です。');
            $val->set_message('max_length', ':label は :param:1 文字以内で入力してください。');
            
            if ($val->run()) {
                try {
                    //今回はemailを認証で使わないのでダミーメールアドレス作成
                    $dummy_email = Input::post('username') . '@dummy.com';

                    // ユーザー作成 (ユーザー名, パスワード)
                    $created = Auth::create_user(
                        Input::post('username'),
                        Input::post('password'),
                        $dummy_email
                    );

                    if ($created) {
                        // 作成成功したらそのままログインさせる
                        Auth::login(Input::post('username'), Input::post('password'));
                        Response::redirect('index');
                    }
                } catch (\SimpleUserUpdateException $e) {
                    // ユーザー名重複などのエラー
                    $view->error = 'そのユーザー名は既に使用されています。';
                }
            } else {
                $view->error = $val->error();
            }
        }

        return $view;
    }
}
