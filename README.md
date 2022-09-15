# FilterSearchAtWordPress
実装例URL：[http://ryugakuat.jp/morelearning](http://ryugakuat.jp/morelearning).



### 概要
WordPressサイトで使用できる「絞り込み（複数）検索機能」を実装するためのファイルセットです。検索項目（カテゴリー）の設定は《カスタムタクソノミー》を使用（左記や以下の説明で出てくるカテゴリーはタクソノミーを指します）

【ファイルセット】
```
|--- img：ダミーサムネイルの画像
    
|---searchpart
    |---css
        |--- _forsearch.scss：選択項目に関するスタイルシート
        |--- searchpart.scss：検索結果ページに関するスタイルシート（forsearchを@useで読み込んでいる）
            
    |--- js
        |--- forsearch.js：検索項目のカテゴリ別または表示中のページURL別の「項目内容の表示・非表示の切り替え」機能や「localStorageを使った検索履歴の保存」機能などを記述
            
    |--- part-filtersearch.php：検索項目用のテンプレートパーツファイル
        
|--- functions.php：中身は「必要なスクリプトやスタイルの読み込み」と「絞り込み検索機能に関する記述（DBからのデータ取得）」など
    
|--- search.php：検索結果ページ。part-filtersearch.php内で処理される配列（各検索項目の内容が格納された箱）から渡ってきた検索項目を取得し、WP_Query（とtaxQuery）を使ってコンテンツを表示させている。ページャーは the_posts_pagination を使用。
```


### 使い方・使用時の変更必要箇所
・part-filtersearch.php
```
|--- $term_id = 123; // tag_id=xxxx：タグID（数値）を指定
   $taxonomy_name = 'tax_slug'; // taxonomy=xxxx：タクソノミーSlug（文字列）を指定
      
   input type="checkbox" **name="get_searcharea[]"** value=" ?php echo esc_attr( $term->slug ); ? " ?php echo esc_html( $term->name) ; ?
     |--- name属性：項目内容を格納する配列(name="xxxx[]")を用意（ここで指定した配列の中身（ユーザーがチェックした選択項目）をsearch.php（検索結果ページ）で呼び出す）
     |--- value属性：タームスラッグを呼び出す(value="?php echo esc_attr( $term->slug ); ?
     |--- ターム名を表示：?php echo esc_html( $term->name) ; ?
        
|--- input type="hidden" name="投稿タイプ" value="カスタム投稿タイプ（のスラッグ）名" // 呼び出したいカスタム投稿タイプの数だけ記述
```  
    
・functions.php
```
|--- include_cpt_search：当該関数の第二引数に「-----「検索でヒットさせたいカスタム投稿タイプ名」を必要な分だけ記述----- 」

|--- custom_search：当該関数の WHERE {$wpdb->postmeta} にある IN へ「-----「検索でヒットさせたいメタ：フィールド名」を必要な分だけ記述-----」
```

・forsearch.js（以下は必要に応じて修正してください）
```
検索結果ページでの検索ボックスの表示ボタン関連
|--- そもそも不要ならコメントアウトで機能停止か削除してもよい

表示中のページURLにsearchs-slug001（カテゴリ別スラッグ）が含まれている場合
|--- 'searchs-slug001'や'searchs-slug002'と記述している箇所を「任意のslug名」に変更。そもそも不要なら〜以下同上。

セレクトボックスを選択して表示の切り替え（ selectと'change'イベント ）
|--- 同上

検索項目をlocalStorageに残して検索結果に反映（ここから）〜（ここまで）
|--- 同上
```


### 改良点
・検索結果表示に関する条件分岐に関して（search.php）

現状、**検索項目をまとめて格納している変数（$get_cats）の中身を「検索結果ごとに区分け」して条件分岐**しており、**検索結果の項目表示用見出し(h2)と当該コンテンツ用の2箇所に同じ記述**を行っている。

    
（例：検索結果ごとに区分け）
```
（search.php）
|--- ?php if( 
    get_search_query() && 
    $get_cats = 
        !isset($get_searcharea) && 
        !isset($get_major) && 
        isset($get_searches) 
    ): //（キーワード(get_search_query())とget_searchesがセットされている場合） ?
        
        
|--- ?php elseif( 
    $get_cats = 
        isset($get_searches) && 
        isset($get_searcharea) && 
        isset($get_major)
    ): // get_searches + get_searcharea + get_major の3種がセットされて（存在して）いる場合 ?
        
        
|--- ?php elseif( 
    $get_cats = 
        isset($get_searches) && 
        !isset($get_searcharea) && 
        isset($get_major)
    ): // get_searches + get_major の2種がセット ?
        
        
|--- ?php elseif( 
    $get_cats = 
        isset($get_searches) && 
        isset($get_searcharea) && 
        !isset($get_major) 
    ): // get_searches + get_searcharea の2種がセット ?
```

つまり、**各項目ごとにAND検索したい場合は各項目ごとに条件分岐を作って行く必要**がある。
```
?php elseif( 
    $get_cats = 
        isset($カテゴリA) && 
        isset($カテゴリB) && 
        isset($カテゴリC) && 
        isset($カテゴリD) && 
        !isset($カテゴリE) // **falseの分岐も各項目ごとに指定**していかなくてならない....
        ・
        ・
        ・
    ): 
?
```
これをもう少し整理してスマートにできればと試行錯誤....


・wpdb::prepare() のクエリー引数にはプレースホルダーが必要（functions.php）
```
（functions.php）
|--- $wpdb->prepare("%%{$word}%%"); 
```
prepare(第一引数：実行するsql, 第二引数：プレースホルダー)を使うには、第二引数：プレースホルダーが必須だが指定すると**wpdb::prepare() のクエリー引数にはプレースホルダーが必要（functions.php）**というエラー(notice)が表示される

```
$search_words = explode(' ', isset($wp_query->query_vars['s']) ? $wp_query->query_vars['s'] : ''); // **取得した検索キーワードを半角スペース区切りで配列へ変換**
 if ( count($search_words) > 0 ) { // **配列の中身が存在すれば下記の処理へ移行**
   $search = ''; // **プレースホルダー用の変数**
   foreach ( $search_words as $word ) { // **配列（$search_words）の中身をそれぞれ $word に**
     if ( !empty($word) ) { // **$wordが 空 || null で無いなら下記の処理へ移行**

      $sql_act = " AND ( // **実行するsql（※ここの記述に問題がある？？？）**
          {$wpdb->posts}.post_title LIKE '{$word}'
          OR {$wpdb->posts}.post_content LIKE '{$word}'
          
          OR {$wpdb->posts}.ID IN (
            SELECT distinct r.object_id
            FROM {$wpdb->term_relationships} AS r
            INNER JOIN {$wpdb->term_taxonomy} AS tt ON r.term_taxonomy_id = tt.term_taxonomy_id
            INNER JOIN {$wpdb->terms} AS t ON tt.term_id = t.term_id
            WHERE t.name LIKE '{$word}'
          OR t.slug LIKE '{$word}'
          OR tt.description LIKE '{$word}'
          )
          
          OR {$wpdb->posts}.ID IN (
            SELECT distinct post_id
            FROM {$wpdb->postmeta}
            WHERE {$wpdb->postmeta}.meta_key IN ('meta-field-slug','meta-field-slug','meta-field-slug','meta-field-slug','meta-field-slug','meta-field-slug') AND meta_value LIKE '{$word}'
          )
      ) ";

     $result .= $wpdb->prepare($sql_act, $search); // **結合した形で変数（返却値）に格納**

     } // if ( !empty($word) )
    } // foreach
 } // if ( count($search_words) > 0 )
 
 return $result;
```

### 注意点
検索履歴の保存機能に関して：「localStorage」はJavascriptから自由にアクセスできる性質のため「メールアドレス・住所・氏名など個人情報」に関する内容がある場合はセキュリティ面で大きな懸念がある。**デリケートな内容・項目がある場合は使用しない**こと（＝コメントアウトで機能停止させておく）

### 免責事項
こちらは個人・商用問わず自由にお使いください。連絡・報告も不要です。ただし、当該機能に関しての正確性や安全性、最新性、有用性などを制作者が保証するものではありません。利活用（編集・改変・再配布など）についてはユーザー自身の責任にて行われるものとし、ユーザーが利活用（編集・改変・再配布など）において直接的ないしは間接的に生じたいかなる損害についても一切の責任を負いません。
