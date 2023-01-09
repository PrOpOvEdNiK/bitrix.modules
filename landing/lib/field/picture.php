<?php
namespace Bitrix\Landing\Field;

class Picture extends \Bitrix\Landing\Field
{
	/**
	 * Vew field.
	 * @param array $params Array params:
	 * name - field name
	 * class - css-class for this element
	 * additional - some additional params as is.
	 * @return void
	 */
	public function viewForm(array $params = array())
	{
		?>
		<input type="text" <?
		?><?= isset($params['additional']) ? $params['additional'] . ' ' : ''?><?
		?><?= $this->maxlength > 0 ? 'maxlength="'. $this->maxlength . '" ' : ''?><?
		?>class="<?= isset($params['class']) ? \htmlspecialcharsbx($params['class']) : ''?>" <?
		?>data-code="<?= \htmlspecialcharsbx($this->code)?>" <?
		?>name="<?= \htmlspecialcharsbx(isset($params['name_format'])
				? str_replace('#field_code#', $this->code, $params['name_format'])
				: $this->code)?>" <?
		?>value="<?= \htmlspecialcharsbx($this->value)?>" <?
		?> /> <a href="#">picture select</a>
		<?
	}

	/**
	 * Magic method return value as string.
	 * @return string
	 */
	public function __toString()
	{
		return (string)$this->value;
	}
}
