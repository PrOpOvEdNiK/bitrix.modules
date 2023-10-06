<?php

namespace Bizprofi\Reaction;

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\ORM\Query\Query;
use Bitrix\Main\Page\Asset;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\UserTable;
use Bitrix\Main\Web\Json;
use Bizprofi\Reaction\DataManager\NotificationBindingTable;
use Bizprofi\Reaction\DataManager\NotificationResponsibleTable;
use Bizprofi\Reaction\DataManager\NotificationTable;
use Bizprofi\Tools\Lang;

class_alias('Bizprofi\Reaction\MainEventHandler', 'Bizprofi\Reaction\Main');

class MainEventHandler
{
    public static function getAssetFilePath($assetFilePath = null){
        if(empty($assetFilePath)){
            return;
        }

        $filePath = \Bitrix\Main\Loader::getLocal($assetFilePath);
        if(strpos($filePath, $_SERVER['DOCUMENT_ROOT']) !== false){
            $filePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $filePath);
        }
        return $filePath;
    }

    public static function appendScriptsToPage()
    {
        if (\CSite::InDir('/pub/')) {
            return;
        }

        if ((defined('ADMIN_SECTION') && ADMIN_SECTION !== true) || !$GLOBALS['USER']->IsAuthorized()) {
            return;
        }

        \CJSCore::Init(['jquery', 'popup', 'sidepanel']);

        // Языковые фразы модуля реагирования
        $jsPhrases = Json::encode(
            [
                'REACTION_NOTIFY_1' => Lang::render('4eee9e21f8aadc98a3e87932649c7947'),
                'REACTION_NOTIFY_2' => Lang::render('25af0839ee406ea28be7374a7edf3fff'),
                'REACTION_NOTIFY_3' => Lang::render('9fa7b2dc1dfe321fdbe10c9d75405f35'),
                'REACTION_FINALIZE_WORK_DAY_MESSAGE' => Lang::render('80f2ef5fc150d33d04e6b1ed96e86e87'),
                'REACTION_EXISTS_NOTIFY_1' => Lang::render('275a52a7a7c95a3fb2031251a2d94627'),
                'REACTION_EXISTS_NOTIFY_2' => Lang::render('ebbb187981a2273d517cc711986474ff'),
                'REACTION_NEED_NOTIFY_MESSAGE' => Lang::render('7b62aa855b2bff2a77c1155b86b56adf'),
                'REACTION_POPUP_BTN_OK' => Lang::render('2b1accf60c159616afad0b310f6c49c0'),
                'REACTION_POPUP_BTN_CLOSE' => Lang::render('dd9463bd5d0c650b468fc5d6cfa1073c'),
                'REACTION_POPUP_BTN_VIEW' => Lang::render('d2ed721d0c08f9f114598a084f24c784'),
            ],
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );

        $GLOBALS['APPLICATION']->AddLangJS('<script>(window.BX||top.BX).message('.$jsPhrases.');</script>');

        $assetFilePath = static::getAssetFilePath('js/bizprofi.reaction/bizprofi-notify.js');
        if(!empty($assetFilePath)){
            Asset::getInstance()->addJs($assetFilePath);
        }

        $assetFilePath = static::getAssetFilePath('css/bizprofi.reaction/bizprofi-notify.css');
        if(!empty($assetFilePath)){
            Asset::getInstance()->addCss($assetFilePath);
        }

        $showAlert = false;
        if ('Y' === Option::get('bizprofi.reaction', 'checkTime')) {
            $nowTime = (new DateTime())->getTimestamp();
            $lastReactionTime = \CUserOptions::getOption(
                'bizprofi.reaction',
                'lastReactionTime'
            );

            if (!$lastReactionTime['time']) {
                $lastReactionTime = ['time' => $nowTime];

                \CUserOptions::setOption(
                    'bizprofi.reaction',
                    'lastReactionTime',
                    $lastReactionTime
                );
            }

            $checkTimeValue = Option::get('bizprofi.reaction', 'checkTimeValue');
            if ((($nowTime - $lastReactionTime['time']) / 3600) > $checkTimeValue) {
                $showAlert = true;
            }
        }

        $userId = $GLOBALS['USER'] instanceof \CUser ? (int) $GLOBALS['USER']->getId() : 0;
        $notifyCount = NotificationTable::getCountByUserIds([$userId], false);

        $jsonParams = Json::encode([
            'showAlert' => $showAlert,
            'blockDay' => 'Y' === Option::get('bizprofi.reaction', 'checkCloseDay'),
            'countNeed' => $notifyCount[$userId]['countNeed'],
        ]);

        Asset::getInstance()->addString("
        <script>
        BX.ready(function () {
            if (typeof initialize_reaction === 'function') {
                initialize_reaction(".$jsonParams.');
            }
        });
        </script>
        ');
    }

    public static function OnGetDependentModule()
    {
        return [
            'MODULE_ID' => 'bizprofi.reaction',
            'USE' => ['PUBLIC_SECTION'],
        ];
    }

    // Обработчик обновления полей пользователя
    public static function OnBeforeUserUpdate($fields)
    {
        static::moveReportNotificationOnChangeDepartment($fields);
    }

    // При изменении отдела у сотрудника перенесем уведомления отчетов на нового руководителя
    protected static function moveReportNotificationOnChangeDepartment($fields)
    {
        if (!($newManagerId = static::getUserManagerByFields($fields))) {
            return;
        }

        if (!($oldManagerId = static::getUserManager((int) $fields['ID']))) {
            return;
        }

        // Если руководители совпадают ничего делать не надо
        if ($newManagerId === $oldManagerId) {
            return;
        }

        // Получим все уведомления которые нужно перенести
        $rows = NotificationTable::query()
            ->addSelect('*')
            ->where(
                Query::filter()
                    ->logic('or')
                    ->where(
                        Query::filter()
                            ->logic('and')
                            ->where('FROM_USER', (int) $fields['ID'])
                            ->where('TO_USER', $oldManagerId)
                            ->where('DIRECTION', NotificationTable::NEED_REACTION)
                    )
                    ->where(
                        Query::filter()
                            ->logic('and')
                            ->where('FROM_USER', $oldManagerId)
                            ->where('TO_USER', (int) $fields['ID'])
                            ->where('DIRECTION', NotificationTable::WAIT_REACTION)
                    )
            )
            ->where('BINDING.ENTITY_TYPE', NotificationBindingTable::REPORT_ENTITY)
            ->exec();

        Application::getConnection()->startTransaction();

        $notificationIds = [];

        // Перенесем уведомления на нового руководителя
        while ($notification = $rows->fetchObject()) {
            $notificationIds[] = $notification->getId();

            if (NotificationTable::NEED_REACTION === $notification->getDirection()) {
                $notification->setToUser($newManagerId);
            } else {
                $notification->setFromUser($newManagerId);
            }

            $saveResult = $notification->save();
            if (!$saveResult->isSuccess()) {
                Application::getConnection()->rollbackTransaction();
                AddMessage2Log([
                    'text' => 'Failure move report notification',
                    'data' => [
                        'USER_ID' => (int) $fields['ID'],
                        'OLD_MANAGER_ID' => $oldManagerId,
                        'NEW_MANAGER_ID' => $newManagerId,
                        'ERRORS' => $saveResult->getErrorMessages(),
                    ],
                ]);

                return;
            }
        }

        if (0 < count($notificationIds)) {
            $rows = NotificationResponsibleTable::query()
                ->addSelect('*')
                ->whereIn('NOTIFICATION_ID', $notificationIds)
                ->where('USER_ID', $oldManagerId)
                ->exec();

            while ($row = $rows->fetchObject()) {
                $responsible = NotificationResponsibleTable::createObject();
                $responsible->setNotificationId($row->getNotificationId());
                $responsible->setEntityType($row->getEntityType());
                $responsible->setEntityId($row->getEntityId());
                $responsible->setUserId($newManagerId);

                $saveResult = $responsible->save();
                if (!$saveResult->isSuccess()) {
                    Application::getConnection()->rollbackTransaction();
                    AddMessage2Log([
                        'text' => 'Failure move report notification responsibles',
                        'data' => [
                            'USER_ID' => (int) $fields['ID'],
                            'OLD_MANAGER_ID' => $oldManagerId,
                            'NEW_MANAGER_ID' => $newManagerId,
                            'ERRORS' => $saveResult->getErrorMessages(),
                        ],
                    ]);

                    return;
                }

                $row->delete();
            }
        }

        Application::getConnection()->commitTransaction();

        NotificationTable::getCountByUserIds([$newManagerId, $oldManagerId, (int) $fields['ID']]);
    }

    // Возвращает руководителя сотрудника по полям пользователя
    protected static function getUserManagerByFields(array $fields): int
    {
        // Если сотрудник не состоит в отделах то ничего не делаем
        $departments = $fields['UF_DEPARTMENT'];
        if (!is_array($departments) || 0 >= $departments) {
            return 0;
        }

        // Получим руководителя сотрудника
        return static::getUserManagerByDepartments((int) $fields['ID'], $departments);
    }

    // Возвращает руководителя сотрудника идентификатору пользователя
    protected static function getUserManager(int $userId): int
    {
        // Получим актуальное значение полей пользователя
        $row = UserTable::query()
            ->setSelect(['*', 'UF_DEPARTMENT'])
            ->where('ID', $userId)
            ->setLimit(1)
            ->exec()
            ->fetch();

        if (empty($row)) {
            return 0;
        }

        // Если в актуальных полях сотрудника нет данных об отделах прервем выполнение
        $departments = $row['UF_DEPARTMENT'];
        if (!is_array($departments) || 0 >= $departments) {
            return 0;
        }

        // Получим актуального руководителя сотрудника
        return  static::getUserManagerByDepartments($userId, $departments);
    }

    // Возвращает руководителя сотрудника по отделам в которых тот состоит
    protected static function getUserManagerByDepartments(int $userId, array $departments): int
    {
        if (!Loader::includeModule('intranet')) {
            return 0;
        }

        // Получим данные о структуре компании
        $structure = \CIntranetUtils::GetStructure();
        $data = $structure['DATA'];

        // Пробежимся по отделам и сформируем массив руководителей
        $managers = [];
        foreach ($departments as $departmentId) {
            // Сохраним данные отдела в переменную
            $department = $data[$departmentId];

            // Если в отделе нет руководителя или он не активен, запишем в переменную вышестоящий отдел в котором есть руководитель
            while (
                (
                    0 >= (int) $department['UF_HEAD']
                    || (int) $department['UF_HEAD'] === $userId
                    || (
                        !($user = \CUser::GetByID((int) $department['UF_HEAD'])->Fetch())
                        || 'N' === $user['ACTIVE']
                    )
                )
                && 0 < (int) $department['IBLOCK_SECTION_ID']
            ) {
                $department = $data[$department['IBLOCK_SECTION_ID']];
            }

            if ($department['UF_HEAD']) {
                $managers[] = $department['UF_HEAD'];
            }
        }

        // Если нет руководителей прервем выполнение
        if (0 >= count($managers)) {
            return 0;
        }

        // Вернем первого руководителя
        $manager = array_shift($managers);

        return (int) $manager;
    }
}
