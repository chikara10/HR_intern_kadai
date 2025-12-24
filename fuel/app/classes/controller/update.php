<?php

class Controller_Update extends Controller
{
    // ログインチェック
    public function before()
    {
        parent::before();
        if (!Auth::check()) {
            Response::redirect('login');
        }
    }

    // 編集画面の表示と更新処理
    public function action_index($id = null)
    {
        if (!$id) {
            Response::redirect('index');
        }

        // データの存在確認
        $place = DB::select()->from('places')->where('id', $id)->execute()->current();

        if (!$place) {
            Response::redirect('index');
        }

        // フォームが送信された場合 (更新処理)
        if (Input::method() == 'POST') {

            //CSRF対策
            if (!Security::check_token()) {
                Session::set_flash('error', '正規の画面から送信してください。');
                Response::redirect('detail/index/' . $id);
            }
            
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
                ->set_error_message('required', '検索候補から選んでください。');

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

            // バリデーションを実行
            if ($val->run()) {

                //入力されたplace_idが既に登録されているか確認
                $input_place_id = \Input::post('place_id');
                
                // 自分以外のIDで、同じplace_idを持つデータがあるか確認
                $existing_place = DB::select('id')
                    ->from('places')
                    ->where('place_id', $input_place_id)
                    ->where('id', '!=', $id) // 自分自身は除外
                    ->execute()
                    ->current();

                if ($existing_place) {
                    \Session::set_flash('error', 'その場所はすでに登録されています。');
                } else {

                    // データの更新
                    $data = array(
                        'name'              => Input::post('name'),
                        'place_id'          => Input::post('place_id'),
                        'genre_id'          => Input::post('genre_id'),
                        'reservable'        => Input::post('reservable'),
                        'address'           => Input::post('address'),
                        'phone_number'      => Input::post('phone_number'),
                        'website_url'       => Input::post('website_url'),
                        'note'              => Input::post('note'),
                        'updated_at'        => time(), // 更新日時を手動でセット
                        
                        // 定休日 (チェックがない場合は0になるように処理)
                        'closing_sun'       => Input::post('closing_sun', 0) ? 1 : 0,
                        'closing_mon'       => Input::post('closing_mon', 0) ? 1 : 0,
                        'closing_tue'       => Input::post('closing_tue', 0) ? 1 : 0,
                        'closing_wed'       => Input::post('closing_wed', 0) ? 1 : 0,
                        'closing_thu'       => Input::post('closing_thu', 0) ? 1 : 0,
                        'closing_fri'       => Input::post('closing_fri', 0) ? 1 : 0,
                        'closing_sat'       => Input::post('closing_sat', 0) ? 1 : 0,
                        'closing_hol'       => Input::post('closing_hol', 0) ? 1 : 0,
                        'closing_irregular' => Input::post('closing_irregular', 0) ? 1 : 0,
                    );

                    try {
                        DB::update('places')
                            ->set($data)
                            ->where('id', $id)
                            ->execute();

                        Session::set_flash('success', '情報を更新しました。');
                        Response::redirect('detail/index/' . $id);

                    } catch (Exception $e) {
                        Session::set_flash('error', '更新に失敗しました。');
                    }
                }
            } else {
                Session::set_flash('error', $val->error());
            }
        }

        // ビューの表示
        $data['place'] = $place;
        $data['place_id'] = $id; // JSでAPIを叩くためにIDを渡す
        $data['genres'] = Model_Genre::find('all'); // セレクトボックス用
        return View::forge('recommender/update', $data);
    }
}