<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommender</title>
    <?php echo Asset::css('index.css'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.js"></script>
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
    
    <form class="search-container" data-bind="submit: search">
        <input type="text" class="search-input" placeholder="検索" data-bind="textInput: keyword">
        <button type="submit" class="search-btn">
            <?php echo Asset::img('search-icon.png'); ?>
        </button>
    </form>
</header>

<div class="filter-scroll">
    <a href="#" class="filter-btn" 
       data-bind="css: { active: selectedReservable() === null }, click: function() { setFilter(null) }">
        すべて
    </a>

    <a href="#" class="filter-btn" 
       data-bind="css: { active: selectedReservable() === '0' }, click: function() { setFilter('0') }">予約可</a>
    <a href="#" class="filter-btn" 
       data-bind="css: { active: selectedReservable() === '1' }, click: function() { setFilter('1') }">予約不要</a>
    <a href="#" class="filter-btn" 
       data-bind="css: { active: selectedReservable() === '2' }, click: function() { setFilter('2') }">予約不可</a>
    <a href="#" class="filter-btn" 
       data-bind="css: { active: selectedReservable() === '3' }, click: function() { setFilter('3') }">予約難</a>
</div>

<div class="place-list" data-bind="foreach: places">
    
    <a data-bind="attr: { href: detailUrl }" class="place-card">
        <div class="place-info">
            <div class="place-genre" data-bind="text: genre_name || 'ジャンル不明'"></div>
            
            <h2 class="place-name" data-bind="text: name"></h2>
            
            <div class="place-meta">
                <span class="status-badge" 
                      data-bind="text: $parent.getReservableText(reservable), css: $parent.getReservableClass(reservable)">
                </span>

                <div class="place-note" data-bind="text: note, visible: note"></div>
            </div>
        </div>
        <div style="color: #ccc;">&gt;</div>
    </a>

</div>

<p style="text-align:center; color:#999; margin-top:50px;" 
   data-bind="visible: places().length === 0">
    条件に合うお店が見つかりませんでした。
</p>

<a href="<?php echo Uri::create('post'); ?>" class="fab-btn">＋</a>

<script>
    // ViewModelの定義
    function AppViewModel() {
        var self = this;

        // 監視するデータ (Observable)
        self.keyword = ko.observable('');           // 検索ワード
        self.selectedReservable = ko.observable(null); // 選択中のフィルタ (null, '0', '1'...)
        self.places = ko.observableArray([]);       // お店リストデータ

        // APIのベースURL
        var apiUrl = "<?php echo Uri::create('api/search.json'); ?>";
        var detailBaseUrl = "<?php echo Uri::create('detail/index/'); ?>";

        // 検索実行関数
        self.search = function() {
            // パラメータ作成
            var params = new URLSearchParams();
            if (self.keyword()) params.append('q', self.keyword());
            if (self.selectedReservable() !== null) params.append('r', self.selectedReservable());

            // Fetch APIで非同期通信
            fetch(apiUrl + '?' + params.toString())
                .then(response => {
                    // 通信自体が失敗していないか確認
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data || !Array.isArray(data)) {
                        self.places([]); 
                        return;
                    }

                    // 取得したデータに詳細ページへのURLを追加して配列にセット
                    var mappedData = data.map(function(item) {
                        item.detailUrl = detailBaseUrl + item.id;
                        return item;
                    });
                    self.places(mappedData);
                })
                .catch(error => {
                    console.error('Error:', error);
                    self.places([]); 
                });
        };

        // フィルタ切り替え関数
        self.setFilter = function(value) {
            self.selectedReservable(value);
            self.search(); 
        };

        // 表示用ヘルパー関数：予約ステータスの文字
        self.getReservableText = function(val) {
            var map = { '0': '予約可', '1': '予約不要', '2': '予約不可', '3': '予約難' };
            return map[val] || '-';
        };

        // 表示用ヘルパー関数：予約ステータスの色クラス
        self.getReservableClass = function(val) {
            var map = { '0': 'status-ok', '1': 'status-free', '2': 'status-ng', '3': 'status-hard' };
            return map[val] || '';
        };

        // 初回ロード時に検索を実行
        self.search();
    }

    // バインディングの適用
    ko.applyBindings(new AppViewModel());

    //投稿成功時、削除成功時のアラート表示
    <?php if ($success_msg = Session::get_flash('success')): ?>
        window.alert("<?php echo $success_msg; ?>");
    <?php endif; ?>
</script>

</body>
</html>