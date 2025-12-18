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

        // 1. ORMを使ってクエリを準備 (genreとのリレーションを含める)
        $query = Model_Place::query()->related('genre');

        // 2. キーワード検索（部分一致）
        if ($keyword !== '') {
            $query->where_open()
                ->where('name', 'like', "%$keyword%")
                ->or_where('note', 'like', "%$keyword%")
                ->or_where('genre.name', 'like', "%$keyword%")
                ->where_close();
        }

        // 3. 絞り込み
        if ($reservable !== null && $reservable !== '') {
            $query->where('reservable', $reservable);
        }

        // 4. データ取得
        $places = $query->order_by('created_at', 'desc')
                        ->rows_limit($limit)
                        ->get();

        // 5. JSON用にデータを整形
        // (ModelオブジェクトのままだとJSONにしにくいため、配列に変換します)
        $result = array();
        foreach ($places as $place) {
            $item = $place->to_array();
            // View側で 'genre_name' を使っているため、ここで追加してあげる
            $item['genre_name'] = $place->genre ? $place->genre->name : null;
            $result[] = $item;
        }

        // JSONを返す
        return $this->response($result);
    }
}