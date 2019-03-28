<?php define('FORM_ALIAS', 'contact'); require_once dirname(__FILE__) . '/_form_scripts/input.php'; ?>
<?php
    $recruit = '';
    if (isset($_GET['recruit'])) {
        $recruit = $_GET['recruit'];
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>お問い合わせ | 名宝電気工事株式会社 - 名古屋市中村区</title>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <meta name="description" content="名古屋市中川区にある、名宝電気工事。求人募集へのご応募や、お仕事のご依頼などはこちらのフォームから。些細なことでもお気軽にお問い合わせください。">
    <meta name="keyword" content="名宝電気工事, 名古屋市, お問い合わせ">
    <link rel="stylesheet" type="text/css"
          href="../fonts/FontAwesome/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="../js/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="../js/slick/slick-theme.css"/>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <!--[if lte IE 9]>
    <link rel="stylesheet" type="text/css" href="../css/ie9.css">
    <![endif]-->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-115881443-6"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-115881443-6');
    </script>
</head>
<body>

<noscript>このウェブサイトを実行するにはJavaScriptを有効にする必要があります。</noscript>
<div class="page-content" role="main">
<header id="main-header">
    <div class="container container-md">
        <nav role="navigation">
            <h1 class="menu-logo">
                <a href="../index.html">
                    <img src="../images/icons/header-logo@2x.png" alt="meihou">
                </a>
            </h1>
            <a href="" class="menu-sp-btn">
                <img src="../images/icons/menu-sp-open@2x.png" alt="menu open">
                <img src="../images/icons/menu-sp-close@2x.png" alt="menu close">
            </a>
            <ul class="main-menu">
                <li>
                    <a href="../about/" class="">
                        <span class="jp">会社案内</span>
                        <span class="en">about</span>
                    </a>
                </li>
                <li>
                    <a href="../vision/" class="">
                        <span class="jp">ビジョン</span>
                        <span class="en">vision</span>
                    </a>
                </li>
                <li>
                    <a href="../business/" class="">
                        <span class="jp">事業領域</span>
                        <span class="en">business</span>
                    </a>
                </li>
                <li>
                    <a href="../interview/" class="">
                        <span class="jp">社員インタビュー</span>
                        <span class="en">interview</span>
                    </a>
                </li>
                <li>
                    <a href="../recruit-01/" class="">
                        <span class="jp">採用情報</span>
                        <span class="en">recruit</span>
                    </a>
                </li>
                <li>
                    <a href="../contact/" class="active">
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        <span class="jp">お問い合わせ</span>
                        <span class="en">contact</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
<main class="main-content page-contact">
    <section class="page-head-banner txt-center page-contact">
        <div class="container container-md">
            <h2>お問い合わせ</h2>
            <p>CONTACT</p>
            <img src="../images/icons/section-contact-ttl-pattern@2x.png" alt="">
        </div>
    </section>
    <section class="section-contact-form">
        <form name="entry_form" id="contact-form" class="form_validate" action="<?php he($form->setting->getUrl('confirm')) ?>" method="post">
            <div class="contact-form-heading">
                <div class="container container-xs">
                    <div class="notice contact">
                        <div class="section-ttl">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <a href="tel:0524713288">052-471-3288</a>
                            <p>受付：平日 9:00〜17:00</p>
                        </div>
                        <p class="message">
                            ご応募や、当社へのお問い合わせは、下記のフォームより受け付けています。<br>
                            必要事項を入力の上、送信してください。<br>
                            未経験でも、当社の業務内容やビジョンに共感いただける方からのご応募なら大歓迎。<br>
                            応募に関する疑問や不安のある方、まずは問い合わせだけ、という方もお気軽にご連絡ください！
                        </p>
                    </div>
                    <p class="notice error" style="display: none">入力エラー</p>
                </div>
            </div>
            <div class="contact-form-body">
                <div class="container container-sm">
                    <div class="error-message" style="display: none">
                        <p class="fContentOfInquiry"></p>
                        <p class="fFirstName"></p>
                        <p class="fPhoneNumber"></p>
                        <p class="fEmail"></p>
                    </div>
                    <div class="form-row">
                        <div class="form-label">
                            <label for="fContentOfInquiry">お問い合わせ内容</label>
                            <span class="tag required-tag">必  須</span>
                        </div>
                        <div class="form-content">
                            <div class="custom-select">
                                <select name="fContentOfInquiry" id="fContentOfInquiry" required>
                                    <option value="" <?php selected(!aget($p, 'fContentOfInquiry')) ?>>選択してください</option>
                                    <option value="応募する" <?php selected(aget($p, 'fContentOfInquiry') == '応募する') ?>>応募する</option>
                                    <option value="その他のお問い合わせ" <?php selected(aget($p, 'fContentOfInquiry') == 'その他のお問い合わせ') ?>>その他のお問い合わせ</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label">
                            <label for="fOccupation">希望職種</label>
                            <span class="tag no-required-tag">任  意</span>
                        </div>
                        <div class="form-content">
                            <input type="text" id="fOccupation" name="fOccupation" placeholder="例：電気工事士"
                                   class="input-lg" value="<?php he(aget($p, 'fOccupation')) ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label">
                            <label for="fFirstName">お名前</label>
                            <span class="tag required-tag">必  須</span>
                        </div>
                        <div class="form-content">
                            <input type="text" id="fFirstName" name="fFirstName" placeholder="例：名宝太郎"
                                   class="input-md" value="<?php he(aget($p, 'fFirstName')) ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label">
                            <label for="fPhoneNumber">お電話番号（携帯可）</label>
                            <span class="tag required-tag">必  須</span>
                        </div>
                        <div class="form-content">
                            <input type="tel" id="fPhoneNumber" name="fPhoneNumber" placeholder="例：0912-345-678"
                                   class="input-md" value="<?php he(aget($p, 'fPhoneNumber')) ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label">
                            <label for="fEmail">メールアドレス</label>
                            <span class="tag required-tag">必  須</span>
                        </div>
                        <div class="form-content">
                            <input type="text" id="fEmail" name="fEmail" value="<?php he(aget($p, 'fEmail')) ?>" placeholder="例：example@meihou.nagoya"
                                   class="input-lg" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label">
                            <label for="fComment">当社へのメッセージ</label>
                            <span class="tag no-required-tag">任  意</span>
                            <span class="notice">※自由にご記入ください！</span>
                        </div>
                        <div class="form-content">
                            <textarea name="fComment" id="fComment" placeholder="自由にご記入ください"><?php he(aget($p, 'fComment')) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contact-form-footer">
                <div class="container container-sm txt-center">
                    <button type="submit" class="btn btn-solid-orange">
                        <i class="fa fa-paper-plane fa-hidden" aria-hidden="true"></i>
                        <span>入力内容の確認</span>
                        <span class="arrow-right"></span>
                    </button>
                </div>
            </div>
        </form>
    </section>
</main>

<footer id="main-footer">
    <div class="container container-md">
        <div class="logo">
            <figure>
                <a href="../">
                    <img src="../images/icons/footer-logo@2x.png" alt="meihou">
                </a>
                <figcaption>
                    〒453-0811　愛知県名古屋市中村区太閤通６丁目４３
                </figcaption>
            </figure>
        </div>
        <ul class="sitemap">
            <li><a href="../about/">会社案内</a></li>
            <li><a href="../vision/">ビジョン</a></li>
            <li><a href="../business/">事業領域</a></li>
            <li><a href="../interview/">社員インタビュー</a></li>
            <li><a href="../recruit-01/">採用情報</a></li>
            <li><a href="../contact">お問い合わせ</a></li>
            <li><a href="../privacy/">プライバシーポリシー</a></li>
        </ul>
        <p class="copyright">&copy;︎2019 meihou.nagoya</p>
    </div>
</footer>
<a href="#" class="back-to-top smooth-anchor"></a>
</div>


<script type="text/javascript" src="../js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="../js/vivus.min.js"></script>
<script type="text/javascript" src="../js/imagesloaded.pkgd.min.js"></script>
<script type="text/javascript" src="../js/jquery.matchHeight.js"></script>
<script type="text/javascript" src="../js/slick/slick.min.js"></script>
<script type="text/javascript" src="../js/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="../js/form_validate.js"></script>
<script type="text/javascript" src="../js/setting.js"></script>
<?php if($recruit == 1) { ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#fOccupation').val('未経験歓迎の電気工事士');
        $('#fContentOfInquiry').find('option:selected').removeAttr('selected');
        $('#fContentOfInquiry option[value=応募する]').attr('selected','selected');
        $('.styledSelect').empty().html('応募する').css({"color": "#000000"});
    })
</script>
<?php }elseif($recruit == 2) { ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#fOccupation').val('電気工事施工管理技士');
        $('#fContentOfInquiry').find('option:selected').removeAttr('selected');
        $('#fContentOfInquiry option[value=応募する]').attr('selected','selected');
        $('.styledSelect').empty().html('応募する').css({"color": "#000000"});
    })
</script>
<?php } ?>
</body>
</html>