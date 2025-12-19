<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編集 - Recommender</title>
    <?php echo Asset::css('update.css'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.js"></script>
</head>
<body>

    <header>
        <a href="<?php echo Uri::create('index'); ?>">
            <?php echo Asset::img('main-icon.png', [
                'class' => 'app-title',
                'alt'   => 'Recommender'
            ]);?>
        </a>
    </header>

    <div class="container">
        <?php 
            $errors = Session::get_flash('error', []); 
        ?>

        <?php if ($errors): ?>
            <div class="alert-error">
                入力内容に不備があります。各項目を確認してください。
            </div>
        <?php endif; ?>

        <form action="" method="post" class="post-form">

            <div class="form-group">
                <label for="place-input">店舗名/場所名 <span class="required">※</span>
                    <?php if (isset($errors['name'])): ?>
                        <span class="error-msg">
                            <?php echo $errors['name']; ?>
                        </span>
                    <?php endif; ?>

                    <?php if (isset($errors['place_id'])): ?>
                        <span class="error-msg">
                            <?php echo $errors['place_id']; ?>
                        </span>
                    <?php endif; ?>
                </label>

                <input type="text" id="place-input" name="name" 
                        placeholder="店舗名/場所名(候補から選択)" 
                        class="form-control"
                        value="<?php echo Input::post('name'); ?>" autocomplete="off" data-bind="value: name">
                
                <input type="hidden" id="place_id" name="place_id" value="<?php echo Input::post('place_id'); ?> " data-bind="value: place_id">
            </div>

            <div class="form-group">
                <label>ジャンル <span class="required">※</span>
                    <?php if (isset($errors['genre_id'])): ?>
                        <span class="error-msg">
                            <?php echo $errors['genre_id']; ?>
                        </span>
                    <?php endif; ?>
                </label>

                <div class="select-wrapper">
                    <select name="genre_id" class="form-control genre-select" data-bind="value: genre_id">
                        <option value="" disabled selected>ジャンルを選択</option>
                        <?php foreach ($genres as $genre): ?>
                            <option value="<?php echo $genre->id; ?>" 
                                <?php echo (Input::post('genre_id') == $genre->id) ? 'selected' : ''; ?>>
                                <?php echo $genre->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>予約 <span class="required">※</span>
                    <?php if (isset($errors['reservable'])): ?>
                        <span class="error-msg">
                            <?php echo $errors['reservable']; ?>
                        </span>
                    <?php endif; ?>
                </label>

                <div class="radio-group">
                    <label class="radio-item">
                        <input type="radio" name="reservable" value="0" <?php echo (Input::post('reservable') == '0') ? 'checked' : ''; ?> data-bind="checked: reservable">
                        <span class="radio-text">予約可</span>
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="reservable" value="1" <?php echo (Input::post('reservable') == '1') ? 'checked' : ''; ?> data-bind="checked: reservable">
                        <span class="radio-text">予約不要</span>
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="reservable" value="2" <?php echo (Input::post('reservable') == '2') ? 'checked' : ''; ?> data-bind="checked: reservable">
                        <span class="radio-text">予約不可</span>
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="reservable" value="3" <?php echo (Input::post('reservable') == '3') ? 'checked' : ''; ?> data-bind="checked: reservable">
                        <span class="radio-text">予約難</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="address">住所 <span class="required">※</span>
                    <?php if (isset($errors['address'])): ?>
                        <span class="error-msg">
                            <?php echo $errors['address']; ?>
                        </span>
                    <?php endif; ?>
                </label>

                <input type="text" id="address" name="address" 
                        placeholder="住所を入力" 
                        class="form-control"
                        value="<?php echo Input::post('address'); ?>" data-bind="value: address">
            </div>

            <div class="form-group">
                <label for="phone_number">電話番号 <span class="required">※</span>
                    <?php if (isset($errors['phone_number'])): ?>
                        <span class="error-msg">
                            <?php echo $errors['phone_number']; ?>
                        </span>
                    <?php endif; ?>
                </label>

                <input type="text" id="phone_number" name="phone_number" 
                        placeholder="電話番号を入力" 
                        class="form-control"
                        value="<?php echo Input::post('phone_number'); ?>" data-bind="value: phone_number">
            </div>

            <div class="form-group">
                <label>定休日</label>
                <div class="checkbox-grid">
                    <?php 
                    $days = [
                        'closing_sun' => '日', 'closing_mon' => '月', 'closing_tue' => '火', 'closing_wed' => '水',
                        'closing_thu' => '木', 'closing_fri' => '金', 'closing_sat' => '土',
                        'closing_hol' => '祝', 'closing_irregular' => '不定休'
                    ];
                    foreach ($days as $key => $label): 
                    ?>
                        <label class="checkbox-item">
                            <input type="checkbox" name="<?php echo $key; ?>" value="1" 
                                <?php echo (Input::post($key)) ? 'checked' : ''; ?> data-bind="checked: <?php echo $key; ?>">
                            <span class="checkbox-text"><?php echo $label; ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="website_url">ホームページ</label>
                <input type="url" id="website_url" name="website_url" 
                        placeholder="URLを入力" 
                        class="form-control"
                        value="<?php echo Input::post('website_url'); ?>" data-bind="value: website_url">
            </div>

            <div class="form-group">
                <label for="note">ひとこと</label>
                <textarea id="note" name="note" rows="4" 
                            placeholder="ひとことを入力" 
                            class="form-control" 
                            data-bind="value: note"><?php echo Input::post('note'); ?></textarea>
            </div>

            <div class="form-footer">
                <button type="submit" class="submit-btn">完了</button>
            </div>

        </form>
    </div>

<script>
    function UpdateViewModel() {
        var self = this;
        var placeId = <?php echo $place_id; ?>;
        var apiUrl = "<?php echo Uri::create('api/place/'); ?>" + placeId + '.json';

        // Observableの定義 (フォームとバインドする変数)
        self.name = ko.observable('');
        self.place_id = ko.observable('');
        self.genre_id = ko.observable('');
        // ラジオボタン用は文字列として扱う必要があるためString変換に注意
        self.reservable = ko.observable('0'); 
        self.address = ko.observable('');
        self.phone_number = ko.observable('');
        self.website_url = ko.observable('');
        self.note = ko.observable('');

        // 定休日 (Boolean)
        self.closing_sun = ko.observable(false);
        self.closing_mon = ko.observable(false);
        self.closing_tue = ko.observable(false);
        self.closing_wed = ko.observable(false);
        self.closing_thu = ko.observable(false);
        self.closing_fri = ko.observable(false);
        self.closing_sat = ko.observable(false);
        self.closing_hol = ko.observable(false);
        self.closing_irregular = ko.observable(false);

        // APIからデータを取得してセットする
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                if(data) {
                    self.name(data.name);
                    self.place_id(data.place_id);
                    self.genre_id(data.genre_id);
                    // DBの数値(Int)を文字列(String)にしてラジオボタンとマッチさせる
                    self.reservable(String(data.reservable)); 
                    self.address(data.address);
                    self.phone_number(data.phone_number);
                    self.website_url(data.website_url);
                    self.note(data.note);

                    // 定休日 (DBの 1/0 を true/false に変換)
                    self.closing_sun(data.closing_sun == 1);
                    self.closing_mon(data.closing_mon == 1);
                    self.closing_tue(data.closing_tue == 1);
                    self.closing_wed(data.closing_wed == 1);
                    self.closing_thu(data.closing_thu == 1);
                    self.closing_fri(data.closing_fri == 1);
                    self.closing_sat(data.closing_sat == 1);
                    self.closing_hol(data.closing_hol == 1);
                    self.closing_irregular(data.closing_irregular == 1);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    ko.applyBindings(new UpdateViewModel());
</script>

</body>
</html>