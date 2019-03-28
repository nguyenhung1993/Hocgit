<?php
/**
 * 入力フォーム画面処理
 *
 */

require_once dirname(__FILE__).'/__init__.php';

$form = contact_form();

$form->valid(false);

if ('confirm' === get('from')) {
    $p = $form->getKeep();
} else {
    $form->unsetKeep();
    $p = null;
}
