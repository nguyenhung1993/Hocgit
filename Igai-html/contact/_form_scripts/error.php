<?php
/**
 * エラー画面処理
 *
 */

require_once dirname(__FILE__).'/__init__.php';

$form = contact_form();

if (!$errors = $form->getErrors()) {
    $form->redirect('input', array('from' => 'confirm'));
}

$main_errors = $event_errors = $together_errors = array();

//エラー部位の切り分け
foreach ($errors as $key => $message) {
    if (preg_match('/^hope[0-9]+.*/', $key)) {
    // hope系は全てイベント系のエラーとする
        $event_errors[$key]    = $message;
    } else if (preg_match('/^(together\_.*|mail2)$/', $key)) {
    // together系、mail2は同伴者系のエラーとする
        $together_errors[$key] = $message;
    } else {
    // その他はメイン系エラーとする
        $main_errors[$key]     = $message;
    }
}
