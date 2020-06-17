<?php

include_once '../sys/inc/start.php';
$doc = new document();
$doc->title = __('Управление темой');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Refresh: 1; url=./');
    $doc->err(__('Ошибка выбора темы'));
    exit;
}
$id_theme = (int)$_GET['id'];

$q = $db->prepare("SELECT * FROM `forum_themes` WHERE `id` = ? AND (`group_edit` <= ? || `id_moderator` = ?)");
$q->execute(Array($id_theme, $user->group, $user->id));
if (!$theme = $q->fetch()) {
    header('Refresh: 1; url=./');
    $doc->err(__('Тема не доступна для редактирования'));
    exit;
}


$doc->title .= ' - ' . $theme['name'];

$res = $db->prepare("UPDATE `forum_themes` SET `top` = ? WHERE `id` = ? LIMIT 1");
$res->execute(Array((int) !$theme['top'], $theme['id']));

if ($theme['top']) {
    $doc->msg(__('Успешно откреплено'));
} else {
    $doc->msg(__('Успешно закреплено'));
}

header('Refresh: 1; url=./theme.php?id=' . $theme['id']);


$doc->ret(__('Вернуться в тему'), 'theme.php?id=' . $theme['id']);

$doc->ret(__('В раздел'), 'topic.php?id=' . $theme['id_topic']);
$doc->ret(__('В категорию'), 'category.php?id=' . $theme['id_category']);
$doc->ret(__('Форум'), './');