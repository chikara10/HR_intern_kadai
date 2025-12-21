<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommender-新規登録</title>
    <?php echo Asset::css('auth.css'); ?>
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

<div class="auth-container">
    
    <div class="auth-card">
        <div class="page-subtitle">SIGN UP</div>

        <?php if (isset($error)): ?>
            <div class="alert-error">
                <?php 
                    if (is_array($error)) {
                        foreach ($error as $e) { echo $e . '<br>'; }
                    } else {
                        echo $error;
                    }
                ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo Uri::create('signup'); ?>" method="post">
            <?php echo Form::csrf(); ?>

            <div class="form-group">
                <label>ユーザー名</label>
                <input type="text" name="username" class="form-input">
            </div>

            <div class="form-group">
                <label>パスワード</label>
                <input type="password" name="password" class="form-input">
            </div>

            <div class="submit-area">
                <button type="submit" class="submit-btn">登録する</button>
            </div>
        </form>
        
        <a href="<?php echo Uri::create('login'); ?>" class="auth-link">
            ログイン画面へ戻る
        </a>
    </div>
</div>

</body>
</html>