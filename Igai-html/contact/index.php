<?php define('FORM_ALIAS', 'contact'); require_once dirname(__FILE__) . '/_form_scripts/input.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=1200, initial-scale=1, maximum-scale=2">
    <title>お問い合わせ - 株式会社伊賀井商店 | ブリキ板の切断加工・オリジナル缶の製作</title>
    <meta name="description" content="愛知県東海市にある、伊賀井商店のホームページです。ブリキを専門に扱う私たちへの、お問い合わせはこちらから。何でもお気軽にご相談ください。">
    <meta name="keyword" content="伊賀井商店,愛知県,東海市,ブリキ,お問い合わせ">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css"
          href="../fonts/FontAwesome/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
<noscript>このウェブサイトを実行するにはJavaScriptを有効にする必要があります。</noscript>
<aside class="c-sidebar">
    <a class="c-sidebar__logo" href="../index.html">
        <img alt="igai" src="../images/photos/logo@2x.png"/>
    </a>
    <div class="c-sidebar__main">
        <div class="c-sidebar__container">
            <ul class="c-sidebar__menu">
                <li>
                    <a href="/company/">企業情報</a>
                </li>
                <li>
                    <a href="/business/">事業内容</a>
                </li>
                <li class="defaul">
                    <a href="#">オンリー缶</a>
                </li>
            </ul>
        </div>

    </div>
    <div class=" c-sidebar__main__footer">
        <div class="c-sidebar__contact">
            <div class="c-sidebar__contact__text txt-center">
                お問い合わせ <br>
                <span>
                        Contact
                    </span>
            </div>
            <a class="c-sidebar__contact__phone" href="tel:0526035591"><i class="fa fa-phone" aria-hidden="true"></i>052-603-5591</a>
            <p class="txt-right">受付／平日 9:00〜17:00</p>
            <a class="c-sidebar__contact__mail" href="/contact/"><i class="fa fa-envelope" aria-hidden="true"></i>メールフォームはこちら</a>
        </div>
        <div class="c-sidebar__footer">
            <p class="txt-center">2019 &#xA9;︎ igai.co.jp</p>
        </div>
    </div>
</aside>
<main class="contents page-contact-index">
    <nav class="breadcrumbs" role="navigation">
	<div class="container-sm">
		<a href='/'>Home</a> <i class='fa fa-angle-right' aria-hidden='true'></i> <span>お問い合わせ</span>
	</div>
</nav>
    <section class="page-heading page-heading-contact page-heading-contact-index">
        <h1 class="title">お問い合わせ</h1>
        <p class="txt">Contact</p>
    </section>
    <section class="section-contact-from">
        <div class="container">

            <div class="row mbpc-50 notice contact">
                <p class="col-12 txt-basic lh2 txt-center">
                    伊賀井商店に関するお問い合わせは、下記のフォームより承っております。<br>
                    必要事項を入力の上、確認ボタンを押してください。
                </p>
            </div>

            <div class="mbpc-30 contact-from-head error-message" style="display: none">
                <h2 class="title txt-center mbpc-30">
                    入力エラー
                </h2>
                <div class="txt-basic lh2 lh2">
                    <p class="name"></p>
                    <p class="tel"></p>
                    <p class="mail"></p>
                    <p class="content"></p>
                </div>
            </div>
            <form id="contact-form" class="contact-from form_validate" action="<?php he($form->setting->getUrl('confirm')) ?>" method="post">
                <div class="form-row">
                    <div class="form-label">
                        <label for="fName">お名前</label>
                        <span class="label-required">必須</span>
                    </div>
                    <div class="form-content">
                        <input type="text" id="fName" name="name" tabindex="1" accesskey="a" value="<?php he(aget($p, 'name')) ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label">
                        <label for="fTitle">役職名</label>
                        <span class="label-option">任意</span>
                    </div>
                    <div class="form-content">
                        <input type="text" id="fTitle" name="division" tabindex="1" accesskey="a" value="<?php he(aget($p, 'division')) ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label">
                        <label for="fCompanyName">会社名</label>
                        <span class="label-option">任意</span>
                    </div>
                    <div class="form-content">
                        <input type="text" id="fCompanyName" name="company" tabindex="1" accesskey="a" value="<?php he(aget($p, 'company')) ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label">
                        <label for="fPhone">電話番号</label>
                        <span class="label-required">必須</span>
                    </div>
                    <div class="form-content">
                        <input type="text" name="tel" id="fPhone" tabindex="1" accesskey="a" value="<?php he(aget($p, 'tel')) ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label">
                        <label for="fMail">メールアドレス</label>
                        <span class="label-required">必須</span>
                    </div>
                    <div class="form-content">
                        <input type="email" id="fMail" name="mail" tabindex="1" accesskey="a" value="<?php he(aget($p, 'mail')) ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label">
                        <label for="fUrl">ホームページURL</label>
                        <span class="label-option">任意</span>
                    </div>
                    <div class="form-content">
                        <input type="text" id="fUrl" name="url" tabindex="1" accesskey="a" value="<?php he(aget($p, 'url')) ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label top">
                        <label for="fComment">お問い合わせ内容</label>
                        <span class="label-required">必須</span>
                    </div>
                    <div class="form-content">
                        <textarea id="fComment" tabindex="1" accesskey="a"  name="content"><?php he(aget($p, 'content')) ?></textarea>
                    </div>
                </div>
                <div class="txt-center mtpc-50 ">
                    <button type="submit" class="btn btn-center btn-mail" tabindex="1" accesskey="a">この内容で送信する<img alt="img" src="../images/photos/contact/mail.png"/></button>
                </div>
            </form>
        </div>
    </section>
    <footer id="main-footer">
    <div class="container">
        <div class="row">
            <div class="site-map col-12">
                <div class="logo txt-center">
                    <a href="../index.html" title="IGAI"><img src="../images/photos/logo-footer@2x.png" alt="img"></a>
                </div>
                <div class="content">
                    <dl>
                        <dt>本社工場</dt>
                        <dd>〒476-0001 <span>愛知県東海市南柴田町ハの割138番13号</span></dd>
                        <dd>TEL 052-603-5591<span>FAX 052-603-5595</span></dd>
                    </dl>
                    <dl>
                        <dt>レベラー工場</dt>
                        <dd>〒476-0001 <span>愛知県東海市南柴田町イの割44番16号</span></dd>
                        <dd>TEL 052-601-0177<span>FAX 052-601-0193</span></dd>
                    </dl>
                </div>
            </div>
        </div>
        <a class="back-to-top js-totop" href="javascript:void(0)" style="">
            <img alt="to top" src="../images/photos/back-to-top.png">
        </a>
    </div>

</footer>
</main>


<script type="text/javascript" src="../js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="../js/setting.js"></script>
<script type="text/javascript" src="../js/form_validate.js"></script>
</body>
</html>