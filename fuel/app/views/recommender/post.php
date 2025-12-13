<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿</title>
    <?php echo Asset::css('post.css'); ?>
</head>
<body>

<?php
    // コントローラーから送られてきたエラー配列（$val->error()の中身）を取得
    // エラーがない場合は空の配列 [] をセット
    $errors = Session::get_flash('error', []);
?>

<div class="container">
    <h1 class="page-title">Recommender</h1>

    <div class="form-card">
        <?php echo Form::open(array('action' => Uri::current(), 'method' => 'post')); ?>

            <div class="form-group">
                <label>店舗名/場所名 <span class="required-mark">※</span>
                    <?php if (isset($errors['name'])): ?>
                        <span class="error-msg"><?php echo $errors['name']; ?></span>
                    <?php endif; ?>
            </label>
                <input type="text" name="name" placeholder="店舗名/場所名を入力" value="<?php echo Input::post('name'); ?>">
            </div>

            <div class="form-group">
                <label>ジャンル <span class="required-mark">※</span>
                    <?php if (isset($errors['genre_id'])): ?>
                        <span class="error-msg"><?php echo $errors['genre_id']; ?></span>
                    <?php endif; ?></label>
                <select name="genre_id">
                    <option value="" disabled selected>ジャンルを選択</option>
                    <?php if (isset($genres)): ?>
                        <?php foreach ($genres as $genre): ?>
                            <option value="<?php echo $genre->id; ?>" <?php echo (Input::post('genre_id') == $genre->id) ? 'selected' : ''; ?>>
                                <?php echo $genre->name; ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label>予約 <span class="required-mark">※</span>
                <?php if (isset($errors['reservable'])): ?>
                        <span class="error-msg"><?php echo $errors['reservable']; ?></span>
                <?php endif; ?></label>
                <div class="radio-group">
                    <label class="radio-label">
                        <input type="radio" name="reservable" value="0" <?php echo (Input::post('reservable') == '0') ? 'checked' : ''; ?>> 予約可
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="reservable" value="1" <?php echo (Input::post('reservable') == '1') ? 'checked' : ''; ?>> 予約不要
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="reservable" value="2" <?php echo (Input::post('reservable') == '2') ? 'checked' : ''; ?>> 予約不可
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="reservable" value="3" <?php echo (Input::post('reservable') == '3') ? 'checked' : ''; ?>> 予約難
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>住所 <span class="required-mark">※</span>
                <?php if (isset($errors['address'])): ?>
                        <span class="error-msg"><?php echo $errors['address']; ?></span>
                <?php endif; ?></label>
                <input type="text" name="address" placeholder="住所を入力" value="<?php echo Input::post('address'); ?>">
            </div>

            <div class="form-group">
                <label>電話番号 <span class="required-mark">※</span>
                    <?php if (isset($errors['phone_number'])): ?>
                        <span class="error-msg"><?php echo $errors['phone_number']; ?></span>
                    <?php endif; ?>
                </label>
                <input type="tel" name="phone_number" placeholder="電話番号を入力" value="<?php echo Input::post('phone_number'); ?>">
            </div>

            <div class="form-group">
                <label>定休日</label>
                <div class="checkbox-group">
                    <label class="checkbox-label"><input type="checkbox" name="closing_sun" value="1" <?php echo Input::post('closing_sun') ? 'checked' : ''; ?>> 日</label>
                    <label class="checkbox-label"><input type="checkbox" name="closing_mon" value="1" <?php echo Input::post('closing_mon') ? 'checked' : ''; ?>> 月</label>
                    <label class="checkbox-label"><input type="checkbox" name="closing_tue" value="1" <?php echo Input::post('closing_tue') ? 'checked' : ''; ?>> 火</label>
                    <label class="checkbox-label"><input type="checkbox" name="closing_wed" value="1" <?php echo Input::post('closing_wed') ? 'checked' : ''; ?>> 水</label>
                    <label class="checkbox-label"><input type="checkbox" name="closing_thu" value="1" <?php echo Input::post('closing_thu') ? 'checked' : ''; ?>> 木</label>
                    <label class="checkbox-label"><input type="checkbox" name="closing_fri" value="1" <?php echo Input::post('closing_fri') ? 'checked' : ''; ?>> 金</label>
                    <label class="checkbox-label"><input type="checkbox" name="closing_sat" value="1" <?php echo Input::post('closing_sat') ? 'checked' : ''; ?>> 土</label>
                    <label class="checkbox-label"><input type="checkbox" name="closing_hol" value="1" <?php echo Input::post('closing_hol') ? 'checked' : ''; ?>> 祝</label>
                    <label class="checkbox-label"><input type="checkbox" name="closing_irregular" value="1" <?php echo Input::post('closing_irregular') ? 'checked' : ''; ?>> 不定休</label>
                </div>
            </div>

            <div class="form-group">
                <label>ホームページ
                    <?php if (isset($errors['website_url'])): ?>
                        <span class="error-msg"><?php echo $errors['website_url']; ?></span>
                    <?php endif; ?>
                </label>
                <input type="text" name="website_url" placeholder="URLを入力" value="<?php echo Input::post('website_url'); ?>">
            </div>

            <div class="form-group">
                <label>ひとこと</label>
                <textarea name="note" rows="3" placeholder="ひとことを入力"><?php echo Input::post('note'); ?></textarea>
            </div>

            <div class="submit-area">
                <button type="submit" class="submit-btn">投稿する</button>
            </div>

        <?php echo Form::close(); ?>
    </div>
</div>

</body>
</html>