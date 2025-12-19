<?php

class Controller_Post extends Controller
{

    // ログインの有無確認
    public function before()
    {
        parent::before();

        if (! \Auth::check()) {
            // ログインしていなければ、ログインページへ強制リダイレクト
            \Response::redirect('login');
        }
    }

    public function action_index()
    {
        //フォームが送信された場合
        if (\Input::method() == 'POST') {

            //バリデーションを実行
            $val = $this->create_validation();

            //バリデーションが成功した場合
            if ($val->run()) {
                //ログインしているユーザーを取得
                $current_user_id = \Auth::get('id');

                $place = Model_Place::forge(array(
                    'name'          => \Input::post('name'),
                    'place_id'      => \Input::post('place_id'),
                    'genre_id'      => \Input::post('genre_id'),
                    'reservable'    => \Input::post('reservable'),
                    'address'       => \Input::post('address'),
                    'phone_number'  => \Input::post('phone_number'),
                    'closing_sun'   => \Input::post('closing_sun', 0),
                    'closing_mon'   => \Input::post('closing_mon', 0),
                    'closing_tue'   => \Input::post('closing_tue', 0),
                    'closing_wed'   => \Input::post('closing_wed', 0),
                    'closing_thu'   => \Input::post('closing_thu', 0),
                    'closing_fri'   => \Input::post('closing_fri', 0),
                    'closing_sat'   => \Input::post('closing_sat', 0),
                    'closing_hol'   => \Input::post('closing_hol', 0),
                    'closing_irregular' => \Input::post('closing_irregular', 0),
                    'website_url'   => \Input::post('website_url'),
                    'note'          => \Input::post('note'),
                    'user_id'       => $current_user_id,
                ));

                if ($place && $place->save()) {
                    // 登録成功
                    \Session::set_flash('success', '投稿に成功しました。');
                    // 一覧ページへリダイレクト
                    \Response::redirect('index');
                } else {
                    // 登録失敗
                    \Session::set_flash('error', '投稿に失敗しました。');
                }
            } else {
                //バリデーション失敗
                \Session::set_flash('error', $val->error());
            }
        }

        // ジャンル一覧を取得してビューに渡す
        $genres = Model_Genre::find('all');
        $data['genres'] = $genres;
        return View::forge('recommender/post', $data);
    }

    //バリデーションルール設定
    private function create_validation()
    {
        $val = Validation::forge();

        //場所の名前
        $val->add('name', '場所の名前')
            ->add_rule('required')
            ->add_rule('max_length', 50)
            ->set_error_message('required', '場所の名前は必須です。');

        //place_id
        $val->add('place_id', 'GMAP_ID')
            ->add_rule('required')
            ->add_rule('max_length', 100)
            ->set_error_message('required', '候補から選んでください。');

        //ジャンルid
        $val->add('genre_id', 'ジャンル')
            ->add_rule('required')
            ->add_rule('valid_string', array('numeric'))
            ->set_error_message('required', 'ジャンルは必須です。');

        //予約可否
        $val->add('reservable', '予約可否')
            ->add_rule('required')
            ->add_rule('valid_string', array('numeric'))
            ->add_rule('numeric_min', 0)
            ->add_rule('numeric_max', 3)
            ->set_error_message('required', '予約の可否は必須です。');

        //住所
        $val->add('address', '住所')
            ->add_rule('required')
            ->set_error_message('required', '住所は必須です。');

        //電話番号
        $val->add('phone_number', '電話番号')
            ->add_rule('required')
            ->add_rule('max_length', 30)
            ->add_rule('match_pattern', '/^[0-9-]+$/')
            ->set_error_message('required', '電話番号は必須です。');


        //ホームページURL
        $val->add('website_url', 'ホームページURL')
            ->add_rule('valid_url');

        //エラーメッセージ内容
        $val->set_message('max_length', ':label は :param:1 文字以内で入力してください。');
        $val->set_message('valid_url', '正しいURLの形式で入力してください（http...）。');
        $val->set_message('match_pattern', '電話番号は半角数字とハイフンのみで入力してください。');

        return $val;
    }
}
