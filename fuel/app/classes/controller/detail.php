<?php

class Controller_Detail extends Controller
{
    public function action_index($id = null)
    {
        if ($id === null) {
            Response::redirect('index');
        }

        $place = Model_Place::find($id);

        if (!$place) {
            Response::redirect('index');
        }

        $data['place'] = $place;

        // 定休日の表示用文字列を作成
        $closed_days = [];
        if ($place->closing_sun) $closed_days[] = '日';
        if ($place->closing_mon) $closed_days[] = '月';
        if ($place->closing_tue) $closed_days[] = '火';
        if ($place->closing_wed) $closed_days[] = '水';
        if ($place->closing_thu) $closed_days[] = '木';
        if ($place->closing_fri) $closed_days[] = '金';
        if ($place->closing_sat) $closed_days[] = '土';
        if ($place->closing_hol) $closed_days[] = '祝';
        if ($place->closing_irregular) $closed_days[] = '不定休';
        
        $data['closed_days_string'] = empty($closed_days) ? 'なし（年中無休）' : implode(' / ', $closed_days);

        return View::forge('recommender/detail', $data);
    }
}