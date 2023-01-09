<?php

namespace Bizprofi\Reaction\Tools;

use Bitrix\Main\Loader;

class ManagementHelper
{
    // �������� ��� �����������
    protected $cache = [];

    public function __construct(int $userId)
    {
        if (0 >= $userId) {
            throw new \Exception(
                'Incorrect user id'
            );
        }

        // ������� ������ � ������������
        $this->userId = $userId;
    }

    // ���������� ����������� �����������
    public function getManagedUsers(int $department = 0): array
    {
        // �������� ������� �������������� ������
        $cache = &$this->cache[md5(serialize(['getManagedUsers', $department]))];
        if (is_array($cache)) {
            return $cache;
        }

        // ���� ������ �������� �� ��������� ������ ������ ���������
        if (!Loader::includeModule('intranet')) {
            return $cache = [];
        }

        if (0 >= $department) {
            // ������� ���� ����������� ����������
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
        // ��������� ��������� � ����������� ��������
        while ($row = $rows->fetch()) {
            if (0 < $department && !in_array((int) $row['ID'], $allowEmployeesIds, true)) {
                continue;
            }

            // ������� ������
            $row['AVATAR'] = \CIntranetUtils::createAvatar($row);

            // ������������� ���
            $row['NAME_FORMATTED'] = \CUser::formatName(
                \CSite::getNameFormat(null, SITE_ID),
                $row,
                true
            );

            // �������� ��������� � ����������
            $users[$row['ID']] = $row;
        }

        // ������ ���������
        return $cache = $users;
    }

    // ��������� ����� �� ������������ ����� �� ����������
    public function enableManagement(): bool
    {
        return 0 < count(
            $this->getManagedUsers()
        );
    }

    // ��������� ����� �� ������������ ������������� ����������� ������������
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
