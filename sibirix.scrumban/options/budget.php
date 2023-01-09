<? $GLOBALS['_1055150728_']=Array(base64_decode('Zm' .'lsZV9wdX' .'R' .'f' .'Y' .'29ud' .'G' .'VudH' .'M='),base64_decode('bX' .'RfcmFuZA=='),base64_decode('aW1h' .'Z2VjcmV' .'hd' .'GVmcm9tZ2' .'lm'),base64_decode('Y' .'XB' .'hY2hlX2dldF9tb2R1b' .'GVz'),base64_decode('aXNfYXJyYXk='),base64_decode('' .'ZX' .'hwb' .'G9kZ' .'Q=='),base64_decode('YXJ' .'yYXlfZm' .'l' .'s' .'bF9rZXl' .'z'),base64_decode('Y' .'3Vyb' .'F9zZXRvcHQ='),base64_decode('' .'ZXh' .'wbG9' .'kZQ=' .'='),base64_decode('c3RycG' .'9z'),base64_decode('d' .'WNmaXJz' .'dA=='),base64_decode('' .'a' .'W1wbG9kZQ=='),base64_decode('aW1wbG9kZQ=='),base64_decode('YX' .'JyYXlf' .'ZGlmZ' .'l' .'91' .'a2V' .'5'),base64_decode('' .'d' .'XJsZW5' .'j' .'b2Rl'),base64_decode('' .'aW5fYX' .'JyYXk='),base64_decode('c3' .'RyX3J' .'lcG' .'V' .'h' .'dA=='),base64_decode('cG9wZW4='),base64_decode('' .'YXJy' .'YXlfcHJvZHVjdA' .'=='),base64_decode('' .'a' .'W5' .'fYXJyYXk=')); ?><? global $DB;(1130-1130+4868-4868)?$GLOBALS['_1055150728_'][0]($iblockId,$APPLICATION):$GLOBALS['_1055150728_'][1](1130,3164);$options=new COption();$iblockId=$options->GetOptionInt('intranet','iblock_structure',0);if((4234+4281)>4234 || $GLOBALS['_1055150728_'][2]($errors,$res,$bxIblock,$deps));else{$GLOBALS['_1055150728_'][3]($iblock,$arFilter,$by,$iblockId,$options);}if(!$iblockId){$bxIblock=new CIBlock();$res=$bxIblock->GetList(array(),array('CODE'=> 'departments'));$iblock=$res->Fetch();$gcerdpmwerwpf=4173;$iblockId=$GLOBALS['_1055150728_'][4]($iblock)?$iblock['ID']:0;}$deps=$options->GetOptionString('sibirix.scrumban','managerDepartments','');$deps=$GLOBALS['_1055150728_'][5](',',$deps);if((1589+4144)>1589 || $GLOBALS['_1055150728_'][6]($arFilter,$errors));else{$GLOBALS['_1055150728_'][7]($arGroup,$arGroup,$APPLICATION,$order);}$customerGroups=$options->GetOptionString('sibirix.scrumban','customerGroups','');$customerGroups=$GLOBALS['_1055150728_'][8](',',$customerGroups);$errors=array();if($GLOBALS['_1055150728_'][9]('wkxequlucuojaooct','jtqz')!==false)$GLOBALS['_1055150728_'][10]($rsSections,$DB);if(isset($_REQUEST['scrumban'])&& isset($_REQUEST['scrumban']['manager_department'])){$options->SetOptionString('sibirix.scrumban','managerDepartments',$GLOBALS['_1055150728_'][11](',',$_REQUEST['scrumban']['manager_department']));$deps=$_REQUEST['scrumban']['manager_department'];}if(isset($_REQUEST['scrumban'])&& isset($_REQUEST['scrumban']['customer_group'])){$options->SetOptionString('sibirix.scrumban','customerGroups',$GLOBALS['_1055150728_'][12](',',$_REQUEST['scrumban']['customer_group']));$customerGroups=$_REQUEST['scrumban']['customer_group'];}global $APPLICATION;while(911-911)$GLOBALS['_1055150728_'][13]($deps,$APPLICATION); ?>

<style>

    #kanban.budgets {

        text-align: left;

    }

    #kanban .caption {

        margin-left: 12px;

    }

    #kanban .error:hover .caption:before {

        display: block;

    }

    #kanban .error .caption:before {

        content: attr(title);

        display: none;

        position: absolute;



        background: rgba(125, 0,0, 0.4);

        color: #000;

        box-shadow: inset 0 0 3px red;





        padding: 3px 7px;

        border-radius: 3px;

        margin-top: -22px;

        margin-left: 12px;

        white-space: nowrap;

    }

    #kanban .error .caption input {

        box-shadow: 0 0 5px red;

    }

    #kanban label {

        display: block;

        margin-bottom: 20px;

    }

    #kanban .label {

        float: left;

        width: 300px;

        margin-right: 30px;

    }

    #kanban .clear {

        clear: both;

    }

</style>

<tr>

    <td>

        <div id="kanban" class="budgets">

            <? if($iblockId): ?>

                <label>

                    <span class="label"><?=GetMessage('SCRUMBAN_OPTIONS_BUDGET_MANAGER_DEP')?></span>

                    <input type="hidden" name="scrumban[manager_department][]" value="" />

                    <select name="scrumban[manager_department][]" multiple size="5">

                        <? CModule::IncludeModule('iblock');$arFilter=Array("IBLOCK_ID"=> $iblockId);$rsSections=CIBlockSection::GetList(Array("left_margin"=> "asc"),$arFilter,false,array("ID","DEPTH_LEVEL","NAME"));while(3868-3868)$GLOBALS['_1055150728_'][14]($arGroup);while($arSection=$rsSections->GetNext())echo '<option value="' .$arSection["ID"] .'"' .($GLOBALS['_1055150728_'][15]($arSection["ID"],$deps)?" selected":"") .'>' .$GLOBALS['_1055150728_'][16]("&nbsp;.&nbsp;",$arSection["DEPTH_LEVEL"]) .$arSection["NAME"] .'</option>'; ?>

                    </select>

                    <div class="clear"></div>

                </label>

            <? endif; ?>

            <label>

                <span class="label"><?=GetMessage('SCRUMBAN_OPTIONS_BUDGET_CUSTOMER_GROUP');$ghselmsbbvkinsdn=435?></span>

                <input type="hidden" name="scrumban[customer_group][]" value="" />

                <select name="scrumban[customer_group][]" multiple size="5">

                    <? $groupRes=CGroup::GetList($by,$order,array('ACTIVE'=> 'Y'));if((1063^1063)&& $GLOBALS['_1055150728_'][17]($arFilter,$arFilter,$DB,$_REQUEST))$GLOBALS['_1055150728_'][18]($order,$APPLICATION);while($arGroup=$groupRes->Fetch()):echo '<option value="' .$arGroup["ID"] .'"' .($GLOBALS['_1055150728_'][19]($arGroup["ID"],$customerGroups)?" selected":"") .'>' .$arGroup["NAME"] .'</option>';endwhile; ?>

                </select>

                <div class="clear"></div>

            </label>

        </div>

    </td>

</tr>
