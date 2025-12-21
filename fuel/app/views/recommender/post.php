<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommender - 投稿</title>
    <?php echo Asset::css('post.css'); ?>
</head>
<body>

    <div class="header-right">
        <?php if (Auth::check()): ?>
            <a href="<?php echo Uri::create('login/logout'); ?>" class="logout-btn">ログアウト</a>
        <?php endif; ?>
    </div>

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
                       value="<?php echo Input::post('name'); ?>" autocomplete="off">
                
                <input type="hidden" id="place_id" name="place_id" value="<?php echo Input::post('place_id'); ?>">
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
                    <select name="genre_id" class="form-control genre-select">
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
                        <input type="radio" name="reservable" value="0" <?php echo (Input::post('reservable') == '0') ? 'checked' : ''; ?>>
                        <span class="radio-text">予約可</span>
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="reservable" value="1" <?php echo (Input::post('reservable') == '1') ? 'checked' : ''; ?>>
                        <span class="radio-text">予約不要</span>
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="reservable" value="2" <?php echo (Input::post('reservable') == '2') ? 'checked' : ''; ?>>
                        <span class="radio-text">予約不可</span>
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="reservable" value="3" <?php echo (Input::post('reservable') == '3') ? 'checked' : ''; ?>>
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
                       value="<?php echo Input::post('address'); ?>">
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
                       value="<?php echo Input::post('phone_number'); ?>">
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
                                <?php echo (Input::post($key)) ? 'checked' : ''; ?>>
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
                       value="<?php echo Input::post('website_url'); ?>">
            </div>

            <div class="form-group">
                <label for="note">ひとこと</label>
                <textarea id="note" name="note" rows="4" 
                          placeholder="ひとことを入力" 
                          class="form-control"><?php echo Input::post('note'); ?></textarea>
            </div>

            <div class="form-footer">
                <button type="submit" class="submit-btn">投稿する</button>
            </div>

        </form>
    </div>

    

    <script>
        window.initAutocomplete = function() {
            // 入力フィールドを取得
            const input = document.getElementById("place-input");
            if (!input) return;
            
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // 送信をキャンセル
                    return false;
                }
            });

            // Autocompleteの初期化
            const autocomplete = new google.maps.places.Autocomplete(input, {
                fields: ["place_id", "name", "formatted_address", "formatted_phone_number", "website"],
                componentRestrictions: { country: "jp" }, // 日本国内に限定
            });

            // 場所が選択されたときのイベントリスナー
            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();

                // 1. 店舗名の上書き (place.name)
                if (place.name) {
                    input.value = place.name;
                }

                // 2. Place ID (place.place_id) -> 隠しフィールドへ
                if (place.place_id) {
                    document.getElementById("place_id").value = place.place_id;
                }

                // 3. 住所 (place.formatted_address) -> 自動入力
                if (place.formatted_address) {
                    // "日本、〒000-0000 "のようなプレフィックスを取り除く簡易処理
                    let address = place.formatted_address.replace(/^日本、/, '');
                    document.getElementById("address").value = address;
                }

                // 4. 電話番号 (place.formatted_phone_number) -> 自動入力
                if (place.formatted_phone_number) {
                    document.getElementById("phone_number").value = place.formatted_phone_number;
                }

                // 5. ウェブサイト (place.website) -> 自動入力
                if (place.website) {
                    document.getElementById("website_url").value = place.website;
                }
            });
        }
    </script>

    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-nfAbhs2a2motzMwpLRM_KBWCqqHJXFg&libraries=places&callback=initAutocomplete&language=ja">
    </script>
</body>
</html>