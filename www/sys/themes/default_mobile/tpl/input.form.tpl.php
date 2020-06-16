<div class="form">
    <?=
    '<form id="' . $id . '" data-ajax-url="' . $ajax_url . '"' .
    ($method ? ' method="' . $method . '"' : '') .
    ($action ? ' action="' . $action . '"' : '') .
    ($files ? ' enctype="multipart/form-data"' : '')
    . '>'
    ?>

    <?
    foreach ($el AS $element) {
        if ($element['title'])
           echo '<div class="form_title">' . $element['title'] . ':</div>';
        switch ($element['type']) {
            case 'text':
                echo '<div class="form_text">' . $element['value'] . '</div>';
                break;
            case 'captcha':
                ?>
                <input type="hidden" name="captcha_session" value="<?= $element['session'] ?>"/>
                <img id="captcha" src="/captcha.php?captcha_session=<?= $element['session'] ?>&amp;<?= SID ?>"
                     alt="captcha"/><br/>
                <?= $lang->getString("Введите число с картинки") ?>:<br/>
                <input class="gradient_grey invert border padding radius"
                       type="number"
                       autocomplete="off"
                       name="captcha"
                       size="5"
                       maxlength="5"/>
                <?
                break;
            case 'input_text':
                echo '<input type="text"' .
                    ($element['info']['name'] ? ' name="' . $element['info']['name'] . '"' : '') .
                    ($element['info']['value'] ? ' value="' . text::toValue($element['info']['value']) . '"' : '') .
                    ($element['info']['maxlength'] ? ' maxlength="' . intval($element['info']['maxlength']) . '"' : '') .
                    ($element['info']['size'] ? ' size="' . intval($element['info']['size']) . '"' : '') .
                    ($element['info']['disabled'] ? ' disabled="disabled"' : '') .
                    ' />';
                break;
            case 'hidden':
                echo '<input type="hidden"' .
                    ($element['info']['name'] ? ' name="' . $element['info']['name'] . '"' : '') .
                    ($element['info']['value'] ? ' value="' . text::toValue($element['info']['value']) . '"' : '') .
                    ' />';
                break;
            case 'password':
                echo '<input type="password"' .
                    ($element['info']['name'] ? ' name="' . $element['info']['name'] . '"' : '') .
                    ($element['info']['value'] ? ' value="' . text::toValue($element['info']['value']) . '"' : '') .
                    ($element['info']['maxlength'] ? ' maxlength="' . intval($element['info']['maxlength']) . '"' : '') .
                    ($element['info']['size'] ? ' size="' . intval($element['info']['size']) . '"' : '') .
                    ($element['info']['disabled'] ? ' disabled="disabled"' : '') .
                    ' />';
                break;
            case 'textarea':
                echo '<div class="textarea"><textarea' .
                    ($element['info']['name'] ? ' name="' . $element['info']['name'] . '"' : '') .
                    ($element['info']['disabled'] ? ' disabled="disabled"' : '') .
                    '>' .
                    ($element['info']['value'] ? text::toValue($element['info']['value']) : '') .
                    '</textarea>
                    <div class="smiles"></div>
                    <div class="smiles_button"></div>
                    </div>';
                break;
            case 'checkbox':
                echo '<label><input type="checkbox"' .
                    ($element['info']['name'] ? ' name="' . $element['info']['name'] . '"' : '') .
                    ($element['info']['value'] ? ' value="' . text::toValue($element['info']['value']) . '"' : '') .
                    ($element['info']['checked'] ? ' checked="checked"' : '') .
                    ' />' .
                    ($element['info']['text'] ? ' ' . $element['info']['text'] : '') .
                    '</label>';
                break;
            case 'submit':
                echo '<input type="submit"' .
                    ($element['info']['name'] ? ' name="' . $element['info']['name'] . '"' : '') .
                    ($element['info']['value'] ? ' value="' . text::toValue($element['info']['value']) . '"' : '') .
                    ' />';
                break;
            case 'file':
                echo '<input type="file"' .
                    ($element['info']['name'] ? ' name="' . $element['info']['name'] . '"' : '') .
                    ($element['info']['multiple'] ? ' multiple="multiple"' : '') .
                    ' />';
                break;
            case 'select':
                echo '<select name="' . $element['info']['name'] . '">';
                foreach ($element['info']['options'] AS $option) {
                    if ($option['groupstart'])
                        echo '<optgroup label="' . $option[0] . '">';
                    elseif ($option['groupend'])
                        echo '</optgroup>';
                    else
                        echo '<option' .
                            ($option[2] ? ' selected="selected"' : '') .
                            ' value="' . $option[0] . '"' .
                            '>' .
                            $option[1] .
                            '</option>';
                }
                echo '</select>';
                break;
        }

        if ($element['br'])
            echo '<br />';
    }

    echo '</form>';
    ?>
    <? if ($refresh_url && !$ajax_url) { ?>
        <a class="refresh" title="<?= __('Обновить') ?>" href="<?= $refresh_url ?>"><img
                src="<?= $path ?>/img/refresh.png" alt=""/></a>
    <? } ?>
</div>