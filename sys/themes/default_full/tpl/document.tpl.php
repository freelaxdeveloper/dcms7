<?php
/**
 * @var $this document
 */
?><!DOCTYPE html>
<html ng-app="Dcms">
<head>
    <title><?= $title ?></title>
    <link rel="shortcut icon" href="/favicon.ico"/>
    <link rel="stylesheet" href="/sys/themes/.common/system.css" type="text/css"/>
    <link rel="stylesheet" href="/sys/themes/.common/icons.css" type="text/css"/>
    <link rel="stylesheet" href="/sys/themes/.common/theme_light.css" type="text/css"/>
    <link rel="stylesheet" href="/sys/themes/.common/animate.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="<?= $path ?>/style.css?14"/>
    <noscript>
        <meta http-equiv="refresh" content="0; URL=/pages/bad_browser.html"/>
    </noscript>
    <script>
        (function () {
            var getIeVer = function () {
                var rv = -1; // Return value assumes failure.
                if (navigator.appName === 'Microsoft Internet Explorer') {
                    var ua = navigator.userAgent;
                    var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
                    if (re.exec(ua) !== null)
                        rv = parseFloat(RegExp.$1);
                }
                return rv;
            };
            var ver = getIeVer();
            if (ver !== -1 && ver < 9) {
                window.location.href = "/pages/bad_browser.html";
            }
        })();
    </script>
    <script charset="utf-8" src="/sys/themes/.common/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script charset="utf-8" src="/sys/themes/.common/angular.min.js" type="text/javascript"></script>
    <script charset="utf-8" src="/sys/themes/.common/angular-animate.min.js" type="text/javascript"></script>
    <script charset="utf-8" src="/sys/themes/.common/dcmsApi.js" type="text/javascript"></script>
    <script charset="utf-8" src="/sys/themes/.common/elastic.js" type="text/javascript"></script>
    <script charset="utf-8" src="<?= $path ?>/js.js?6" type="text/javascript"></script>
    <meta name="generator" content="DCMS <?= dcms::getInstance()->version ?>"/>
    <? if ($description) { ?>
        <meta name="description" content="<?= $description ?>"/>
    <? } ?>
    <? if ($keywords) { ?>
        <meta name="keywords" content="<?= $keywords ?>"/>
    <? } ?>
    <script>
        user = <?=json_encode(current_user::getInstance()->getCustomData(array('id', 'group', 'mail_new_count', 'friend_new_count', 'nick')))?>;
        translates = {
            bbcode_b: '<?= __('Текст жирным шрифтом') ?>',
            bbcode_i: '<?= __('Текст курсивом') ?>',
            bbcode_u: '<?= __('Подчеркнутый текст') ?>',
            bbcode_img: '<?= __('Вставка изображения') ?>',
            bbcode_php: '<?= __('Выделение PHP-кода') ?>',
            bbcode_big: '<?= __('Увеличенный размер шрифта') ?>',
            bbcode_small: '<?= __('Уменьшенный размер шрифта') ?>',
            bbcode_gradient: '<?= __('Цветовой градиент') ?>',
            bbcode_hide: '<?= __('Скрытый текст') ?>',
            bbcode_spoiler: '<?= __('Свернутый текст') ?>',
            smiles: '<?= __('Смайлы') ?>',
            form_submit_error: '<?= __('Ошибка связи...') ?>',
            auth: '<?= __("Авторизация") ?>',
            reg: '<?= __("Регистрация") ?>',
            friends: '<?=__("Друзья")?>',
            mail: '<?=__("Почта")?>',
            error: '<?=__('Неизвестная ошибка')?>',
            rating_down_message: '<?=__('Подтвердите понижение рейтинга сообщения.').(dcms::getInstance()->forum_rating_down_balls?"\\n".__('Будет списано баллов: %s',dcms::getInstance()->forum_rating_down_balls):'')?>'
        };
        codes = [
            {Text: 'B', Title: translates.bbcode_b, Prepend: '[b]', Append: '[/b]'},
            {Text: 'I', Title: translates.bbcode_i, Prepend: '[i]', Append: '[/i]'},
            {Text: 'U', Title: translates.bbcode_u, Prepend: '[u]', Append: '[/u]'},
            {Text: 'BIG', Title: translates.bbcode_big, Prepend: '[big]', Append: '[/big]'},
            {Text: 'Small', Title: translates.bbcode_small, Prepend: '[small]', Append: '[/small]'},
            {Text: 'IMG', Title: translates.bbcode_img, Prepend: '[img]', Append: '[/img]'},
            {Text: 'PHP', Title: translates.bbcode_php, Prepend: '[php]', Append: '[/php]'},
            {Text: 'SPOILER', Title: translates.bbcode_spoiler, Prepend: '[spoiler title=""]', Append: '[/spoiler]'},
            {Text: 'HIDE', Title: translates.bbcode_hide, Prepend: '[hide group="0" balls="0"]', Append: '[/hide]'}
        ];
    </script>
    <style type="text/css">
        .ng-hide {
            display: none !important;
        }
    </style>
</head>
<body class="theme_light_full theme_light" ng-controller="DcmsCtrl">
<audio id="audio_notify" preload="auto" class="ng-hide">
    <source src="/sys/themes/.common/notify.mp3" />
    <source src="/sys/themes/.common/notify.ogg" />
</audio>
<div id="main">
    <div id="top_part">
        <div id="header">
            <div class="body_width_limit clearfix">
                <h1 id="title"><?= $title ?></h1>

                <div id="navigation" class="clearfix <?= IS_MAIN ? 'ng-hide' : '' ?>">
                    <a class="nav_item" href='/'><?= __("Главная") ?></a>
                    <?= $this->section($returns, '<a class="nav_item" href="{url}">{name}</a>', true); ?>
                    <span class="nav_item"><?= $title ?></span>
                </div>
                <div id="tabs" class="<?= !$tabs ? 'ng-hide' : '' ?>">
                    <?= $this->section($tabs, '<a class="tab sel{selected}" href="{url}">{name}</a>', true); ?>
                </div>
            </div>
            <div id="navigation_user">
                <div class="body_width_limit clearfix">
                    <a ng-show="+user.group" class="<?= $user->group ? '' : 'ng-hide' ?>"
                       href="/menu.user.php" ng-bind="user.nick"><?= $user->nick ?></a>
                    <a ng-show="+user.friend_new_count" class='ng-hide'
                       href='/my.friends.php' ng-bind="str.friends"><?= __("Друзья") ?></a>
                    <a ng-show="+user.mail_new_count" class='ng-hide'
                       href='/my.mail.php?only_unreaded' ng-bind="str.mail"><?= __("Почта") ?></a>
                    <a ng-hide="+user.group" class="ng-hide"
                       href="/login.php?return={{URL}}" ng-bind="translates.auth"><?= __("Авторизация") ?></a>
                    <a ng-hide="+user.group" class="ng-hide"
                       href="/reg.php?return={{URL}}" ng-bind="translates.reg"><?= __("Регистрация") ?></a>

                    <?= $this->section($actions, '<a class="action" href="{url}">{name}</a>'); ?>
                </div>
            </div>
            <?php $this->displaySection('header'); ?>
        </div>
        <div class="body_width_limit clearfix">
            <div id="left_column">
                <?php $this->displaySection('left_column'); ?>
            </div>
            <div id="content">
                <div id="messages">
                    <?= $this->section($err, '<div class="error">{text}</div>'); ?>
                    <?= $this->section($msg, '<div class="info">{text}</div>'); ?>
                </div>
                <?php $this->displaySection('content'); ?>
            </div>
        </div>
        <div id="empty"></div>
    </div>
    <div id="footer">
        <div class="body_width_limit">
                    <span id="copyright">
                        <?= $copyright ?>
                    </span>
                    <span id="language">
                        <?= __("Язык") ?>:<a href='/language.php?return={{URL}}'
                                             style='background-image: url(<?= $lang->icon ?>); background-repeat: no-repeat; background-position: 5px 2px; padding-left: 23px;'><?= $lang->name ?></a>
                    </span>
                    <span id="generation">
                        <?= __("Время генерации страницы: %s сек", $document_generation_time) ?>
                    </span>
        </div>
    </div>
</div>
</body>
</html>