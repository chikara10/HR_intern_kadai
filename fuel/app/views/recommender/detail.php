<!DOCTYPE html>
<html lang="ja">
<head>   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($place->name); ?>Recommender-詳細</title>
    <?php echo Asset::css('detail.css'); ?>
</head>
<body>

<div class="header-right">
    <?php if (Auth::check()): ?>
        <a href="<?php echo Uri::create('login/logout'); ?>" class="logout-btn">ログアウト</a>
    <?php else: ?>
        <a href="<?php echo Uri::create('login'); ?>" class="logout-btn">ログイン</a>
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

    <div class="content">
        <div class="header-area">
            <h1 class="place-name"><?php echo e($place->name); ?></h1>
            <div class="header-area-icons">
                <a href="<?php echo Uri::create('update/index/' . $place->id); ?>">
                    <?php echo Asset::img('update-icon.svg', [
                        'class' => 'update-icon',
                        'alt'   => 'update'
                    ]);?>
                </a>

                <a href="<?php echo Uri::create('post/delete/'.$place->id); ?>" 
                    class="btn-delete-link"
                    onclick="return confirm('本当にこの投稿を削除しますか?');">
                    <?php echo Asset::img('delete-icon.svg', [
                        'class' => 'delete-icon',
                        'alt'   => 'delete'
                    ]);?>
                </a>
            </div>
        </div>

        <span class="genre-badge">
            <?php echo e($place->genre ? $place->genre->name : '未設定'); ?>
        </span>

            <?php if ($place->reservable == 0): ?>
                <span class="reservable-badge res-ok">予約可</span>
            <?php elseif ($place->reservable == 1): ?>
                <span class="reservable-badge res-ng">予約不要</span>
            <?php elseif ($place->reservable == 2): ?>
                <span class="reservable-badge res-unk">予約不可</span>
            <?php elseif ($place->reservable == 3): ?>
                <span class="reservable-badge res-diff">予約難</span>
            <?php endif; ?>

        <div class='info'>
            <table class="info-table">
                <tr>
                    <th>
                        <?php echo Asset::img('address-icon.svg', [
                            'class' => 'address-icon',
                            'alt'   => 'address'
                        ]);?>
                    </th>
                    <td><?php echo e($place->address); ?></td>
                </tr>
                <tr>
                    <th>
                        <?php echo Asset::img('phone-icon.svg', [
                            'class' => 'phone-icon',
                            'alt'   => 'phone-number'
                        ]);?>
                    </th>
                    <td>
                        <?php if($place->phone_number): ?>
                            <a href="tel:<?php echo $place->phone_number; ?>" style="color:#333; text-decoration:none;" ><?php echo e($place->phone_number); ?></a>
                        <?php else: ?>
                            <span style="color:#999;">登録なし</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <?php echo Asset::img('closing-icon.svg', [
                            'class' => 'closing-icon',
                            'alt'   => 'closing-days'
                        ]);?>
                    </th>
                    <td><?php echo $closed_days_string; ?></td>
                </tr>
                <tr>
                    <th>
                        <?php echo Asset::img('url-icon.svg', [
                            'class' => 'url-icon',
                            'alt'   => 'url'
                        ]);?>
                    </th>
                    <td>
                        <?php if($place->website_url): ?>
                            <a href="<?php echo $place->website_url; ?>" target="_blank" class="btn btn-web">公式サイトを見る</a>
                        <?php else: ?>
                            <span class="btn btn-web disabled">公式サイトなし</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            
            <div class="detail-map">
                <?php if($place->place_id): ?>
                    <iframe
                        width="300px"
                        height="300px"
                        style="border:0"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA-nfAbhs2a2motzMwpLRM_KBWCqqHJXFg&q=place_id:<?php echo e($place->place_id); ?>">
                    </iframe>
                <?php else: ?>
                    <div class="no-map">地図情報がありません</div>
                <?php endif; ?>
            </div>
        </div>

        <table class="note-table">
            <tr>
                <th>
                    <?php echo Asset::img('note-icon.svg', [
                        'class' => 'note-icon',
                        'alt'   => 'note'
                    ]);?>
                </th>
                <td><?php echo nl2br(e($place->note)); ?></td>
            </tr>
        </table>
        
        

    </div>
</div>

<script>
    //更新成功時のアラート表示
    <?php if ($success_msg = Session::get_flash('success')): ?>
        window.alert("<?php echo $success_msg; ?>");
    <?php endif; ?>

    //削除失敗時のアラート表示
    <?php if ($error_msg = Session::get_flash('error')): ?>
        window.alert("<?php echo $error_msg; ?>");
    <?php endif; ?>
</script>

</body>
</html>