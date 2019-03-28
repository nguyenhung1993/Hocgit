<?php
// メールテンプレートディレクトリ
define('MAIL_TEMPLATE_DIR', dirname(__FILE__).'/mail');

// 動作モード
// define('FORM_ENV', 'development'); // 本番稼働時はコメントアウト
define('FORM_ENV', 'production');

// 設定
function consts($form_alias, $key)
{
    static $const;
    if (!$const) {
        //■学校法人
        $const['contact'] = array(
            'admin_to'       => array(
                'info@igai.co.jp',
            ),
            'admin_from'     => array('check@lionheart.co.jp', ''),
            'admin_subject'  => 'ホームページからお問い合わせがありました',
            'admin_template' => 'entry/admin.txt',
            'user_from'      => array('check@lionheart.co.jp', ''),
            'user_subject'   => 'お問い合わせありがとうございます',
            'user_template'  => 'entry/user.txt',
        );

        // ※開発テスト用
        // ※FORM_ENVが「production」以外の場合に使用
        $const['_debug_'] = array(
            'admin_to'       => array(
                 'check@lionheart.co.jp'
            ),
        );
    } // const end

    $parts = explode('.', $form_alias);
    $built = '';
    foreach ($parts as $k => $p) {
        $aliases[] = $built = ($k ? implode('.', array($built, $p)) : $p);
    }
    krsort($aliases);
    foreach ($aliases as $alias) {
        $v = aget($const, array($alias, $key));
        if ($v !== null) {
            return $v;
        }
    }
    return aget($const['default'], $key);
}
