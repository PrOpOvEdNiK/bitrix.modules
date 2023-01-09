<?php

namespace Bitrix\Voximplant\Integration\Report\Dashboard\MissedReaction;

use Bitrix\Main\Localization\Loc;
use Bitrix\Report\VisualConstructor\Entity\Dashboard;
use Bitrix\Report\VisualConstructor\Entity\DashboardRow;
use Bitrix\Report\VisualConstructor\Entity\Report;
use Bitrix\Report\VisualConstructor\Entity\Widget;
use Bitrix\Report\VisualConstructor\Handler\BaseWidget;
use Bitrix\Report\VisualConstructor\Helper\Util;
use Bitrix\Voximplant\Integration\Report\View;
use Bitrix\Voximplant\Integration\Report\Handler;

class MissedReactionBoard
{
	public const VERSION = 'v8';
	public const BOARD_KEY = 'telephony_missed_reaction';

	public static function get(): Dashboard
	{
		$board = new Dashboard();
		$board->setVersion(self::VERSION);
		$board->setBoardKey(static::BOARD_KEY);
		$board->setGId(Util::generateUserUniqueId());
		$board->setUserId(0);

		$firstRow = DashboardRow::factoryWithHorizontalCells(1);
		$firstRow->setWeight(1);
		$chart = static::buildMissedReactionGraph();
		$chart->setWeight($firstRow->getLayoutMap()['elements'][0]['id']);
		$firstRow->addWidgets($chart);
		$board->addRows($firstRow);

		$secondRow = DashboardRow::factoryWithHorizontalCells(1);
		$secondRow->setWeight(2);
		$grid = static::buildMissedReactionGrid();
		$grid->setWeight($secondRow->getLayoutMap()['elements'][0]['id']);
		$secondRow->addWidgets($grid);
		$board->addRows($secondRow);

		return $board;
	}

	/**
	 * @return Widget
	 */
	protected static function buildMissedReactionGraph(): Widget
	{
		$widget = new Widget();
		$widget->setGId(Util::generateUserUniqueId());
		$widget->setWidgetClass(BaseWidget::getClassName());
		$widget->setViewKey(View\MissedReaction\MissedReactionGraph::VIEW_KEY);
		$widget->setCategoryKey('telephony');
		$widget->setBoardId(static::BOARD_KEY);
		$widget->getWidgetHandler(true)
			   ->updateFormElementValue('label', Loc::getMessage('TELEPHONY_REPORT_MISSED_REACTION_CALLS'));
		$widget->addConfigurations($widget->getWidgetHandler(true)->getConfigurations());

		$report = new Report();
		$report->setGId(Util::generateUserUniqueId());
		$report->setReportClassName(Handler\MissedReaction\MissedReaction::class);
		$report->setWidget($widget);
		$report->addConfigurations($report->getReportHandler(true)->getConfigurations());
		$widget->addReports($report);

		return $widget;
	}

	/**
	 * @return Widget
	 */
	protected static function buildMissedReactionGrid(): Widget
	{
		$widget = new Widget();
		$widget->setGId(Util::generateUserUniqueId());
		$widget->setWidgetClass(BaseWidget::getClassName());
		$widget->setViewKey(View\MissedReaction\MissedReactionGrid::VIEW_KEY);
		$widget->setCategoryKey('telephony');
		$widget->setBoardId(static::BOARD_KEY);
		$widget->getWidgetHandler(true)
			   ->updateFormElementValue('label', Loc::getMessage('TELEPHONY_REPORT_MISSED_REACTION_TIME'));
		$widget->addConfigurations($widget->getWidgetHandler(true)->getConfigurations());

		$report = new Report();
		$report->setGId(Util::generateUserUniqueId());
		$report->setReportClassName(Handler\MissedReaction\MissedReaction::class);
		$report->setWidget($widget);
		$report->addConfigurations($report->getReportHandler(true)->getConfigurations());
		$widget->addReports($report);

		return $widget;
	}
}