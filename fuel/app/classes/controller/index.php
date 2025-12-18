<?php

class Controller_Index extends Controller
{
    public function action_index()
    {
        // 1. 入力パラメータの取得
        $search_query = Input::get('q',''); // 検索キーワード
        $filter_reservable = Input::get('r','null'); // 予約絞り込み (0, 1, 2, 3)

        // 2. クエリの準備 (Model_Placeからデータを取得する準備)
        // related('genre')をつけることで、ジャンル名での検索を可能にします
        $query = Model_Place::query()->related('genre');

        // 3. 検索機能の実装 (キーワードがある場合)
        if (!empty($search_query)) {
            $query->where_open()
                ->where('name', 'like', "%$search_query%")      // 店名に含む
                ->or_where('note', 'like', "%$search_query%")   // ひとことに含む
                ->or_where('genre.name', 'like', "%$search_query%") // ジャンル名に含む
                ->where_close();
        }

        // 4. 絞り込み機能の実装 (予約条件が選択されている場合)
        // ※「すべて」の場合は $filter_reservable が null なので何もしない
        if ($filter_reservable !== null && $filter_reservable !== '') {
            $query->where('reservable', $filter_reservable);
        }

        // 5. 並び順と実行
        $places = $query->order_by('created_at', 'desc')->get();

        // ビューに渡すデータ
        $data = array(
            'places' => $places,
            'search_query' => $search_query,
            'filter_reservable' => $filter_reservable,
            // 予約状況の表示用マップ (post.phpのバリデーション順序と整合性を合わせる)
            'reservable_map' => array(
                0 => '予約可',
                1 => '予約不要',
                2 => '予約不可',
                3 => '予約難',
            ),
             // 色分け用のクラスマップ
             'reservable_color_map' => array(
                0 => 'status-ok',   // 予約可
                1 => 'status-free', // 予約不要
                2 => 'status-ng',   // 予約不可
                3 => 'status-hard', // 予約難
            ),
        );

        return View::forge('recommender/index', $data);
    }
}