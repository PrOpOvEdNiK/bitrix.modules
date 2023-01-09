<?php

namespace Bizprofi\Reaction\Entity\Field;

use Bitrix\Main\ORM\Fields;
use Bitrix\Main\Web\Json;

class JsonField extends Fields\ScalarField
{
    /**
     * {@inheritdoc}
     */
    public function __construct($name, array $parameters)
    {
        parent::__construct($name, $parameters);

        $this->addFetchDataModifier(function ($json) {
            if (null !== $json) {
                if ($value = Json::decode($json, true)) {
                    return $value;
                }
            }
        });

        $this->addSaveDataModifier(function ($value) {
            if (null !== $value) {
                if ($json = Json::encode($value)) {
                    return $json;
                }
            }
        });
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function convertValueToDb($value)
    {
        return $this->getConnection()->getSqlHelper()->convertToDbText($value);
    }

    /**
     * @param mixed $value
     *
     * @throws \Bitrix\Main\SystemException
     *
     * @return string
     */
    public function convertValueFromDb($value)
    {
        return $this->getConnection()->getSqlHelper()->convertFromDbText($value);
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function cast($value)
    {
        return $value;
    }
}
