<?php

namespace Bizprofi\Reaction\Tools;

use Bitrix\Main\Loader;

class ManagementHelper
{
    // Свойство для кеширования
    protected $cache = [];

    public function __construct(int $userId)
    {
        if (0 >= $userId) {
            throw new \Exception(
                'Incorrect user id'
            );
        }

        // Получим данные о пользователе
        $this->userId = $userId;
    }

    // Возвращает подчиненных сотрудников
    public function getManagedUsers(int $department = 0): array
    {
        // Проверим наличие закешированных данных
        $cache = &$this->cache[md5(serialize(['getManagedUsers', $department]))];
        if (is_array($cache)) {
            return $cache;
        }

        // Если модуль интранет не подключен вернем пустой результат
        if (!Loader::includeModule('intranet')) {
            return $cache = [];
        }

        if (0 >= $department) {
            // Получим всех подчиненных сотрудника
            $rows = \CIntranetUtils::getSubordinateEmployees(
                $this->userId,
                true,
                'Y',
                ['ID', 'NAME', 'LAST_NAME', 'LOGIN', 'EMAIL', 'PERSONAL_PHOTO']
            );
        } else {
            $rows = \CIntranetUtils::getDepartmentEmployees(
                [$department],
                true,
                true,
                'Y',
                ['ID', 'NAME', 'LAST_NAME', 'LOGIN', 'EMAIL', 'PERSONAL_PHOTO']
            );
        }

        $allowEmployeesIds = [];
        if (0 < $department) {
            $allowEmployeesIds = array_filter(
                array_map(
                    'intval',
                    array_keys($this->getManagedUsers())
                )
            );
        }

        $users = [];
        // Переберем результат и преобразуем значения
        while ($row = $rows->fetch()) {
            if (0 < $department && !in_array((int) $row['ID'], $allowEmployeesIds, true)) {
                continue;
            }

            // Получим аватар
            $row['AVATAR'] = \CIntranetUtils::createAvatar($row);

            // Отформатируем имя
            $row['NAME_FORMATTED'] = \CUser::formatName(
                \CSite::getNameFormat(null, SITE_ID),
                $row,
                true
            );

            // Сохраним параметры в переменной
            $users[$row['ID']] = $row;
        }

        // Вернем результат
        return $cache = $users;
    }

    // Проверяет имеет ли пользователь право на управление
    public function enableManagement(): bool
    {
        return 0 < count(
            $this->getManagedUsers()
        );
    }

    // Проверяет может ли пользователь просматривать уведомления пользователя
    public function haveViewNotifications(int $to): bool
    {
        if ($this->userId === $to) {
            return true;
        }

        if (!$this->enableManagement()) {
            return false;
        }

        $ids = array_filter(
            array_unique(
                array_map(
                    'intval',
                    array_keys(
                        $this->getManagedUsers()
                    )
                )
            )
        );

        return in_array($to, $ids, true);
    }
}
