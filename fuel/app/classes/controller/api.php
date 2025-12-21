<?php

class Controller_Api extends Controller_Rest
{
    public function get_search()
    {
        // Config読み込み
        Config::load('myapp', true);
        $limit = Config::get('myapp.search_limit', 50);

        // 入力受け取り
        $keyword = Input::get('q', '');
        $reservable = Input::get('r', null);

        // ORMを使ってクエリを準備
        $query = Model_Place::query()->related('genre');

        // キーワード検索（部分一致）
        if ($keyword !== '') {
            $query->where_open()
                ->where('name', 'like', "%$keyword%")
                ->or_where('note', 'like', "%$keyword%")
                ->or_where('genre.name', 'like', "%$keyword%")
                ->where_close();
        }

        // 絞り込み
        if ($reservable !== null && $reservable !== '') {
            $query->where('reservable', $reservable);
        }

        // データ取得
        $places = $query->order_by('created_at', 'desc')
                        ->rows_limit($limit)
                        ->get();

        // JSON用にデータを整形
        $result = array();
        foreach ($places as $place) {
            $item = $place->to_array();
            $item['genre_name'] = $place->genre ? $place->genre->name : null;
            $result[] = $item;
        }

        // JSONを返す
        return $this->response($result);
    }

    // 指定されたIDのお店の情報を返すAPI (編集画面用)
    public function get_place($id = null)
    {
        if (!$id) {
            return $this->response(array('error' => 'IDが必要です'), 400);
        }

        $place = Model_Place::find($id);

        if (!$place) {
            return $this->response(array('error' => 'データが見つかりません'), 404);
        }

        // JSON形式で返す
        return $this->response($place->to_array());
    }
}