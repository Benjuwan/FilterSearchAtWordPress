<?php

// スクリプトとスタイルを適切にエンキューする方法 
function theme_name_scripts() {
	wp_enqueue_style( 'themeStyle', get_stylesheet_uri() );
  wp_enqueue_style( 'resetCss', get_template_directory_uri() . '/css/reset.css' );

  if(is_front_page() || is_search()){ // 左辺には「検索関連のスタイルをあてたいページ」を指定 
    wp_enqueue_style( 'searchCss', get_template_directory_uri() . '/searchpart/css/searchpart.css' );
    wp_enqueue_script( 'searchJs', get_template_directory_uri() . '/searchpart/js/forsearch.js' );
  }
}
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );


//全角スペースで検索語句を区切る
if(isset($_GET['s'])) $_GET['s']=mb_convert_kana($_GET['s'],'s','UTF-8');


/**
 * 更新・変更が必要な箇所は「----- xxxxx -----」で指定してあります。
 */


//検索対象にカスタム投稿タイプを含む
function include_cpt_search( $query ) {
    if ( $query->is_search ) {
      $query->set( 'post_type', '-----「カスタム投稿タイプ名」を記述-----' );
      // $query->set( 'post_type', [ 'hoge', 'foo' ] ); // CPTが複数ある場合は配列で指定 
    }
    return $query;
}
add_filter( 'pre_get_posts', 'include_cpt_search' );


// カスタムタクソノミー・カスタムフィールド関連
function custom_search($search, $wp_query) {
global $wpdb;
 
if (!$wp_query->is_search)
 return $search;

if (!isset($wp_query->query_vars))
 return $search;
 
$search_words = explode(' ', isset($wp_query->query_vars['s']) ? $wp_query->query_vars['s'] : '');
 if ( count($search_words) > 0 ) {
   $search = '';
   foreach ( $search_words as $word ) {
     if ( !empty($word) ) {
       $search_word = $wpdb->prepare("%%{$word}%%"); // プレースホルダーが使用できるprepare関数：'SQL文字定数の中で%を使う場合、LIKE のワイルドカードも含めて、 %% のように二重の % を書いてエスケープしなければなりません'
         
       $search .= " AND (
           {$wpdb->posts}.post_title LIKE '{$search_word}'
           OR {$wpdb->posts}.post_content LIKE '{$search_word}'
           
           OR {$wpdb->posts}.ID IN (
             SELECT distinct r.object_id
             FROM {$wpdb->term_relationships} AS r
             INNER JOIN {$wpdb->term_taxonomy} AS tt ON r.term_taxonomy_id = tt.term_taxonomy_id
             INNER JOIN {$wpdb->terms} AS t ON tt.term_id = t.term_id
             WHERE t.name LIKE '{$search_word}'
           OR t.slug LIKE '{$search_word}'
           OR tt.description LIKE '{$search_word}'
           )
           
           OR {$wpdb->posts}.ID IN (
             SELECT distinct post_id
             FROM {$wpdb->postmeta}
             WHERE {$wpdb->postmeta}.meta_key IN ('-----「メタ：フィールド名」を記述-----','-----「メタ：フィールド名」を記述-----','-----「メタ：フィールド名」を記述-----') AND meta_value LIKE '{$search_word}'
			     )
                
       ) ";
     }
   }
 }
 
 return $search;
 }
 add_filter('posts_search','custom_search', 10, 2);