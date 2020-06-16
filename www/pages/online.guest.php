<?php

include_once '../sys/inc/start.php';
$doc = new document();
$pages = new pages;

$bots = isset($_GET['bots']) ? '1' : '0';

$doc->tab(__('Роботы'), '?bots', $bots);
$doc->tab(__('Гости'), '?', !$bots);

$res = $db->prepare("SELECT COUNT(*) FROM `guest_online` WHERE `conversions` >= '5' AND `is_robot` = ?");
$res->execute(array($bots));
$pages->posts = $res->fetchColumn();

$doc->title = $bots ? __('Роботы на сайте (%s)', $pages->posts) : __('Гости на сайте (%s)', $pages->posts);

$q = $db->prepare("SELECT * FROM `guest_online` WHERE `conversions` >= '5' AND `is_robot` = ? ORDER BY `time_start` DESC LIMIT " . $pages->limit);
$q->execute(array($bots));
$listing = new listing();
while ($ank = $q->fetch()) {
    $post = $listing->post();
    $post->icon('guest');
    $post->title = $bots ? $ank['browser'] : __('Гость');
    $post->content[] = __("Переходов") . ': ' . $ank['conversions'];
    if (!$bots) {
        $post->content[] = __("Браузер") . ': ' . $ank['browser'];
    }
    $post->content[] = __("IP-адрес") . ": " . long2ip($ank['ip_long']);
}
$listing->display(__('Нет гостей'));

$pages->display('?' . ($bots ? 'bots' : '') . '&amp;');