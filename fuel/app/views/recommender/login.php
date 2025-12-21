<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン - Recommender</title>
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
        <div class="page-subtitle">LOGIN</div>

        <?php if (isset($error)): ?>
            <div class="alert-error">
                <?php echo is_array($error) ? implode('<br>', $error) : $error; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo Uri::create('login'); ?>" method="post">
            <?php echo Form::csrf(); ?>

            <div class="form-group">
                <label>ユーザー名</label>
                <input type="text" name="username" class="form-input" placeholder="" required>
            </div>

            <div class="form-group">
                <label>パスワード</label>
                <input type="password" name="password" class="form-input" placeholder="" required>
            </div>

            <div class="submit-area">
                <button type="submit" class="submit-btn">ログイン</button>
            </div>
        </form>

        <a href="<?php echo Uri::create('signup'); ?>" class="auth-link">
            サインアップはこちらから →
        </a>
    </div>
</div>

</body>
</html>