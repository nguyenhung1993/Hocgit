<?php
/**
 * 処理について
 *
 * Webページ側の実装は全て
 * $form = contact_form(); (Formクラスのインスタンス化)から始まり、
 * この$form(Formクラスのインスタンス)にメソッドを投げる事で完結します。
 *
 * 全体はAdapterパターン的に実装されています。
 * 主な登場要素は下記です。
 *     Form クラス :
 *         埋め込むWebページが使用するクラス
 *     Form_Validator系クラス:
 *         Form内で使用する、入力チェックのためのクラス
 *     Form_Setting系クラス(adapter) : 
 *         Form, Form_Validator クラスの挙動を決定するクラス
 *
 * アダプタであるForm_Setting, Form_Validatorはサイト・機能によって共通だったり、分岐したりします。
 * どれを使うかは、FORM_ALIASという定数で判別されます。
 *
 * このFORM_ALIASという定数は、このスクリプトより前に定義しない限り、urlから自動決定されます。
 * ex: /cyouri/events/**.html ならば cyouri.eventsとなります。
 *
 * FORM_ALIAS定数が決定すると、使用するクラスを検索し、それを使用します。
 *
 * 検索方法: cyouri.eventsならば、
 *     Form_Setting_events_cyouri を探しに行き、
 *     無ければ Form_Setting_events を探しに行き、
 *     無ければ Form_Setting を使用。
 *     Validatorも同様のルールです。
 */
session_start();

/**
 * フォームの種類(FORM_ALIAS定数)を定義
 *
 * ※先行で定義されていない場合、urlから判別
 *
 */
if (!defined('FORM_ALIAS')) {
    $parts  = explode('/', $_SERVER['PHP_SELF']);
    array_pop($parts);
    $module = end($parts);
    array_pop($parts);
    $site   = end($parts);
    define('FORM_ALIAS', "{$site}.{$module}");
}

// 定数定義ファイル群
require_once dirname(__FILE__).'/__const__.php';

/**
 * 指定の動作モードであるか
 *
 */
function is_env($env)
{
    return FORM_ENV === $env;
}

/**
 * インスタンス生成
 *
 */
function contact_form()
{
    return new Form(FORM_ALIAS);
}

/**
 * 制御クラス
 *
 */
class Form
{
    public $setting;
    public $validator;

    public function __construct($form_alias)
    {
        // 該当するsettingクラスを決定しnewする
        $parts = explode('.', $form_alias);
        krsort($parts);
        $suffix    = '';
        $setting_base   = $setting   = "Form_Setting";
        $validator_base = $validator = "Form_Validator";
        foreach ($parts as $p) {
            $suffix .= "_{$p}";
            if (class_exists($cn = "{$setting_base}{$suffix}")) {
                $setting = $cn;
            }
            if (class_exists($cn = "{$validator_base}{$suffix}")) {
                $validator = $cn;
            }
        }
        $this->setting   = new $setting;
        $this->validator = new $validator;
    }

    /**
     * 保持している値の取得
     *
     */
    public function getKeep()
    {
        $s = session();
        return aget($s, 'params');
    }

    /**
     * 保持している値の更新
     *
     */
    public function setKeep($params)
    {
        $s = session();
        $s['params'] = $params;
        session($s);
        return true;
    }

    /**
     * 保持している値の解放
     *
     */
    public function unsetKeep()
    {
        session_clear();
    }

    /**
     * エラーの発行
     *
     */
    public function setErrors($errors)
    {
        $s = session();

        $s['errors'] = $errors;
        session($s);

        return (bool) $errors;
    }

    /**
     * 発行されたエラーを取得
     * ※取得直後、flashデータとしてエラーは削除する
     *
     * @return array エラーメッセージの配列
     */
    public function getErrors()
    {
        $s = session();

        if ($errors = aget($s, 'errors')) {
            unset($s['errors']);
            session($s);
        }

        return $errors;
    }

    /**
     * post値を保持する
     *
     */
    public function getPost()
    {
        $params = array();

        $properties = $this->setting->properties();

        foreach ($properties as $key => $property) {
            if ($property < 1) {
                continue;
            }
            $params[$key] = post($key);
        }

        // 保存
        $this->setKeep($params);

        return $params;
    }

    /**
     * 保持された値の保存と入力チェック
     *
     * @return array エラーメッセージの配列
     */
    public function validate($params)
    {
        // 入力チェックとエラーの保存
        return $this->setErrors($this->validator->setup($params, $this->setting)->check());
    }

    /**
     * validate済み判定制御
     *
     * $bool に true か falseを入れると、内容を更新
     * 省略($bool === null)ならば状態を取得する。
     *
     * trueの状態でなければ入力未チェックとし、sendは実行できない。
     */
    public function valid($bool = null)
    {
        if ($bool === null) {
            return (bool) aget(session(), 'valid');
        } else {
            $s = session();
            $s['valid'] = (bool) $bool;
            session($s);
        }
    }

    /**
     * 遷移
     *
     */
    public function redirect($alias, $data = null)
    {
        $data = is_array($data) ? $data : array();
        $url  = $this->setting->getUrl($alias);
        header(
            "Location: {$url}".
            ($data ? '?' . http_build_query($data) : '')
        );
        exit;
    }

    /**
     * メール送信
     *
     */
    public function send()
    {
        $params = $this->getKeep();

        $p_admins = $p_customers = array();

        // 管理者用
        $to      = $this->setting->mailAdminTo();
        $to_list = is_array($to) ? $to : array($to);
        $froms   = $this->setting->mailAdminFrom();
        // $froms   = aget($params, 'mail');  // 差出人はフォームに入力されたユーザーのメールアドレス
        if (is_array($froms)) {
            $from      = aget($froms, 0);
            $from_name = aget($froms, 1);
        } else {
            $from      = $froms;
            $from_name = null;
        }

        $subject  = $this->setting->mailAdminSubject();
        $body     = build_text($this->setting->mailAdminTemplate(), $params);

        foreach ($to_list as $to) {
            $p_admins[]  = compact('to', 'subject', 'body', 'from', 'from_name');
        }
        // 入力者用
        $to    = aget($params, 'fEmail');
        $froms = $this->setting->mailFrom();
        if (is_array($froms)) {
            $from      = aget($froms, 0);
            $from_name = aget($froms, 1);
        } else {
            $from      = $froms;
            $from_name = null;
        }
        $subject       = "【".aget($params, 'fFirstName')."様】".$this->setting->mailSubject();
        $body          = build_text($this->setting->mailTemplate(), $params);
        $p_customers[] = compact('to', 'subject', 'body', 'from', 'from_name');

        // 双方メール送信
        foreach (array($p_admins, $p_customers) as $l) {
            foreach ($l as $v) {
                extract($v);
                if (!$to || !$subject || !$body || !$from) {
                    $this->setErrors(array(
                        'server_error' => 'サーバでエラーが発生しました。メールを送信できませんでした。'
                    ));
                    return false;
                }
                mail_send($to, $subject, $body, $from, $from_name);
            }
        }

        return true;
    }

    // 値を表示用の文字列に整形してechoする
    public function view($params, $key)
    {
        $value = aget($params, $key);

        switch ($key) {
            case 'zip':
                if (aget($value, 1) && aget($value, 2)) {
                    $value = h(implode('-', $value));
                } else {
                    // $value = '';
                    $value = h($value);
                }
                break;
            case 'age':
                if (strlen($value)) {
                    // $value = h($value . ' 才');
                    $value = h($value . '');
                }
                break;
            case 'together_people':
                if (strlen($value)) {
                    $value = h($value . ' 名');
                }
                break;
            case 'fComment':
                $value = nl2br(h($value));
                break;
            default:
                if (is_array($value)) {
                    $value = '';
                } else {
                    $value = h($value);
                }
                break;
        }

        echo $value;
    }
}


/** *****************************************************************************
 * 挙動設定クラス
 ********************************************************************************/
class Form_Setting
{

    // 入力者用メールのfrom
    public function mailFrom()
    {
        return consts(FORM_ALIAS, 'user_from');
    }

    // 入力者用メールのタイトル
    public function mailSubject()
    {
        return consts(FORM_ALIAS, 'user_subject');
    }

    // 入力者用メールの本文テンプレート
    public function mailTemplate()
    {
        return MAIL_TEMPLATE_DIR. '/'. consts(FORM_ALIAS, 'user_template');
    }

    // 管理者メールアドレス
    public function mailAdminTo()
    {
        if (is_env('production')) {
            return consts(FORM_ALIAS, 'admin_to');
        } else {
            return consts('_debug_', 'admin_to');
        }
    }

    // 管理者用メールのfrom
    public function mailAdminFrom()
    {
        return consts(FORM_ALIAS, 'admin_from');
    }

    // 管理者用メールのタイトル
    public function mailAdminSubject()
    {
        return consts(FORM_ALIAS, 'admin_subject');
    }

    // 管理者用メールの本文テンプレート
    public function mailAdminTemplate()
    {
        return MAIL_TEMPLATE_DIR . '/'. consts(FORM_ALIAS, 'admin_template');
    }

    // リダイレクト用urlマッピング設定
    public function urls()
    {
        return array(
            'input'   => 'index.php',
            'confirm' => 'confirm.php',
            'error'   => 'index.php',
            'send'    => 'result.php',
        );
    }

    public function getUrl($alias)
    {
        return aget($this->urls(), $alias);
    }

    // データラベル
    public function labels()
    {
        return array(
            'fContentOfInquiry'                  => 'お問い合わせ内容',
            'fFirstName'                  => 'お名前',
            'fPhoneNumber'                  => 'お電話番号（携帯可）',
            'fEmail'                        => 'メールアドレス'
        );
    }

    public function getLabel($key)
    {
        return aget($this->labels(), $key);
    }

    // 入力制御プロパティ
    public function properties()
    {
        // 0: 使用しない 1: 入力項目あり 2: 入力必須
        // 0: Not used 1: Input item present 2: Required input
        return array(
            'fContentOfInquiry'      => 2,
            'fFirstName'      => 2,
            'fPhoneNumber'      => 2,
            'fEmail'            => 2,
            'fOccupation'      => 1,
            'fComment'            => 1
        );
    }
}

/** *****************************************************************************
 * 入力チェッククラス
 ********************************************************************************/
class Form_Validator
{
    protected $_setting;

    protected $_params  = array();
    protected $_errors  = array();

    public function setup($params, Form_Setting $setting)
    {
        $this->_setting = $setting;
        $this->_params  = $params;
        return $this;
    }

    public function setting()
    {
        if (!$this->_setting) {
            throw new Exception("Form_Validator::setupされていません。");
        }
        return $this->_setting;
    }

    public function getParam()
    {
        $pos   = func_get_args();
        $value = $this->_params;
        return $pos ? aget($value, $pos) : $value;
    }

    public function add($key, $message)
    {
        $this->_errors[$key] = $message;
    }

    public function get($key)
    {
        return aget($this->_errors, $key);
    }

    public function getAll()
    {
        return $this->_errors;
    }

    public function check()
    {
        $list = $this->setting()->properties();

        foreach ($list as $key => $property) {
            if ($property < 2) {
                continue;
            }

            $method = "__{$key}";

            $options = array(
                'required' => $property == 2,
            );

            if ($msg = $this->$method($options)) {
                $this->add($key, $msg);
            }
        }

        return $this->getAll();
    }

    // 通常文字列の共通チェック
    public function checkText($key, $maxlength, $options = array())
    {
        $value    = $this->getParam($key);
        $label    = $this->setting()->getLabel($key);
        $required = (bool) aget($options, 'required');

        if ($required && !strlen($value)) {
            return "{$label}を入力してください";
        }
        if (mb_strlen($value) > $maxlength) {
            return "{$label}は{$maxlength}文字以内で入力してください";
        }
        if (strlen($value) && ($reg = aget($options, 'reg')) && !preg_match($reg, $value)) {
            return "{$label}を正しく入力してください";
        }
    }

    // 郵便番号の共通チェック xxx-xxxxならば、$value[1]-$value[2] となっていること
    // public function checkPostal($key, $options = array())
    // {
    //     $value    = $this->getParam($key);
    //     $label    = $this->setting()->getLabel($key);
    //     $required = (bool) aget($options, 'required');
    //     $zip1 = aget($value, 1);
    //     $zip2 = aget($value, 2);

    //     if ($required && (!strlen($zip1) || !strlen($zip2))) {
    //         return "{$label}を全て入力してください";
    //     }
    //     if (
    //         (strlen($zip1) || strlen($zip2))
    //         &&
    //         (!preg_match('/^[0-9]+$/', $zip1) || !preg_match('/^[0-9]+$/', $zip2))
    //     ) {
    //         return "{$label}を正しい形式で入力してください";
    //     }
    // }
    public function checkPostal($key, $options = array())
    {
        $value    = $this->getParam($key);
        $label    = $this->setting()->getLabel($key);
        $required = (bool) aget($options, 'required');

        if ($required && (!strlen($value))) {
            return "{$label}を全て入力してください";
        }
        if ( strlen($value) && !preg_match('/^[0-9]+$/', $value) ) {
            return "{$label}を正しい形式で入力してください";
        }
    }

    // 自然数のチェック
    public function checkNum($key, $min, $max, $options = array())
    {
        $value    = $this->getParam($key);
        $label    = $this->setting()->getLabel($key);
        $required = (bool) aget($options, 'required');
        if ($required && !strlen($value)) {
            return "{$label}を入力してください";
        }
        if (strlen($value) && (!preg_match('/^[0-9]+$/', $value) || $min > $value || $max < $value)) {
            return "{$label}は半角数字で入力してください";
        }
    }

    // メールアドレスの共通チェック
    public function checkMail($key, $options = array())
    {
        $value    = $this->getParam($key);
        $label    = $this->setting()->getLabel($key);
        $required = (bool) aget($options, 'required');
        if ($required && !strlen($value)) {
            return "{$label}を入力してください";
        }
        // 引用元: http://catbot.net/blog/2007/06/re_php.html の「phpspot」
        $reg = '/^[a-zA-Z0-9_\.\-\+]+?@[A-Za-z0-9_\.\-]+$/';
        if (strlen($value) && !preg_match($reg, $value)) {
            return "{$label}を正しい形式で入力してください";
        }
    }

    public function checkMailConfirm($key_1, $key_2, $options = array())
    {
        $value_1    = $this->getParam($key_1);
        $value_2    = $this->getParam($key_2);
        $label    = $this->setting()->getLabel($key_1);
        $required = (bool) aget($options, 'required');
        if ($value_1 &&  $value_2 && $value_1 != $value_2) {
            return "{$label}メールが一致しません";
        }
    }

    // 電話番号の共通チェック
    public function checkTel($key, $options = array())
    {
        $value    = $this->getParam($key);
        $label    = $this->setting()->getLabel($key);
        $required = (bool) aget($options, 'required');
        if ($required && !strlen($value)) {
            return "{$label}を入力してください";
        }
        if (strlen($value) && !preg_match('/^[0-9]{1,13}([0-9]{1,13}){1,2}$/', $value)) {
            return "{$label}を正しい形式で入力してください";
        }
    }

    // セレクトボックス値の共通チェック
    public function checkSelect($key, $options = array())
    {
        $value    = $this->getParam($key);
        $label    = $this->setting()->getLabel($key);
        $required = (bool) aget($options, 'required');
        // 文字数がなければ未選択と看做す
        if ($required && !strlen($value)) {
            return "{$label}を選択してください";
        }
        // 念のため200文字以上の文字列が渡ってきたら不正な値と看做す
        if (mb_strlen($value) > 200) {
            return "{$label}を選択してください";
        }
    }

    // 上部セレクトボックス 1番目
    public function __fFirstName($options)
    {
        return $this->checkText('fFirstName', 255, $options);
    }

    // 名前
    public function __fPhoneNumber($options)
    {
        return $this->checkText('fPhoneNumber', 50, $options);
    }

    // かな
    public function __name_furi($options)
    {
        $options['reg'] = '/^[あ-ん]+[あ-ん 　]*$/';
        return $this->checkText('name_furi', 50, $options);
    }

    // 郵便番号
    public function __zip($options)
    {
        return $this->checkPostal('zip', $options);
    }

    // 住所
    public function __address($options)
    {
        return $this->checkText('address', 200, $options);
    }

    // 電話番号
    public function __tel($options)
    {
        return $this->checkTel('tel', $options);
    }

    // 性別
    public function __fContentOfInquiry($options)
    {
        return $this->checkSelect('fContentOfInquiry', $options);
    }

    // 現在(学年)
    public function __now($options)
    {
        return $this->checkSelect('now', $options);
    }

    // 年齢
    public function __age($options)
    {
        return $this->checkNum('age', 1, 120, $options);
    }

    // メールアドレス
    public function __fEmail($options)
    {
        return $this->checkMail('fEmail', $options);
    }

    public function __known($options)
    {
        return $this->checkSelect('known', $options);
    }

    // ご意見・ご質問
    public function __question($options)
    {
        return $this->checkText('question', 2000, $options);
    }

    public function __interview_afte_visit($options)
    {
        return $this->checkText('interview_afte_visit', 200, $options);
    }

    // 同伴者名
    public function __together_name1($options)
    {
        return $this->checkText('together_name1', 50, $options);
    }
		
		
    // 同伴者名
    public function __together_name3($options)
    {
        return $this->checkText('together_name3', 50, $options);
    }

    // 同伴者名かな
    public function __together_name2($options)
    {
        $options['reg'] = '/^[あ-ん]+[あ-ん 　]*$/';
        return $this->checkText('together_name2', 50, $options);
    }
		
		  // 同伴者名かな
    public function __together_name4($options)
    {
        $options['reg'] = '/^[あ-ん]+[あ-ん 　]*$/';
        return $this->checkText('together_name4', 50, $options);
    }

    // 本人との関係
    public function __together_relation($options)
    {
        return $this->checkSelect('together_relation', $options);
    }

    // その他の場合のご関係
    public function __together_other_relation($options)
    {
        return $this->checkText('together_other_relation', 100, $options);
    }

    // 本人との関係
    public function __together_relation2($options)
    {
        return $this->checkSelect('together_relation2', $options);
    }

    // その他の場合のご関係
    public function __together_other_relation2($options)
    {
        return $this->checkText('together_other_relation2', 100, $options);
    }

    // (その他の場合のご関係)上記以外の人数
    public function __together_people($options)
    {
        return $this->checkNum('together_people', 1, 1000, $options);
    }

    // 資料請求希望チェックボックス
    public function __request($options)
    {
        return $this->checkSelect('request', $options);
    }

    // 資料請求希望チェックボックス
    public function __request2($options)
    {
        return $this->checkSelect('request2', $options);
    }

    // 同伴者メールアドレス
    public function __mail2($options)
    {
        $check_mail = $this->checkMail('mail2', $options);
        if ( ! $check_mail ) return $this->checkMailConfirm('mail', 'mail2');
        return $check_mail;
    }
}

/** *****************************************************************************
 * functions
 ********************************************************************************/
/**
 * utility 値のhtml出力系
 *
 */

function h($string)
{
    return htmlspecialchars($string, ENT_QUOTES);
}

function he($string, $nl2br = false)
{
    $string = h($string);
    echo ($nl2br ? nl2br($string) : $string);
}

/**
 * utility $exprがtrueならばchecked="checked"と出力する
 *
 */
function checked($expr)
{
    if ($expr) echo ' checked="checked" ';
}

/**
 * utility $exprがtrueならばselected="selected"と出力する
 *
 */
function selected($expr)
{
    if ($expr) echo ' selected="selected" ';
}

/**
 * utility 配列getter
 *
 */
function aget($array, $key, $default = null)
{
    if (!is_array($key)) {
        return is_array($array) && array_key_exists($key, $array) ? $array[$key] : $default;
    }

    if (!$key) return $default;

    foreach ($key as $k) {
        if (is_array($array) && array_key_exists($k, $array)) {
            $array = $array[$k];
        } else {
            return $default;
        }
    }
    return $array;
}

/**
 * utility リクエスト取得用
 *
 */
// 引数なし:全て取得 あり:特定キーの取得
function get($pos = null)
{
    $value = $_GET;
    return $pos ? aget($value, $pos) : $value;
}
// 引数なし:全て取得 あり:特定キーの取得
function post($pos = null)
{
    $value = $_POST;
    return $pos ? aget($value, $pos) : $value;
}
// 引数なし:取得 引数あり:設定 ※get, postとは動作が異なるので注意
function session($params = null)
{
    if ($params === null) {
        return aget($_SESSION, FORM_ALIAS);
    } else {
        return $_SESSION[FORM_ALIAS] = $params;
    }
}
// セッションの解放
function session_clear()
{
    unset($_SESSION[FORM_ALIAS]);
}


/**
 * utility メール関連
 *
 */
// テンプレートファイルと連想配列によるテンプレート処理
function build_text($__template_file, $__params)
{
    foreach ($__params as $__k => $__v) {
        if (is_string($__v)) {
            $__params[$__k] = str_replace("\r\n", "\n", $__v); // 改行は\nに統一する
        }
    }
    $__before_er = error_reporting(E_ALL ^ E_NOTICE);
    extract($__params);
    try {
        ob_start();
        include $__template_file;
        $__template_text = ob_get_clean();
    } catch (Exception $e) {
        $__template_text = '申し訳ございません。メール生成時にエラーが発生しました。';
    }
    error_reporting($__before_er);
    return $__template_text;
}

// マルチバイト文字のメール送信
function mail_send($to, $subject, $body, $from, $from_name = null)
{
    mb_language("japanese");
    mb_internal_encoding("UTF-8");

    if ($from_name) {
        $from =
            strtr(mb_encode_mimeheader($from_name), array("\r" => ""))
            . "<" . $from . ">";
    }

    mb_send_mail($to, $subject, $body,"From:".$from);
}