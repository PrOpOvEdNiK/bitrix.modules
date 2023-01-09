<?php
namespace Bitrix\Landing\Node;

class Ul extends \Bitrix\Landing\Node
{
	/**
	 * Get class - frontend handler.
	 * @return string
	 */
	public static function getHandlerJS()
	{
		return 'BX.Landing.Block.Node.Ul';
	}

	/**
	 * Save data for this node.
	 * @param \Bitrix\Landing\Block &$block Block instance.
	 * @param string $selector Selector.
	 * @param array $data Data array.
	 * @return void
	 */
	public static function saveNode(\Bitrix\Landing\Block &$block, $selector, array $data)
	{
		$doc = $block->getDom();

		foreach ($data as $pos => $value)
		{
			if (!empty($value))
			{
				$ulContent = '';
				foreach ($value as $val)
				{
					if (isset($val['original']))
					{
						$ulContent .= '<li>';
						$ulContent .= strip_tags(
								str_replace(
									'#VAL#',
									\htmlspecialcharsbx($val['content']),
									$val['original']
								),
							'<b><i><u>'
						);
						$ulContent .= '</li>';
					}
				}

				$resultList = $doc->querySelectorAll($selector);
				if (isset($resultList[$pos]))
				{
					$resultList[$pos]->setInnerHTML($ulContent);
				}
			}
		}
	}
}