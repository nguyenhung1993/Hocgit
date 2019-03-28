<?php
/**
 * 送信処理と送信完了画面
 *
 */

require_once dirname(__FILE__).'/__init__.php';

$form = contact_form();

if (!$form->valid()) {
    $form->redirect('input');
} else if (!$form->send()) {
    $form->redirect('error');
}

$form->unsetKeep();