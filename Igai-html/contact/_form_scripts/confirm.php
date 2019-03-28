<?php
/**
 * 入力内容確認画面処理
 *
 */

require_once dirname(__FILE__).'/__init__.php';

$form = contact_form();

$form->valid(false);

$p = $form->getPost();

$json = ( isset($_POST['ajax']) && $_POST['ajax'] ) ? true : false;

$errors = $form->validate($p);

if ( $errors && !$json ) {
    $form->redirect('error');
}

if ($json){
	if ($errors){
		echo json_encode(array('valid' => false, 'errors' => $form->getErrors()));
	}else{
		echo json_encode(array('valid' => 'true'));
	}
	exit();
}

$form->valid(true);

$form->redirect('send');