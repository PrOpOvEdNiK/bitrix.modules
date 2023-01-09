ALTER TABLE `sib_kanban_project`
	ADD `KANBAN_SYNC_CONFLICT` enum('stage','status') COLLATE 'utf8_unicode_ci' NULL DEFAULT 'stage' AFTER `KANBAN_SYNC_TYPE`;
