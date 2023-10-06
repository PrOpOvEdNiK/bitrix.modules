<?php

namespace Bizprofi\Reaction\DataManager;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields;
use Bizprofi\Reaction\Tools\CommonHelper;

/**
 * Class NotificationTable.
 */
class NotificationBindingTable extends DataManager
{
    // Типы сущностей для привязок
    const TASK_ENTITY = 2;
    const SOC_LOG_REPORT_ENTITY = 5;
    const SOC_LOG = 8;
    const CRM_ENTITY = 9;
    const POST_ENTITY = 13;

    // Типы сущностей
    const TASK_CONSTROL_ENTITY = 1;
    const MESSAGE_ENTITY = 3;
    const REPORT_ENTITY = 4;
    const COMMENT_REPORT_ENTITY = 6;
    const SOC_LOG_COMMENT = 7;
    const CRM_ENTITY_COMMENT = 10;
    const BP_TASK = 11;
    const BLOG_COMMENT = 14;
    const POST_NOTIFY = 15;
    const TASK_ACKNOWLEDGE_ENTITY = 16;

    // Системное
    const DONT_USE_IT_RESERVED_FOR_ENTITY_FILTER = 12;

    // Для аггрегаций
    const AGGREGATION_TYPE_ALL = 'all';
    const AGGREGATION_TYPE_BIZPROC = 'bizproc';
    const AGGREGATION_TYPE_COMMENT = 'comment';
    const AGGREGATION_TYPE_REPORT = 'report';
    const AGGREGATION_TYPE_TASK = 'task';

    /**
     * {@inheritdoc}
     */
    public static function getTableName()
    {
        return 'bizprofi_reaction_notification_binding';
    }

    public static function checkEntityAlreadyLiked($relatedEntities = null, $currentUserId = null)
    {
        $alreadyLiked = '';
        if(empty($relatedEntities) || empty($currentUserId)){
            return '';
        }

        global $DB;
        $sql = '';
        if($relatedEntities['ENTITY_TYPE_CODE'] == 'SOC_LOG_COMMENT'){
            $sql = 'SELECT ID FROM b_rating_vote WHERE';
            $sql .= ' USER_ID='.$currentUserId;
            $sql .= ' && ENTITY_ID='.$relatedEntities['RATING_ENTITY_ID'];
            $sql .= ' && ENTITY_TYPE_ID="'.$relatedEntities['RATING_TYPE_ID'].'"';
        } else if($relatedEntities['ENTITY_TYPE_CODE'] == 'MESSAGE_ENTITY' && !empty($relatedEntities['FORUM_ID'])){
            $sql = 'SELECT ID FROM b_rating_vote WHERE';
            $sql .= ' USER_ID='.$currentUserId;
            $sql .= ' && ENTITY_ID='.$relatedEntities['ID'];
            $sql .= ' && ENTITY_TYPE_ID="FORUM_POST"';
        } else if(in_array($relatedEntities['ENTITY_TYPE_CODE'], ['TASK_ENTITY'])){
            //nothing here
        } else {
            CommonHelper::writeLog(__FUNCTION__.' have no logic for ENTITY_TYPE_CODE '.$relatedEntities['ENTITY_TYPE_CODE'].', ID: '.$relatedEntities['ID']);
        }

        if(!empty($sql)){
            $queryResult = $DB->Query($sql);
            if($rowData = $queryResult->Fetch()){
                $alreadyLiked = $rowData['ID'];
            }
        }

        return $alreadyLiked;
    }
    

    public static function getEntityCodeById($entityTypeId = null)
    {
        if(empty($entityTypeId)){
            return '';
        }

        $entityTypeCode = '';
        $reflection = new \ReflectionClass(self::class);
        $constants = $reflection->getConstants();
        foreach($constants as $code => $value){
            if(intval($value) == intval($entityTypeId)){
                $entityTypeCode = $code;
                break;
            }
        }
        
        return $entityTypeCode;
    }

    /**
     * {@inheritdoc}
     */
    public static function getMap()
    {
        return [
            new Fields\IntegerField('NOTIFICATION_ID', [
                'title' => 'ID',
                'primary' => true,
            ]),
            new Fields\IntegerField('ENTITY_TYPE', [
                'title' => 'ENTITY_TYPE',
                'primary' => true,
            ]),
            new Fields\IntegerField('ENTITY_ID', [
                'title' => 'ENTITY_ID',
                'primary' => true,
            ]),
        ];
    }

    public static function getEntityTypes()
    {
        return [
            static::TASK_ACKNOWLEDGE_ENTITY,
            static::TASK_CONSTROL_ENTITY,
            static::MESSAGE_ENTITY,
            static::REPORT_ENTITY,
            static::COMMENT_REPORT_ENTITY,
            static::SOC_LOG_COMMENT,
            static::CRM_ENTITY_COMMENT,
            static::BP_TASK,
            static::BLOG_COMMENT,
            static::POST_NOTIFY,
        ];
    }

    // Возвращает типы сущностей по коду аггрегации
    public static function aggregateEntityTypes(string $type): array
    {
        if (static::AGGREGATION_TYPE_BIZPROC === $type) {
            return [
                static::BP_TASK,
            ];
        }

        if (static::AGGREGATION_TYPE_COMMENT === $type) {
            return [
                static::MESSAGE_ENTITY,
                static::COMMENT_REPORT_ENTITY,
                static::SOC_LOG_COMMENT,
                static::CRM_ENTITY_COMMENT,
                static::BLOG_COMMENT,
                static::POST_NOTIFY,
            ];
        }

        if (static::AGGREGATION_TYPE_REPORT === $type) {
            return [
                static::REPORT_ENTITY,
            ];
        }

        if (static::AGGREGATION_TYPE_TASK === $type) {
            return [
                static::TASK_CONSTROL_ENTITY,
                static::TASK_ACKNOWLEDGE_ENTITY,
            ];
        }

        // static::AGGREGATION_TYPE_ALL
        return static::getEntityTypes();
    }

    public static function getSocLogNotyRelatedEntityData($data = null)
    {
        $dealData = [];
        if(empty($data)){
            return $dealData;
        }
        
        if(empty($data['CRM_ACT_ID'])){
            return $dealData;
        }

        global $DB;
        $actData = [];
        $actResult = $DB->Query('SELECT OWNER_ID, OWNER_TYPE_ID FROM b_crm_act WHERE ID='.$data['CRM_ACT_ID']);
        while($actRow = $actResult->Fetch()){
            if(!empty($actRow['OWNER_ID']) && $actRow['OWNER_TYPE_ID'] == 2){
                $dealResult = $DB->Query('SELECT ID,TITLE FROM b_crm_deal WHERE ID='.$actRow['OWNER_ID']);
                $dealData = $dealResult->Fetch();
            }
        }
        
        return $dealData;
    }
}
