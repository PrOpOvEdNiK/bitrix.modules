<? $GLOBALS['_1206287724_']=Array(base64_decode('Y291bnQ='),base64_decode('Y291b' .'nQ='),base64_decode('Y29weQ=' .'='),base64_decode('' .'b' .'X' .'R' .'fcmFuZ' .'A=='),base64_decode('a' .'W1hZ' .'2Vjb3B' .'5' .'bWV' .'yZ2U=')); ?><?  ?>

<tr>

    <td class='scrumbanBlock'>



        <h3><?=GetMessage("SCRUMBAN_USERS_LICENCE_SUPPORTS")?> <?=$allowedUsersCount?></h3>



        <div class="header">

            <hr>

            <p><?=GetMessage("SCRUMBAN_USERS_ACTIVE_COUNT")?><small<? if($allowedUsersCount<$GLOBALS['_1206287724_'][0]($activatedUsersList)){ ?> class='warn'<? } ?>>(<?=GetMessage("SCRUMBAN_USERS_USED_COUNT")?> <b><?=$GLOBALS['_1206287724_'][1]($activatedUsersList)?></b> <?=GetMessage("SCRUMBAN_USERS_USED_FROM")?> <b><?=$allowedUsersCount?></b>)</small></p>

        </div>

        <? if($allowedUsersCount == 0){if($isTrial){ ?><?=GetMessage("SCRUMBAN_USERS_TRIAL_LIMIT")?><? }else{ ?><?=GetMessage("SCRUMBAN_LICENCE_NONE")?><? }} ?>

        <ol><? $count=0;foreach($activatedUsersIdList as $userId){if($count == $allowedUsersCount &&!$isTrial){break;}$count++;$user=$activatedUsersList[$userId];(3807-3807+14-14)?$GLOBALS['_1206287724_'][2]($isExtranetActive,$isTrial):$GLOBALS['_1206287724_'][3](2055,3807); ?><li><label>

                <input type='checkbox' name='activatedUsers[]' value='<?=$userId?>' checked='checked'>

                [<?=$userId?>] (<?=$user['LOGIN']?>)

                <?=$user['LAST_NAME']?> <?=$user['NAME']?> <?=$user['SECOND_NAME']?>

            </label></li><? } ?></ol>



        <hr>

        <h3><?=GetMessage("SCRUMBAN_LICENCES_ADD_USER")?></h3>



        <input name='newUsers' value='' type='hidden' id='activatedUsersNew'>

        <? $APPLICATION->SetAdditionalCSS("/bitrix/js/intranet/intranet-common.css"); ?>

        <? $APPLICATION->IncludeComponent("bitrix:intranet.user.selector.new","",array('MULTIPLE'=> 'Y','NAME'=> 'newUsers','IS_EXTRANET'=> 'N')); ?>

        <p><?=GetMessage("SCRUMBAN_EXTRANET_USERS_POLICY")?></p>



        <? $module=new CModule();while(3513-3513)$GLOBALS['_1206287724_'][4]($APPLICATION);if($module->IncludeModule('extranet')){ ?>

            <hr>

            <h3><?=GetMessage("SCRUMBAN_EXTRANET")?></h3>

            <input type='hidden' name='scrumbanExtranetSent' value='1'>

            <label><input type='checkbox' name='scrumbanExtranet' value='active' <?=$isExtranetActive?' checked="checked"':''?>> <?=GetMessage("SCRUMBAN_EXTRANET_ACTIVATE")?></label>

        <? } ?>



    </td>

</tr>