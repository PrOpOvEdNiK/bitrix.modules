<?php

namespace Bizprofi\Reaction;

use Bitrix\Main\Loader;
use Bizprofi\Reaction\DataManager\NotificationTable;

/**
 * Class NotifyEventsHandler.
 */
class NotifyEventsHandler
{
    use NotifyEventsHandlerTraits\BizprocHandlers,
        NotifyEventsHandlerTraits\BlogCommentHandlers,
        NotifyEventsHandlerTraits\BlogPostHandlers,
        NotifyEventsHandlerTraits\MainHandlers,
        NotifyEventsHandlerTraits\ReportHandlers,
        NotifyEventsHandlerTraits\SocialnetworkHandlers,
        NotifyEventsHandlerTraits\TasksHandlers,
        NotifyEventsHandlerTraits\CrmTimelineHandlers;

    /**
     * @param $message
     *
     * @return array
     */
    protected static function getUsersFromMessage($message) : array
    {
        // ������� �� ����������� ��� ������
        $message = preg_replace("/\[quote\](.+?)\[\/quote\]/is".BX_UTF_PCRE_MODIFIER, '', $message);

        $ids = [];

        // ������ ��� ����������
        preg_match_all("/\[user\s*=\s*([^\]]*)\](.+?)\[\/user\]/is".BX_UTF_PCRE_MODIFIER, $message, $matches);

        // ���� ������� ���������� ������ �������������� �������������
        if (
            is_array($matches)
            && !empty($matches)
            && !empty($matches[1])
            && is_array($matches[1])
        ) {
            $ids = $matches[1];
        }

        // ������ ������ � ������������� ��������
        return array_filter(
            array_unique($ids)
        );
    }

    /**
     * @param array $users
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    protected static function sendPull(array $users)
    {
        if (!Loader::includeModule('pull')) {
            return;
        }

        NotificationTable::getCountByUserIds($users);
    }
}
