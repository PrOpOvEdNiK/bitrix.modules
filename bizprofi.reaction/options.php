<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Bitrix\Main\Text\HtmlFilter;
use Bitrix\Main\Type\Date;
use Bitrix\Main\Web\Uri;
use Bizprofi\Reaction\Tools\AdminHelper;
use Bizprofi\Tools\Lang;

// Вынесем идентификатор модуля в отдельную переменную чтобы было удобно использовать
// Капсом для ощущения константности
$MODULE_ID = 'bizprofi.reaction';

// Вынесем название формы в отдельную переменную
// Капсом для ощущения константности
$FORM_NAME = str_replace('.', '_', $MODULE_ID).'_form';

// Проверим подключен ли модуль
if (!Loader::includeModule($MODULE_ID)) {
    return;
}

$context = Context::getCurrent();
$request = $context->getRequest();

$arOptions = [];

// Инициализируем первый таб настроек
$arOptions['main'] = [
    Lang::render('4d33d9c1f37b08338d38584322522300'),
    [
        'checkTime',
        Lang::render('c87d03666a3856eb8cff4efb7095c1bd'),
        Option::get($MODULE_ID, 'checkTime'),
        ['checkbox', 'N'],
    ],
    [
        'checkTimeValue',
        Lang::render('d96275a8a3286b43f67f4e38f64618b3'),
        Option::get($MODULE_ID, 'checkTimeValue'),
        [
            'selectbox',
            [
                '1' => Lang::render('59e4b8f5e58352e7a1d43e0cfe66fa7b'),
                '2' => Lang::render('418fee2d7d05c06045ae9bf618b96c35'),
                '4' => Lang::render('c3fb6367fba03fb66cd55a9104434a4a'),
                '8' => Lang::render('457a681f60a44408fc93fc3fe8dc5192'),
            ],
        ],
    ],
    Lang::render('44200c101927d27ab0e3002d30c9a361'),
    [
        'checkCloseDay',
        Lang::render('aeca30d924a9e80cae4302989d8865a5'),
        Option::get($MODULE_ID, 'checkCloseDay'),
        ['checkbox', 'N'],
    ],
    Lang::render('cbaddcc207c0e79124185fa2b692f7e1'),
    [
        'enableDelete',
        Lang::render('2a75623cceb26a9cb02806fbfffafcc6'),
        Option::get($MODULE_ID, 'enableDelete'),
        ['checkbox', 'N'],
    ],
    [
        'enableDeleteAdmin',
        Lang::render('1b7d5050cbdbef9f1413c97202e0d27d'),
        Option::get($MODULE_ID, 'enableDeleteAdmin'),
        ['checkbox', 'N'],
    ],
    Lang::render('3969817c46835f6af741542ab3d275f1'),
    [
        'enablePingMessagesReaction',
        Lang::render('2efcb10a6205ddd1608c1cacc97c4864'),
        Option::get($MODULE_ID, 'enablePingMessagesReaction'),
        ['checkbox', 'N'],
    ],
];

// Распишем логику сохранения первого таба настроек
do {
    // Если запрос не соответствует нашим требованиям ничего делать не надо
    if (!$request->isPost() || !check_bitrix_sessid()) {
        break;
    }

    // Если сохраняется не первый таб ничего делать не надо
    if ('main' !== $request->get('tabControl_active_tab')) {
        break;
    }

    // Перебор всех опций таба
    foreach ($arOptions['main'] as $row) {
        // Если у опции не 4 ключа значит это не поле ввода или выбора данных
        if (4 !== count($row)) {
            continue;
        }

        // Подготовим имя опции
        $optionName = HtmlFilter::encode(
            trim($row[0])
        );

        // Подготовим значение
        $optionValue = HtmlFilter::encode(
            trim(
                $request->get($optionName)
            )
        );

        // В зависимости от типа опции сохраним значение
        switch ($row[3][0]) {
            case 'checkbox':
                Option::set($MODULE_ID, $optionName, $optionValue ?: 'N');
                break;

            default:
                Option::set($MODULE_ID, $optionName, $optionValue);
                break;
        }
    }

    // Сделаем редирект на страницу успеха
    $uri = new Uri($request->getRequestUri());
    $uri->addParams([
        'update_result' => 'ok',
        'update_tab' => 'main',
    ]);
    LocalRedirect($uri->getUri());
} while (false);

// Инициализируем второй таб настроек
try {
    if ($from = $request->get('date_from')) {
        $from = new Date($from);
    }
} catch (\Exception $ex) {
    $from = null;
}

if (null === $from) {
    $from = new Date(
        (new Date())->format('Y.m.01'),
        'Y.m.d'
    );
}

try {
    if ($to = $request->get('date_to')) {
        $to = new Date($to);
    }
} catch (\Exception $ex) {
    $to = null;
}

if (null === $to) {
    $to = new Date(
        (new Date())->format('Y.m.t'),
        'Y.m.d'
    );
}

$types = $request->get('generate_type');
if (!is_array($types)) {
    $types = [
        AdminHelper::TYPE_TASK,
        AdminHelper::TYPE_REPORT,
        AdminHelper::TYPE_COMMENT,
        // AdminHelper::TYPE_BIZPROC,
    ];
}

$arOptions['data'] = [
    Lang::render('a628de87e88238cb8292d73e7701fe28'),
    [
        '',
        Lang::render('3e7c25c92839b968aab93bc646fa9f40'),
        CalendarPeriod(
            'generate_date_from',
            $from,
            'generate_date_to',
            $to,
            $FORM_NAME,
            'Y'
        ),
        ['statichtml'],
    ],
    [
        'generate_type',
        Lang::render('834164ab61fd8bc14d59063f53520c33'),
        implode(',', $types),
        [
            'multiselectbox',
            [
                AdminHelper::TYPE_TASK => Lang::render('961b4cc3a6b34c4355cf056cec82dd2b'),
                AdminHelper::TYPE_REPORT => Lang::render('59cf42a51dc546fb7f4a2f64f05c9d48'),
                AdminHelper::TYPE_COMMENT => Lang::render('683a11c026873a138205e9bf00f35e71'),
                // AdminHelper::TYPE_BIZPROC => Lang::render('80661874ef589ce1ea01459a79806306'),
            ],
        ],
    ],
    [
        'note' => Lang::render('27e92f54cb3c5f81ccbef7bacb922457'),
    ],
];

// Распишем логику сохранения второго таба настроек
do {
    // Если запрос не соответствует нашим требованиям ничего делать не надо
    if (!$request->isPost() || !check_bitrix_sessid()) {
        break;
    }

    // Если сохраняется не второй таб ничего делать не надо
    if ('data' !== $request->get('tabControl_active_tab')) {
        break;
    }

    try {
        $helper = new AdminHelper(
            $request->get('generate_date_from'),
            $request->get('generate_date_to'),
            $request->get('generate_type')
        );

        $helper->generate();
    } catch (\Exception $ex) {
        \CAdminMessage::ShowMessage([
            'MESSAGE' => Lang::render($ex->getMessage()),
        ]);
    }

    // Сделаем редирект на страницу успеха
    $uri = new Uri($request->getRequestUri());
    $uri->addParams([
        'update_result' => 'ok',
        'update_tab' => 'data',
    ]);
    LocalRedirect($uri->getUri());
} while (false);

// Если сохранение прошло успешно
if ('ok' === $request->get('update_result')) {
    $message = Lang::render('22a617abe64a3985076d78b82721a967');
    if ('data' === $request->get('update_tab')) {
        $message = Lang::render('338a131a699df5efcacc5b50c088d091');
    }

    \CAdminMessage::ShowMessage([
        'MESSAGE' => $message,
        'TYPE' => 'OK',
    ]);
}

// Проинициализируем класс для работы с формами
$tabControl = new \CAdminTabControl('tabControl', [
    [
        'DIV' => 'main',
        'TAB' => Lang::render('c919d65bd95698af8f15fa8133bf490d'),
        'TITLE' => Lang::render('b475317d4d28461ae61ccf975b1c98f2'),
        'ICON' => 'main',
    ],
    [
        'DIV' => 'data',
        'TAB' => Lang::render('145f378b1aad98c7170062da2241d56c'),
        'TITLE' => Lang::render('3e5d9138c663b7037c6592e2630e9ec2'),
        'ICON' => 'data',
    ],
]);
?>
<form method="post" action="<?= $request->getRequestUri(); ?>" name="<?=HtmlFilter::encode($FORM_NAME); ?>">
    <?php
    // Вывод поля с идентификатором сессии
    echo bitrix_sessid_post();

    // Обозначим начало формы
    $tabControl->Begin();

    // Обозначим начало первого таба
    $tabControl->BeginNextTab();

    // Выводим поля первого таба
    __AdmSettingsDrawList($MODULE_ID, $arOptions['main']);

    // Обозначим начало второго таба
    $tabControl->BeginNextTab();

    // Выводим поля второго таба
    __AdmSettingsDrawList($MODULE_ID, $arOptions['data']);

    // Выводим кнопку сохранения
    $tabControl->Buttons([
        'disabled' => false,
        'btnApply' => false,
    ]);

    // Обозначим конец формы
    $tabControl->End();
    ?>
</form>
