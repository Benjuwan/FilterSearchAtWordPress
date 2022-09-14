<?php get_header(); ?>

<?php
// 検索結果のフラグ（記述必須）
$s = $_GET['s'];

// *各項目ごとに条件（チェックされていない場合）によって明示的に状態(null)を指定してやることでエラー回避
// 項目タイトル（$ConstSearchTargets）
if(!isset($_GET['get_searches']) || $_GET['get_searches'] === ''){
    $get_searches = null;
} else {
    $get_searches = $_GET['get_searches'];
}
// 項目[000]
if(!isset($_GET['get_searcharea']) || $_GET['get_searcharea'] === ''){
    $get_searcharea = null;
} else {
    $get_searcharea = $_GET['get_searcharea'];
}
// 項目[A]:1〜3
if(!isset($_GET['get_bunkei01']) || $_GET['get_bunkei01'] === ''){
    $get_bunkei01 = null;
} else {
    $get_bunkei01 = $_GET['get_bunkei01'];
}
if(!isset($_GET['get_bunkei02']) || $_GET['get_bunkei02'] === ''){
    $get_bunkei02 = null;
} else {
    $get_bunkei02 = $_GET['get_bunkei02'];
}
if(!isset($_GET['get_bunkei03']) || $_GET['get_bunkei03'] === ''){
    $get_bunkei03 = null;
} else {
    $get_bunkei03 = $_GET['get_bunkei03'];
}
// 項目[B]:1〜2
if(!isset($_GET['get_bunri01']) || $_GET['get_bunri01'] === ''){
    $get_bunri01 = null;
} else {
    $get_bunri01 = $_GET['get_bunri01'];
}
if(!isset($_GET['get_bunri02']) || $_GET['get_bunri02'] === ''){
    $get_bunri02 = null;
} else {
    $get_bunri02 = $_GET['get_bunri02'];
}
// 項目[C]:1〜4
if(!isset($_GET['get_rikei01']) || $_GET['get_rikei01'] === ''){
    $get_rikei01 = null;
} else {
    $get_rikei01 = $_GET['get_rikei01'];
}
if(!isset($_GET['get_rikei02']) || $_GET['get_rikei02'] === ''){
    $get_rikei02 = null;
} else {
    $get_rikei02 = $_GET['get_rikei02'];
}
if(!isset($_GET['get_rikei03']) || $_GET['get_rikei03'] === ''){
    $get_rikei03 = null;
} else {
    $get_rikei03 = $_GET['get_rikei03'];
}
if(!isset($_GET['get_rikei04']) || $_GET['get_rikei04'] === ''){
    $get_rikei04 = null;
} else {
    $get_rikei04 = $_GET['get_rikei04'];
}
// 項目[D]〜項目[K]
if(!isset($_GET['get_voc01']) || $_GET['get_voc01'] === ''){
    $get_voc01 = null;
} else {
    $get_voc01 = $_GET['get_voc01'];
}
if(!isset($_GET['get_voc02']) || $_GET['get_voc02'] === ''){
    $get_voc02 = null;
} else {
    $get_voc02 = $_GET['get_voc02'];
}
if(!isset($_GET['get_voc03']) || $_GET['get_voc03'] === ''){
    $get_voc03 = null;
} else {
    $get_voc03 = $_GET['get_voc03'];
}
if(!isset($_GET['get_voc04']) || $_GET['get_voc04'] === ''){
    $get_voc04 = null;
} else {
    $get_voc04 = $_GET['get_voc04'];
}
if(!isset($_GET['get_voc05']) || $_GET['get_voc05'] === ''){
    $get_voc05 = null;
} else {
    $get_voc05 = $_GET['get_voc05'];
}
if(!isset($_GET['get_voc06']) || $_GET['get_voc06'] === ''){
    $get_voc06 = null;
} else {
    $get_voc06 = $_GET['get_voc06'];
}
if(!isset($_GET['get_voc07']) || $_GET['get_voc07'] === ''){
    $get_voc07 = null;
} else {
    $get_voc07 = $_GET['get_voc07'];
}
if(!isset($_GET['get_voc08']) || $_GET['get_voc08'] === ''){
    $get_voc08 = null;
} else {
    $get_voc08 = $_GET['get_voc08'];
}

/* 
    科目で【どれか（get_bunkei01 〜 get_voc08まで）選択されている場合のみ】$get_majorがtrueになる。
    この条件分岐がないと、$get_majorは常にtrueとなり、絞り込み検索時の他の条件にまで割り込んでくる
 */
if( $get_bunkei01 || $get_bunkei02 || $get_bunkei03 || $get_bunri01 || $get_bunri02 || $get_rikei01 || $get_rikei02 || $get_rikei03 || $get_rikei04 || $get_voc01 || $get_voc03 || $get_voc03 || $get_voc05 || $get_voc05 || $get_voc06 || $get_voc07 || $get_voc08 ){
$get_major = [ // 項目[アルファベット]の内容をまとめて管理する小分け用の配列
    $get_bunkei01,
    $get_bunkei02,
    $get_bunkei03,
    $get_bunri01,
    $get_bunri02,
    $get_rikei01,
    $get_rikei02,
    $get_rikei03,
    $get_rikei04,
    $get_voc01,
    $get_voc02,
    $get_voc03,
    $get_voc04,
    $get_voc05,
    $get_voc06,
    $get_voc07,
    $get_voc08
    ];
} else {
    $get_major = null; // 明示的に状態(null)を指定してやることでエラー回避
}

$get_cats = [ // 各検索項目を格納する総合配列（箱）
    $s,
    $get_searches,
    $get_searcharea,
    $get_major
    ];

    // 以下は検索結果ページで各コンテンツを表示する(WP_QueryのtaxQueryで使用する)ための記述
    $tax_searches = [
		'taxonomy' => 'school_cat', // タクソノミー名
		'field' => 'slug', // スラッグでの指定を明記
		'terms' => $get_searches, // 当該タクソノミーに該当する(検索項目/タームの)変数名を指定（変数名の命名は検索項目の変数名とリンクしたようなものにしたほうが無難）
		'operator' => 'IN', // ('AND'どちらも(AND検索) / 'IN'どちらか(OR検索) / 'NOT IN'それら以外)
        ];
    $tax_searcharea = [
		'taxonomy' => 'search_area',
		'field' => 'slug',
		'terms' => $get_searcharea,
		'operator' => 'IN', 
        ];
    $tax_bnk01 = [
		'taxonomy' => 'bunkei',
		'field' => 'slug',
		'terms' => $get_bunkei01,
		'operator' => 'IN', 
        ];
    $tax_bnk02 = [
		'taxonomy' => 'bunkei',
		'field' => 'slug',
		'terms' => $get_bunkei02,
		'operator' => 'IN', 
        ];
    $tax_bnk03 = [
		'taxonomy' => 'bunkei',
		'field' => 'slug',
		'terms' => $get_bunkei03,
		'operator' => 'IN', 
        ];
    $tax_bunri01 = [
		'taxonomy' => 'bunri',
		'field' => 'slug',
		'terms' => $get_bunri01,
		'operator' => 'IN', 
        ];
    $tax_bunri02 = [
		'taxonomy' => 'bunri',
		'field' => 'slug',
		'terms' => $get_bunri02,
		'operator' => 'IN', 
        ];
    $tax_rk01 = [
		'taxonomy' => 'rikei',
		'field' => 'slug',
		'terms' => $get_rikei01,
		'operator' => 'IN', 
        ];
    $tax_rk02 = [
		'taxonomy' => 'rikei',
		'field' => 'slug',
		'terms' => $get_rikei02,
		'operator' => 'IN', 
        ];
    $tax_rk03 = [
		'taxonomy' => 'rikei',
		'field' => 'slug',
		'terms' => $get_rikei03,
		'operator' => 'IN', 
        ];
    $tax_rk04 = [
		'taxonomy' => 'rikei',
		'field' => 'slug',
		'terms' => $get_rikei04,
		'operator' => 'IN', 
        ];
    $tax_vd01 = [
		'taxonomy' => 'search_vocational',
		'field' => 'slug',
		'terms' => $get_voc01,
		'operator' => 'IN', 
        ];
    $tax_vd02 = [
		'taxonomy' => 'search_vocational',
		'field' => 'slug',
		'terms' => $get_voc02,
		'operator' => 'IN', 
        ];
    $tax_vd03 = [
		'taxonomy' => 'search_vocational',
		'field' => 'slug',
		'terms' => $get_voc03,
		'operator' => 'IN', 
        ];
    $tax_vd04 = [
		'taxonomy' => 'search_vocational',
		'field' => 'slug',
		'terms' => $get_voc04,
		'operator' => 'IN', 
        ];
    $tax_vd05 = [
		'taxonomy' => 'search_vocational',
		'field' => 'slug',
		'terms' => $get_voc05,
		'operator' => 'IN', 
        ];
    $tax_vd06 = [
		'taxonomy' => 'search_vocational',
		'field' => 'slug',
		'terms' => $get_voc06,
		'operator' => 'IN', 
        ];
    $tax_vd07 = [
		'taxonomy' => 'search_vocational',
		'field' => 'slug',
		'terms' => $get_voc07,
		'operator' => 'IN', 
        ];
    $tax_vd08 = [
		'taxonomy' => 'search_vocational',
		'field' => 'slug',
		'terms' => $get_voc08,
		'operator' => 'IN', 
        ];
?>


<!-- <?php var_dump($get_cats); ?> -->


<!--////////////////////// 絞り込み検索用 //////////////////////-->

<!-- 
    ----
        ポイント：検索結果の「件数表示」&「コンテンツ表示」ともに
        「$get_cats(総合配列)に【何(の変数：検索結果)が入って(セットされて)いるか】を明示的に指定していくこと」
    ----
 -->

<?php if( is_post_type_archive('school') && $get_cats = isset($s) || isset($get_searches) || isset($get_searcharea) || isset($get_major) ): ?>

 <!-- 
    ----
        ここから、検索結果の件数表示に関する記述
    ----
 -->

<h2 class="search_h2">

    <!--//////////////// フリーワード（と項目タイトル：$ConstSearchTargets）を含んだ検索用 ////////////////-->
    <?php if( get_search_query() && $get_cats = !isset($get_searcharea) && !isset($get_major) && isset($get_searches) ): ?>

        <?php
        foreach ($get_searches as $val) {
            $SchoolTypeSlug = get_term_by('slug', $val, 'school_cat');
        // var_dump($SchoolTypeSlug);
        }
        printf( __( '検索結果 %s', 'altitude' ), '<span id="SerachKeywords">'. htmlspecialchars($SchoolTypeSlug->name, ENT_QUOTES) .'で、フリーワード：'. esc_html( get_search_query() ) . '</span>' ); // echoと同義  ?>
            <?php $allsearch = new WP_Query([
            'posts_per_page' => -1, // 全件取得
            'post_type' => 'school', // カスタム投稿タイプを指定
            'tax_query' => [
                'relation' => 'AND',
                [
                $tax_searches,
                ],
                ],
            's' => $s, // 検索結果のフラグ（記述必須）
            ]);
            $key = esc_html($s, 1);
            $count = $allsearch->post_count;
            if($count!=0 && !$get_cats){ // 0件以上あり（検索にヒットして）+ 検索項目がない場合
            echo wp_kses_post( '<p class="search_infotxt">"<strong>'.$key.'</strong>"で検索した結果、<strong>'.$count.'</strong>件ヒットしました。</p>' );
            }
            wp_reset_postdata();
            ?>

    <?php elseif( $get_cats = isset($get_searches) && isset($get_searcharea) && isset($get_major) ): //（$ConstSearchTargets + 項目[000] + 小分け用配列($get_major)の絞り込み検索） ?>

        <?php $all_search = new WP_Query([
        'posts_per_page' => -1,
        'post_type' => 'school',
        'tax_query' => [
            'relation' => 'AND', // $ConstSearchTargets と 項目[000] はAND検索
            [
            $tax_searches,
            ],
            [
            $tax_searcharea,
            ],
            [
            'relation' => 'OR', // 小分け用配列($get_major)の項目はOR検索(*A)
            $tax_bnk01,
            $tax_bnk02,
            $tax_bnk03,
            $tax_bunri01,
            $tax_bunri02,
            $tax_rk01,
            $tax_rk02,
            $tax_rk03,
            $tax_rk04,
            $tax_vd01,
            $tax_vd02,
            $tax_vd03,
            $tax_vd04,
            $tax_vd05,
            $tax_vd06,
            $tax_vd07,
            $tax_vd08
            ],
            ],
        's' => $s,
        ]);
        $count = $all_search->post_count;
        if($count!=0){
        echo wp_kses_post('<p class="search_infotxt">該当件数：<strong>'.$count.'</strong>件</p>');
        }
        wp_reset_postdata();
        ?>

        <!-- 
            *A：小分け用配列($get_major)もAND検索にしたい場合は【各項目ごとに条件分岐を作って行く必要】がある。
            例：?php elseif( 
                $get_cats = isset($get_searches) && 
                isset($get_searcharea) && 
                isset($get_小分けの中身AA) && 
                isset($get_小分けの中身BB) && 
                !isset($get_小分けの中身BB) // falseの分岐も各項目ごとに指定していかなくてならない....
                .... ): ?
        -->


    <?php elseif( $get_cats = isset($get_searches) && !isset($get_searcharea) && isset($get_major) )://　$ConstSearchTargets + 小分け用配列($get_major) の絞り込み検索（項目[000]は無し） ?>

    <?php $all_search = new WP_Query([
        'posts_per_page' => -1,
        'post_type' => 'school',
        'tax_query' => [
            'relation' => 'AND',
            [
            $tax_searches,
            ],
            [
            'relation' => 'OR',
            $tax_bnk01,
            $tax_bnk02,
            $tax_bnk03,
            $tax_bunri01,
            $tax_bunri02,
            $tax_rk01,
            $tax_rk02,
            $tax_rk03,
            $tax_rk04,
            $tax_vd01,
            $tax_vd02,
            $tax_vd03,
            $tax_vd04,
            $tax_vd05,
            $tax_vd06,
            $tax_vd07,
            $tax_vd08
            ],
            ],
        's' => $s,
    ]);
    $count = $all_search->post_count;
    if($count!=0){
    echo wp_kses_post('<p class="search_infotxt">該当件数：<strong>'.$count.'</strong>件</p>');
    }
    wp_reset_postdata();
    ?>


    <?php elseif( $get_cats = isset($get_searches) && isset($get_searcharea) && !isset($get_major) )://$ConstSearchTargets + 項目[000]の絞り込み検索（小分け用配列($get_major)は無し） ?>

    <?php $all_search = new WP_Query([
        'posts_per_page' => -1,
        'post_type' => 'school',
        'tax_query' => [
            'relation' => 'AND',
            [
            $tax_searches,
            ],
            [
            $tax_searcharea,
            ],
            ],
        's' => $s,
    ]);
    $count = $all_search->post_count;
    if($count!=0){
    echo wp_kses_post('<p class="search_infotxt">該当件数：<strong>'.$count.'</strong>件</p>');
    }
    wp_reset_postdata();
    ?>


    <?php elseif( $get_cats = !isset($get_searches) && !isset($get_searcharea) && isset($get_major) ): // 小分け用配列($get_major)のみの絞り込み検索 ?>

    <?php $all_search = new WP_Query([
        'posts_per_page' => -1,
        'post_type' => 'school',
        'tax_query' => [
            [
            'relation' => 'OR',
            $tax_bnk01,
            $tax_bnk02,
            $tax_bnk03,
            $tax_bunri01,
            $tax_bunri02,
            $tax_rk01,
            $tax_rk02,
            $tax_rk03,
            $tax_rk04,
            $tax_vd01,
            $tax_vd02,
            $tax_vd03,
            $tax_vd04,
            $tax_vd05,
            $tax_vd06,
            $tax_vd07,
            $tax_vd08
            ],
            ],
        's' => $s,
    ]);
    $count = $all_search->post_count;
    if($count!=0){
    echo wp_kses_post('<p class="search_infotxt">該当件数：<strong>'.$count.'</strong>件</p>');
    }
    wp_reset_postdata();
    ?>


    <?php elseif( $get_cats = !isset($get_searches) && !isset($get_major) && isset($get_searcharea) ): // 項目[000]のみの絞り込み検索 ?>

    <?php $all_search = new WP_Query([
        'posts_per_page' => -1,
        'post_type' => 'school',
        'tax_query' => [
        [
        'relation' => 'OR',
        $tax_searcharea
        ],
        ],
        's' => $s,
    ]);
    $count = $all_search->post_count;
    if($count!=0){
    echo wp_kses_post('<p class="search_infotxt">該当件数：<strong>'.$count.'</strong>件</p>');
    }
    wp_reset_postdata();
    ?>


    <?php elseif( $get_cats = isset($get_searches) && !isset($get_major) && !isset($get_searcharea) ): // $ConstSearchTargetsのみの絞り込み検索 ?>

    <?php $all_search = new WP_Query([
        'posts_per_page' => -1,
        'post_type' => 'school',
        'tax_query' => [
        [
        'relation' => 'OR',
        $tax_searches
        ],
        ],
        's' => $s,
    ]);
    $count = $all_search->post_count;
    if($count!=0){
    echo wp_kses_post('<p class="search_infotxt">該当件数：<strong>'.$count.'</strong>件</p>');
    }
    wp_reset_postdata();
    ?>


    <?php endif; ?>
   
   
    
    <!--//////////////// フリーワード（と$ConstSearchTargets）を含んだ検索用 ////////////////-->
    <?php if( get_search_query() && $get_cats = !isset($get_searcharea) && !isset($get_major) && isset($get_searches) ): // 項目[000] + 小分け用配列($get_major)は無し ?>
        <?php $KeywordsAndSchoolType = new WP_Query([
            'posts_per_page' => -1,
            'post_type' => 'school',
            'tax_query' => [
                'relation' => 'AND',
                [
                $tax_searches,
                ],
                ],
            's' => $s,
        ]);
            $count = $KeywordsAndSchoolType->post_count;
            if($count!=0){
            echo wp_kses_post( '<p class="search_infotxt"><strong>'.$count.'</strong>件ヒットしました。</p>' );
            }
        wp_reset_postdata();
        ?>
    <?php else: ?>
        <?php echo '<p id="array_word"><span>検索語句</span>';
            if($s){
                $key = esc_html($s, 1);
                echo wp_kses_post( '<small>フリーワード：'.$key.'</small>' );
                }
            if($get_searches){
            foreach ($get_searches as $val) {
                $search_schooltype_term = get_term_by('slug', $val, 'school_cat');
                echo wp_kses_post( '<small>'.$search_schooltype_term->name.'</small>' );
                    }
                }
            if($get_searcharea){
            foreach ($get_searcharea as $val) {
                $search_area_term = get_term_by('slug', $val, 'search_area');
                echo wp_kses_post( '<small>'.$search_area_term->name.'</small>' );
                }
                }
            if($get_bunkei01){
                foreach ($get_bunkei01 as $val) {
                $args01_term = get_term_by('slug', $val, 'bunkei');
                echo wp_kses_post( '<small>'.$args01_term->name.'</small>' );
                    }
                }
            if($get_bunkei02){
                foreach ($get_bunkei02 as $val) {
                $args02_term = get_term_by('slug', $val, 'bunkei');
                echo wp_kses_post( '<small>'.$args02_term->name.'</small>' );
                    }
                }
            if($get_bunkei03){
                foreach ($get_bunkei03 as $val) {
                $args03_term = get_term_by('slug', $val, 'bunkei');
                echo wp_kses_post( '<small>'.$args03_term->name.'</small>' );
                    }
                }
            if($get_bunri01){
                foreach ($get_bunri01 as $val) {
                $args04_term = get_term_by('slug', $val, 'bunri');
                echo wp_kses_post( '<small>'.$args04_term->name.'</small>' );
                    }
                }
            if($get_bunri02){
                foreach ($get_bunri02 as $val) {
                $args05_term = get_term_by('slug', $val, 'bunri');
                echo wp_kses_post( '<small>'.$args05_term->name.'</small>' );
                    }
                }
            if($get_rikei01){
                foreach ($get_rikei01 as $val) {
                $args06_term = get_term_by('slug', $val, 'rikei');
                echo wp_kses_post( '<small>'.$args06_term->name.'</small>' );
                    }
                }
            if($get_rikei02){
                foreach ($get_rikei02 as $val) {
                $args07_term = get_term_by('slug', $val, 'rikei');
                echo wp_kses_post( '<small>'.$args07_term->name.'</small>' );
                    }
                }
            if($get_rikei03){
                foreach ($get_rikei03 as $val) {
                $args08_term = get_term_by('slug', $val, 'rikei');
                echo wp_kses_post( '<small>'.$args08_term->name.'</small>' );
                    }
                }
            if($get_rikei04){
                foreach ($get_rikei04 as $val) {
                $args09_term = get_term_by('slug', $val, 'rikei');
                echo wp_kses_post( '<small>'.$args09_term->name.'</small>' );
                    }
                }
            if($get_voc01){
                foreach ($get_voc01 as $val) {
                $args010_term = get_term_by('slug', $val, 'search_vocational');
                echo wp_kses_post( '<small>'.$args010_term->name.'</small>' );
                    }
                }
            if($get_voc02){
                foreach ($get_voc02 as $val) {
                $args011_term = get_term_by('slug', $val, 'search_vocational');
                echo wp_kses_post( '<small>'.$args011_term->name.'</small>' );
                    }
                }
            if($get_voc03){
                foreach ($get_voc03 as $val) {
                $args012_term = get_term_by('slug', $val, 'search_vocational');
                echo wp_kses_post( '<small>'.$args012_term->name.'</small>' );
                    }
                }
            if($get_voc04){
                foreach ($get_voc04 as $val) {
                $args013_term = get_term_by('slug', $val, 'search_vocational');
                echo wp_kses_post( '<small>'.$args013_term->name.'</small>' );
                    }
                }
            if($get_voc05){
                foreach ($get_voc05 as $val) {
                $args014_term = get_term_by('slug', $val, 'search_vocational');
                echo wp_kses_post( '<small>'.$args014_term->name.'</small>' );
                    }
                }
            if($get_voc06){
                foreach ($get_voc06 as $val) {
                $args015_term = get_term_by('slug', $val, 'search_vocational');
                echo wp_kses_post( '<small>'.$args015_term->name.'</small>' );
                    }
                }
            if($get_voc07){
                foreach ($get_voc07 as $val) {
                $args016_term = get_term_by('slug', $val, 'search_vocational');
                echo wp_kses_post( '<small>'.$args016_term->name.'</small>' );
                    }
                }
            if($get_voc08){
                foreach ($get_voc08 as $val) {
                $args017_term = get_term_by('slug', $val, 'search_vocational');
                echo wp_kses_post( '<small>'.$args017_term->name.'</small>' );
                    }
                }
        echo '</p>'; ?>
    <?php endif; ?>

</h2>

<div class="searchAgain">
    <button>もう一度検索する(Search again)</button>
    <div id="search_details_box">
        <div>
            <!-- 
                ・ルート直下の場合：get_template_part('part', 'filtersearch');
                ・ディレクトリ配下の場合：get_template_part('任意のディレクトリ/part-filtersearch(テンプレートパーツ名)');
            -->
            <?php get_template_part('searchpart/part-filtersearch'); ?>
        </div>
    </div>
</div>

<!-- 
    ----
        ここまで、検索結果の件数表示に関する記述
    ----
-->



<!-- 
    ----
        ここから、コンテンツ表示に関する記述
    ----
-->

    <?php if( get_search_query() && $get_cats = !isset($get_searcharea) && !isset($get_major) && isset($get_searches) ): // フリーワード（と$ConstSearchTargets）を含んだ検索用 ?>

    <?php
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1; // ページ送りの機能に必須
        $my_query = new WP_Query( [
            'posts_per_page' => 6, // 6件ずつ表示
            'paged' => get_query_var('paged',0), // ページャー用
            'post_type' => 'school', // カスタム投稿タイプを指定
            'tax_query' => [
                'relation' => 'AND',
                [
                $tax_searches,
                ],
                ],
            's' => $s,
    ]); ?>


    <?php elseif( $get_cats = isset($get_searches) && isset($get_searcharea) && isset($get_major) ): //（$ConstSearchTargets + 項目[000] + 小分け用配列($get_major)の絞り込み検索） ?>

    <?php
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1; // ページ送りの機能に必須
        $my_query = new WP_Query( [
            'posts_per_page' => 6,
            'paged' => get_query_var('paged',0),
            'post_type' => 'school',
            'tax_query' => [
                'relation' => 'AND',
                [
                $tax_searches
                ],
                [
                $tax_searcharea
                ],
                [
            'relation' => 'OR', // *A
                $tax_bnk01,
                $tax_bnk02,
                $tax_bnk03,
                $tax_bunri01,
                $tax_bunri02,
                $tax_rk01,
                $tax_rk02,
                $tax_rk03,
                $tax_rk04,
                $tax_vd01,
                $tax_vd02,
                $tax_vd03,
                $tax_vd04,
                $tax_vd05,
                $tax_vd06,
                $tax_vd07,
                $tax_vd08
                ],
                ],
            's' => $s,
            ]); ?>


            <!-- 
            *A：小分け用配列($get_major)もAND検索にしたい場合は【各項目ごとに条件分岐を作って行く必要】がある。
            例：?php elseif( 
                $get_cats = isset($get_searches) && 
                isset($get_searcharea) && 
                isset($get_小分けの中身AA) && 
                isset($get_小分けの中身BB) && 
                !isset($get_小分けの中身BB) // falseの分岐も各項目ごとに指定していかなくてならない....
                .... ): ?
            -->


    <?php elseif( $get_cats = isset($get_searches) && !isset($get_searcharea) && isset($get_major) ): // $ConstSearchTargets + 小分け用配列($get_major)の絞り込み検索（項目[000]は無し） ?>

    <?php
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1; //ページ送りの機能に必須
        $my_query = new WP_Query( [
            'posts_per_page' => 6,
            'paged' => get_query_var('paged',0),
            'post_type' => 'school',
            'tax_query' => [
                'relation' => 'AND',
                [
                $tax_searches
                ],
                [
            'relation' => 'OR', 
                $tax_bnk01,
                $tax_bnk02,
                $tax_bnk03,
                $tax_bunri01,
                $tax_bunri02,
                $tax_rk01,
                $tax_rk02,
                $tax_rk03,
                $tax_rk04,
                $tax_vd01,
                $tax_vd02,
                $tax_vd03,
                $tax_vd04,
                $tax_vd05,
                $tax_vd06,
                $tax_vd07,
                $tax_vd08
                ],
                ],
            's' => $s,
            ]); ?>


    <?php elseif( $get_cats = isset($get_searches) && isset($get_searcharea) && !isset($get_major) ): // $ConstSearchTargets + 項目[000]の絞り込み検索（小分け用配列($get_major)は無し） ?>

    <?php
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1; // ページ送りの機能に必須
        $my_query = new WP_Query( [
            'posts_per_page' => 6,
            'paged' => get_query_var('paged',0),
            'post_type' => 'school',
            'tax_query' => [
                'relation' => 'AND',
                [
                $tax_searches
                ],
                [
                $tax_searcharea   
                ]
                ],
            's' => $s,
            ]); ?>
        
        
    <?php elseif( $get_cats = !isset($get_searches) && !isset($get_searcharea) && isset($get_major) ): // 小分け用配列($get_major)のみの絞り込み検索 ?>

    <?php
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1; // ページ送りの機能に必須
        $my_query = new WP_Query( [
            'posts_per_page' => 6,
            'paged' => get_query_var('paged',0),
            'post_type' => 'school',
            'tax_query' => [
            'relation' => 'OR', 
                $tax_bnk01,
                $tax_bnk02,
                $tax_bnk03,
                $tax_bunri01,
                $tax_bunri02,
                $tax_rk01,
                $tax_rk02,
                $tax_rk03,
                $tax_rk04,
                $tax_vd01,
                $tax_vd02,
                $tax_vd03,
                $tax_vd04,
                $tax_vd05,
                $tax_vd06,
                $tax_vd07,
                $tax_vd08
                ],
            's' => $s,
            ]); ?>


    <?php elseif( $get_cats = !isset($get_searches) && !isset($get_major) && isset($get_searcharea) ): // 項目[000]のみの絞り込み検索 ?>

    <?php
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1; // ページ送りの機能に必須
        $my_query = new WP_Query( [
            'posts_per_page' => 6,
            'paged' => get_query_var('paged',0),
            'post_type' => 'school',
            'tax_query' => [
            'relation' => 'OR', 
            $tax_searcharea
                ],
            's' => $s,
            ]); ?>


    <?php elseif( $get_cats = isset($get_searches) && !isset($get_major) && !isset($get_searcharea) ): // $ConstSearchTargetsのみの絞り込み検索 ?>

    <?php
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1; // ページ送りの機能に必須
        $my_query = new WP_Query( [
            'posts_per_page' => 6,
            'paged' => get_query_var('paged',0),
            'post_type' => 'school',
            'tax_query' => [
            'relation' => 'OR', 
            $tax_searches
                ],
            's' => $s,
            ]); ?>

    <?php endif; ?>


    <main id="search_main">
        <!-- コンテンツの具体的な内容 -->
        <ul class="school_list">
            <?php if($my_query->have_posts() ) : ?>
                <?php while( $my_query->have_posts()) : $my_query->the_post(); ?>
                    <li>
                        <h3><a href="<?php the_permalink(); ?>" target="_blank">
                            <span><?php the_title(); ?></span>
                            <em><?php the_field('sc_area'); ?></em>
                        </a></h3>
                        <?php if(has_post_thumbnail()): ?>
                            <p class="thumbnail"><?php the_post_thumbnail(); ?></p>
                        <!--サムネイルが無い場合、ダミー写真を表示-->
                        <?php else: ?>
                            <p class="thumbnail"><img src="<?php echo esc_url( get_template_directory_uri().'/img/thumbnail-dammy.jpg' ); ?>" alt="ダミーサムネイル"></p>
                        <?php endif; ?>
                        <div class="list_subjectInfo">
                            <span>小見出し</span>
                        </div>
                        <?php if(get_field('sc_feature')): ?>
                            <h3 class="school_info">小見出し</h3>
                            <p><?php the_field('sc_feature'); ?></p>
                        <!--学校の特色がない場合、学科情報を表示-->
                        <?php elseif(!get_field('sc_feature')): ?>
                            <h3 class="school_info">小見出し</h3>
                            <p><?php the_field('sc_departmentInfo'); ?></p>
                        <?php endif; ?>
                        <?php if(get_field('sc_tuition')): ?>
                            <h3 class="school_info">小見出し</h3>
                            <p><?php the_field('sc_tuition'); ?></p>
                        <?php endif; ?>
                        <?php if(get_field('sc_support')): ?>
                            <h3 class="school_info">小見出し</h3>
                            <p><?php the_field('sc_support'); ?></p>
                        <?php endif; ?>
                        <ul class="seal-area">
                            <?php if(get_field('seal_item1')): ?>
                                <li><img src="<?php the_field('seal_item1'); ?>" /></li>
                            <?php endif; ?>
                            <?php if(get_field('seal_item2')): ?>
                                <li><img src="<?php the_field('seal_item2'); ?>" /></li>
                            <?php endif; ?>
                            <?php if(get_field('seal_item3')): ?>
                                <li><img src="<?php the_field('seal_item3'); ?>" /></li>
                            <?php endif; ?>
                            <?php if(get_field('seal_item4')): ?>
                                <li><img src="<?php the_field('seal_item4'); ?>" /></li>
                            <?php endif; ?>
                            <?php if(get_field('seal_item5')): ?>
                                <li><img src="<?php the_field('seal_item5'); ?>" /></li>
                            <?php endif; ?>
                            <?php if(get_field('seal_item6')): ?>
                                <li><img src="<?php the_field('seal_item6'); ?>" /></li>
                            <?php endif; ?>
                        </ul>
                        <a class="link_btn" href="<?php the_permalink(); ?>" target="_blank">詳細を確認する</a>
                    </li>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>

                <?php else: ?>
                <li id="no_search_txt" style="width:100%;border:none;background:transparent;margin:40px auto;text-align: center;"><h3>該当する項目・キーワードはございませんでした</h3></li>
            <?php endif; ?>
        </ul>
        <!-- コンテンツの具体的な内容 -->
        
        <?php if( $get_cats ): // 検索カテゴリ有無のif(wp_debug対策) ?>
        <div class="pn_link">
                <?php the_posts_pagination( [
                    'prev_text' => '&larr;',
                    'next_text' => '&rarr;',
	                'total' => $my_query->max_num_pages // $my_query（指定した配列名を記入）
                ] ); ?>
        </div>
        <?php endif; // 検索カテゴリ有無のendif(wp_debug対策) ?>

    </main>

<!-- 
    ----
        ここまで、コンテンツ表示に関する記述
    ----
-->

<?php endif; ?>

<?php get_footer(); ?>