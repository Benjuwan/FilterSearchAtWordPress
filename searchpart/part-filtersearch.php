<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url(home_url('/')); // 検索機能に記述必須 ?>">

<div class="department_wrapper">
    <div class="SearchWrapper">
        <div id="SearchMainWrapper">
        <h3>タイトル</h3>
            <div class="selectschoolWrapper">
                <p>項目タイトル</p>
                <?php 
                $ConstSearchTargets = [
                    // 'order' => 'DESC', // 'ASC'（昇順）, 'DESC'（降順）,【初期値】'ASC'
                    'value_field' => 'slug', // （フォームの）option要素の'value'属性へ入れるタームのフィールド(現状スラッグ)
                    'taxonomy'  => 'school_cat', // タクソノミー名
                    'name' => 'get_searches[]', // 当該検索項目を格納する配列
                    'id' => 'echoIdAttr', // 要素へ付与するid属性名を記述。初期値だと'name'に指定した内容になる
                    // 'show_option_none' => ('以下から選択'), // 初期プレースホルダー
                    'option_none_value' => '', // 未選択時のoption要素のvalue属性値を指定（空 = %5B%5D = []）
                    'exclude' => [240, 273], // 'tag_id=xxxx'のタームを除外 
                ]; 
                ?>
                <?php wp_dropdown_categories( $ConstSearchTargets ); // ドロップダウンメニューで変数（$ConstSearchTargets）の内容を出力 ?>
            </div>
            <div class="areaWrapper">
                <p>項目タイトル</p>
                <details class="SearchMenu" id="AreaBox">
                    <summary>項目[000]</summary>
                        <?php
                            $term_id = 163; // tag_id=xxxx：タグID（数値）を指定
                            $taxonomy_name = 'search_area'; // taxonomy=xxxx：タクソノミーSlug（文字列）を指定
                            $termchildren = get_term_children( $term_id, $taxonomy_name );
                                foreach ( $termchildren as $child ) :
                                $term = get_term_by( 'id', $child, $taxonomy_name );
                            ?>
                        <!-- 
                            (*A)
                            name属性：項目内容を格納する配列(name="xxxx[]")を用意（*ここで指定した配列の中身（ユーザーがチェックした選択項目）をsearch.php（検索結果ページ）で呼び出す）
                            value属性：タームスラッグを呼び出す(value="?php echo esc_attr( $term->slug ); ?
                            ターム名を表示：?php echo esc_html( $term->name) ; ?
                         -->
                        <summary><label><input type="checkbox" name="get_searcharea[]" value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name) ; ?></label></summary>
                        <?php endforeach; ?>
                </details>
            </div>
            <div id="MajorBox">
                <div id="uniBox" class="inview">
                    <p>項目タイトル</p>
                    <details class="UniChildren">
                            <summary>項目[A]</summary>
                                <details>
                                    <summary>項目[A-1]</summary>
                                            <?php
                                            $term_id = 165; // tag_id=xxxx：タグID（数値）を指定
                                            $taxonomy_name = 'bunkei'; // taxonomy=xxxx：タクソノミーSlug（文字列）を指定
                                            $termchildren = get_term_children( $term_id, $taxonomy_name );
                                                foreach ( $termchildren as $child ) :
                                                $term = get_term_by( 'id', $child, $taxonomy_name );
                                            ?>
                                        <!-- (*A) -->
                                        <summary><label><input type="checkbox" name="get_bunkei01[]" value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name) ; ?></label></summary>
                                        <?php endforeach; ?>
                                </details>
                                <details>
                                        <summary>項目[A-2]</summary>
                                                <?php
                                                $term_id = 166; // tag_id=xxxx：タグID（数値）を指定
                                                $taxonomy_name = 'bunkei'; // taxonomy=xxxx：タクソノミーSlug（文字列）を指定
                                                $termchildren = get_term_children( $term_id, $taxonomy_name );
                                                    foreach ( $termchildren as $child ) :
                                                    $term = get_term_by( 'id', $child, $taxonomy_name );
                                                ?>
                                            <!-- (*A) -->
                                            <summary><label><input type="checkbox" name="get_bunkei02[]" value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name) ; ?></label></summary>
                                            <?php endforeach; ?>
                                </details>
                                <details>
                                        <summary>項目[A-3]</summary>
                                            <?php
                                            $term_id = 184; // tag_id=xxxx：タグID（数値）を指定
                                            $taxonomy_name = 'bunkei'; // taxonomy=xxxx：タクソノミーSlug（文字列）を指定
                                            $termchildren = get_term_children( $term_id, $taxonomy_name );
                                                foreach ( $termchildren as $child ) :
                                                $term = get_term_by( 'id', $child, $taxonomy_name );
                                            ?>
                                        <!-- (*A) -->
                                        <summary><label><input type="checkbox" name="get_bunkei03[]" value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name) ; ?></label></summary>
                                        <?php endforeach; ?>
                                </details>
                    </details>
                    <details class="UniChildren">
                            <summary>項目[B]</summary>
                                <details>
                                    <summary>項目[B-1]</summary>
                                        <?php
                                        $term_id = 178; // tag_id=xxxx：タグID（数値）を指定
                                        $taxonomy_name = 'bunri'; // taxonomy=xxxx：タクソノミーSlug（文字列）を指定
                                        $termchildren = get_term_children( $term_id, $taxonomy_name );
                                            foreach ( $termchildren as $child ) :
                                            $term = get_term_by( 'id', $child, $taxonomy_name );
                                        ?>
                                    <!-- (*A) -->
                                    <summary><label><input type="checkbox" name="get_bunri01[]" value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name) ; ?></label></summary>
                                    <?php endforeach; ?>
                                </details>
                                <details>
                                    <summary>項目[B-2]</summary>
                                        <?php
                                        $term_id = 194; // tag_id=xxxx：タグID（数値）を指定
                                        $taxonomy_name = 'bunri'; // taxonomy=xxxx：タクソノミーSlug（文字列）を指定
                                        $termchildren = get_term_children( $term_id, $taxonomy_name );
                                            foreach ( $termchildren as $child ) :
                                            $term = get_term_by( 'id', $child, $taxonomy_name );
                                        ?>
                                    <!-- (*A) -->
                                    <summary><label><input type="checkbox" name="get_bunri02[]" value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name) ; ?></label></summary>
                                    <?php endforeach; ?>
                                </details>
                    </details>
                    <details class="UniChildren">
                            <summary>項目[C]</summary>
                                <details>
                                    <summary>項目[C-1]</summary>
                                            <?php
                                            $term_id = 180; // tag_id=xxxx：タグID（数値）を指定
                                            $taxonomy_name = 'rikei'; // taxonomy=xxxx：タクソノミーSlug（文字列）を指定
                                            $termchildren = get_term_children( $term_id, $taxonomy_name );
                                                foreach ( $termchildren as $child ) :
                                                $term = get_term_by( 'id', $child, $taxonomy_name );
                                            ?>
                                        <!-- (*A) -->
                                        <summary><label><input type="checkbox" name="get_rikei01[]" value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name) ; ?></label></summary>
                                        <?php endforeach; ?>
                                </details>
                                <details>
                                    <summary>項目[C-2]</summary>
                                            <?php
                                            $term_id = 174; // tag_id=xxxx：タグID（数値）を指定
                                            $taxonomy_name = 'rikei'; // taxonomy=xxxx：タクソノミーSlug（文字列）を指定
                                            $termchildren = get_term_children( $term_id, $taxonomy_name );
                                                foreach ( $termchildren as $child ) :
                                                $term = get_term_by( 'id', $child, $taxonomy_name );
                                            ?>
                                        <!-- (*A) -->
                                        <summary><label><input type="checkbox" name="get_rikei02[]" value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name) ; ?></label></summary>
                                        <?php endforeach; ?>
                                </details>
                                <details>
                                    <summary>項目[C-3]</summary>
                                        <?php
                                        $term_id = 183; // tag_id=xxxx：タグID（数値）を指定
                                        $taxonomy_name = 'rikei'; // taxonomy=xxxx：タクソノミーSlug（文字列）を指定
                                        $termchildren = get_term_children( $term_id, $taxonomy_name );
                                            foreach ( $termchildren as $child ) :
                                            $term = get_term_by( 'id', $child, $taxonomy_name );
                                        ?>
                                    <!-- (*A) -->
                                    <summary><label><input type="checkbox" name="get_rikei03[]" value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name) ; ?></label></summary>
                                    <?php endforeach; ?>
                                </details>
                                <details>
                                    <summary>項目[C-4]</summary>
                                        <?php
                                        $term_id = 190; // tag_id=xxxx：タグID（数値）を指定
                                        $taxonomy_name = 'rikei'; // taxonomy=xxxx：タクソノミーSlug（文字列）を指定
                                        $termchildren = get_term_children( $term_id, $taxonomy_name );
                                            foreach ( $termchildren as $child ) :
                                            $term = get_term_by( 'id', $child, $taxonomy_name );
                                        ?>
                                    <!-- (*A) -->
                                    <summary><label><input type="checkbox" name="get_rikei04[]" value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name) ; ?></label></summary>
                                    <?php endforeach; ?>
                                </details>
                    </details>
                </div>
                <div id="VocBox">
                    <p>項目タイトル</p>
                    <div class="VocChilderen">
                        <details class="UniChildren">
                            <summary>項目[D]</summary>
                                    <?php
                                    $term_id = 278; // tag_id=xxxx：タグID（数値）を指定
                                    $taxonomy_name = 'search_vocational'; // taxonomy=xxxx：タクソノミーSlug（文字列）を指定
                                    $termchildren = get_term_children( $term_id, $taxonomy_name );
                                        foreach ( $termchildren as $child ) :
                                        $term = get_term_by( 'id', $child, $taxonomy_name );
                                    ?>
                                <!-- (*A) -->
                                <summary><label><input type="checkbox" name="get_voc01[]" value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name) ; ?></label></summary>
                                <?php endforeach; ?>
                        </details>
                        <details class="UniChildren">
                            <summary>項目[E]</summary>
                                    <?php
                                    $term_id = 201; // tag_id=xxxx：タグID（数値）を指定
                                    $taxonomy_name = 'search_vocational'; // taxonomy=xxxx：タクソノミーSlug（文字列）を指定
                                    $termchildren = get_term_children( $term_id, $taxonomy_name );
                                        foreach ( $termchildren as $child ) :
                                        $term = get_term_by( 'id', $child, $taxonomy_name );
                                    ?>
                                <!-- (*A) -->
                                <summary><label><input type="checkbox" name="get_voc02[]" value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name) ; ?></label></summary>
                                <?php endforeach; ?>
                        </details>
                        <details class="UniChildren">
                            <summary>項目[F]</summary>
                                <?php
                                $term_id = 206; // tag_id=xxxx：タグID（数値）を指定
                                $taxonomy_name = 'search_vocational'; // taxonomy=xxxx：タクソノミーSlug（文字列）を指定
                                $termchildren = get_term_children( $term_id, $taxonomy_name );
                                    foreach ( $termchildren as $child ) :
                                    $term = get_term_by( 'id', $child, $taxonomy_name );
                                ?>
                            <!-- (*A) -->
                            <summary><label><input type="checkbox" name="get_voc03[]" value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name) ; ?></label></summary>
                            <?php endforeach; ?>
                        </details>
                        <details class="UniChildren">
                            <summary>項目[G]</summary>
                                <?php
                                $term_id = 220; // tag_id=xxxx：タグID（数値）を指定
                                $taxonomy_name = 'search_vocational'; // taxonomy=xxxx：タクソノミーSlug（文字列）を指定
                                $termchildren = get_term_children( $term_id, $taxonomy_name );
                                    foreach ( $termchildren as $child ) :
                                    $term = get_term_by( 'id', $child, $taxonomy_name );
                                ?>
                            <!-- (*A) -->
                            <summary><label><input type="checkbox" name="get_voc04[]" value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name) ; ?></label></summary>
                            <?php endforeach; ?>
                        </details>
                        <details class="UniChildren">
                            <summary>項目[H]</summary>
                                <?php
                                $term_id = 205; // tag_id=xxxx：タグID（数値）を指定
                                $taxonomy_name = 'search_vocational'; // taxonomy=xxxx：タクソノミーSlug（文字列）を指定
                                $termchildren = get_term_children( $term_id, $taxonomy_name );
                                    foreach ( $termchildren as $child ) :
                                    $term = get_term_by( 'id', $child, $taxonomy_name );
                                ?>
                            <!-- (*A) -->
                            <summary><label><input type="checkbox" name="get_voc05[]" value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name) ; ?></label></summary>
                            <?php endforeach; ?>
                        </details>
                        <details class="UniChildren">
                            <summary>項目[I]</summary>
                                <?php
                                $term_id = 213; // tag_id=xxxx：タグID（数値）を指定
                                $taxonomy_name = 'search_vocational'; // taxonomy=xxxx：タクソノミーSlug（文字列）を指定
                                $termchildren = get_term_children( $term_id, $taxonomy_name );
                                    foreach ( $termchildren as $child ) :
                                    $term = get_term_by( 'id', $child, $taxonomy_name );
                                ?>
                            <!-- (*A) -->
                            <summary><label><input type="checkbox" name="get_voc06[]" value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name) ; ?></label></summary>
                            <?php endforeach; ?>
                        </details>
                        <details class="UniChildren">
                            <summary>項目[J]</summary>
                                <?php
                                $term_id = 216; // tag_id=xxxx：タグID（数値）を指定
                                $taxonomy_name = 'search_vocational'; // taxonomy=xxxx：タクソノミーSlug（文字列）を指定
                                $termchildren = get_term_children( $term_id, $taxonomy_name );
                                    foreach ( $termchildren as $child ) :
                                    $term = get_term_by( 'id', $child, $taxonomy_name );
                                ?>
                            <!-- (*A) -->
                            <summary><label><input type="checkbox" name="get_voc07[]" value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name) ; ?></label></summary>
                            <?php endforeach; ?>
                        </details>
                        <details class="UniChildren">
                            <summary>項目[K]</summary>
                                <?php
                                $term_id = 234; // tag_id=xxxx：タグID（数値）を指定
                                $taxonomy_name = 'search_vocational'; // taxonomy=xxxx：タクソノミーSlug（文字列）を指定
                                $termchildren = get_term_children( $term_id, $taxonomy_name );
                                    foreach ( $termchildren as $child ) :
                                    $term = get_term_by( 'id', $child, $taxonomy_name );
                                ?>
                            <!-- (*A) -->
                            <summary><label><input type="checkbox" name="get_voc08[]" value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name) ; ?></label></summary>
                            <?php endforeach; ?>
                        </details>
                    </div>
                </div>
            </div>
        </div>
        <div class="get_search">
            <!-- キーワード検索：「name="s" id="s"」は記述必須 -->
            <label><input type="search" placeholder="フリーワードを入力" value="" name="s" id="s"></label>
		</div>
    
        <!-- 
            記述必須：<input type="hidden" --------
            <input type="hidden" name="投稿タイプ" value="カスタム投稿タイプ（のスラッグ）名">
            // 呼び出したいカスタム投稿タイプの数だけ記述
            <input type="hidden" value="new" name="post_type">
            <input type="hidden" value="especially" name="post_type">
            
            // 検索結果ページで、検索キーワードをプレースホルダーに表示したい場合は下記を記述
            <input type="hidden" value="?php get_search_query(); ?" name="s" id="s">
        -->
        <input type="hidden" name="post_type" value="school">
        <p id="department_btn"><input type="submit" value="検索"></p>
    </div>
</div>

</form>