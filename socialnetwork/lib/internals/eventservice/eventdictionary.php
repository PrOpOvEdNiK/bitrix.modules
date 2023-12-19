<?php

/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage socialnetwork
 * @copyright 2001-2022 Bitrix
 */

namespace Bitrix\Socialnetwork\Internals\EventService;

class EventDictionary
{
	public const
		EVENT_WORKGROUP_ADD = 'onWorkgroupAdd',
		EVENT_WORKGROUP_BEFORE_UPDATE = 'onWorkgroupBeforeUpdate',
		EVENT_WORKGROUP_UPDATE = 'onWorkgroupUpdate',
		EVENT_WORKGROUP_DELETE = 'onWorkgroupDelete',
		EVENT_WORKGROUP_USER_ADD = 'onWorkgroupUserAdd',
		EVENT_WORKGROUP_USER_UPDATE = 'onWorkgroupUserUpdate',
		EVENT_WORKGROUP_USER_DELETE = 'onWorkgroupUserDelete',
		EVENT_WORKGROUP_FAVORITES_CHANGED = 'onWorkgroupFavoritesChanged',
		EVENT_WORKGROUP_PIN_CHANGED = 'onWorkgroupPinChanged',
		EVENT_WORKGROUP_MEMBER_REQUEST_CONFIRM = 'onWorkgroupMemberRequestConfirm',
		EVENT_WORKGROUP_SUBSCRIBE_CHANGED = 'onWorkgroupSubscribeChanged';

	public const
		EVENT_SPACE_TASKS_COMMON = 'onSpaceTaskCommonEvent',
		EVENT_SPACE_TASK_ADD = 'onAfterTaskAdd',
		EVENT_SPACE_TASK_UPDATE = 'onAfterTaskUpdate',
		EVENT_SPACE_TASK_DELETE = 'onAfterTaskDelete',
		EVENT_SPACE_TASK_COMMENT_ADD = 'onAfterTaskCommentAdd',
		EVENT_SPACE_TASK_COMMENT_DELETE = 'onAfterTaskCommentDelete';

	public const
		EVENT_SPACE_CALENDAR_COMMON = 'onSpaceCalendarCommonEvent',
		EVENT_SPACE_CALENDAR_INVITE = 'onSpaceCalendarInviteEvent';

	public const
		EVENT_SPACE_LIVEFEED_COUNTER_UPD = 'onLiveFeedCounterUpdate',
		EVENT_SPACE_LIVEFEED_POST_ADD = 'onLiveFeedAdd',
		EVENT_SPACE_LIVEFEED_POST_UPD = 'onLiveFeedUpdate',
		EVENT_SPACE_LIVEFEED_POST_DEL = 'onLiveFeedDelete',
		EVENT_SPACE_LIVEFEED_POST_VIEW = 'onLiveFeedViewed',
		EVENT_SPACE_LIVEFEED_COMMENT_ADD = 'onLiveFeedAddComment',
		EVENT_SPACE_LIVEFEED_COMMENT_UPD = 'onLiveFeedUpdateComment',
		EVENT_SPACE_LIVEFEED_COMMENT_DEL = 'onLiveFeedDeleteComment',
		EVENT_SPACE_LIVEFEED_READ_ALL = 'onLiveFeedReadAll';

	public const
		EVENT_SPACE_USER_ROLE_CHANGE = 'onUserRoleChanged';

	public const EVENT_GARBAGE_COLLECT = 'onGarbageCollect';

	public const SPACE_EVENTS_SUPPORTED = [
		self::EVENT_WORKGROUP_USER_ADD,
		self::EVENT_WORKGROUP_USER_UPDATE,
		self::EVENT_WORKGROUP_USER_DELETE,
		self::EVENT_WORKGROUP_MEMBER_REQUEST_CONFIRM,
		self::EVENT_SPACE_CALENDAR_INVITE,
		self::EVENT_SPACE_TASKS_COMMON,
		self::EVENT_SPACE_TASK_ADD,
		self::EVENT_SPACE_TASK_UPDATE,
		self::EVENT_SPACE_TASK_DELETE,
		self::EVENT_SPACE_TASK_COMMENT_ADD,
		self::EVENT_SPACE_TASK_COMMENT_DELETE,
		self::EVENT_SPACE_LIVEFEED_POST_ADD,
		self::EVENT_SPACE_LIVEFEED_POST_UPD,
		self::EVENT_SPACE_LIVEFEED_POST_DEL,
		self::EVENT_SPACE_LIVEFEED_POST_VIEW,
		self::EVENT_SPACE_LIVEFEED_COMMENT_ADD,
		self::EVENT_SPACE_LIVEFEED_COMMENT_UPD,
		self::EVENT_SPACE_LIVEFEED_COMMENT_DEL,
		self::EVENT_SPACE_LIVEFEED_READ_ALL,
	];
}
