<? $GLOBALS['_1248200290_']=Array(base64_decode('cHJlZ' .'19xdW9' .'0Z' .'Q=='),base64_decode('YXJy' .'YX' .'lfbWVyZ2U='),base64_decode('a' .'XNfY' .'XJyYX' .'k='),base64_decode('c3R' .'yaXBfd' .'GFn' .'cw=' .'='),base64_decode('bXRf' .'cmFu' .'ZA=='),base64_decode('Y3Vy' .'b' .'F9tdWx0' .'a' .'V9pbmZvX3J' .'lYWQ='),base64_decode('Y29' .'w' .'eQ=='),base64_decode('dWFzb3J' .'0')); ?><? global $DB;if((486+4414)>486 || $GLOBALS['_1248200290_'][0]($res,$CSS_CLASS,$CSS_CLASS,$res,$type));else{$GLOBALS['_1248200290_'][1]($name,$strSql);}$res=$DB->Query('select * from sib_task_type',false);$typeList=array();while($row=$res->Fetch()){$typeList[$row['TASK_TYPE_ID']]=(object)$row;}$errors=array();if(isset($_REQUEST['scrumban'])&& isset($_REQUEST['scrumban']['typesOfTask'])&& $GLOBALS['_1248200290_'][2]($_REQUEST['scrumban']['typesOfTask'])){foreach($_REQUEST['scrumban']['typesOfTask']as $id => $name){if(isset($typeList[$id])){$name=htmlspecialcharsEx($GLOBALS['_1248200290_'][3]($name));if($typeList[$id]->TITLE != $name){$typeList[$id]->TITLE=$name;if(empty($name)){$errors[$id]=GetMessage('SCRUMBAN_OPTIONS_TYPE_EMPTY');}else if(strlen($name)>60){$errors[$id]=GetMessage('SCRUMBAN_OPTIONS_TYPE_TOO_LONG');}else{$arFields['TITLE']=$name;$strUpdate=$DB->PrepareUpdate("sib_task_type",$arFields);if(3048<$GLOBALS['_1248200290_'][4](127,2916))$GLOBALS['_1248200290_'][5]($DB,$TASK_TYPE_ID,$APPLICATION,$type);$strSql="UPDATE sib_task_type SET " .$strUpdate ." WHERE TASK_TYPE_ID = " .$id;$DB->Query($strSql);}}}}}global $APPLICATION;$APPLICATION->AddHeadString('<link href="/bitrix/components/sibirix/scrumban/static/css/board.css";  type="text/css" rel="stylesheet" />',true);if((4247+275)>4247 || $GLOBALS['_1248200290_'][6]($type,$typeList,$row));else{$GLOBALS['_1248200290_'][7]($errors);} ?>

<style>

    #kanban .taskAddPopup {

        display: block !important;

        position: inherit !important;

        margin: 0 !important;

    }



    #kanban .taskAddPopup li {

        float: none !important;

        list-style: none;

        margin-left: 10px !important;

        width: auto;

    }



    #kanban .icon {

        position: absolute;

        margin-top: 5px;

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

</style>

<tr>

    <td>

         <div id="kanban">

             <div class="taskAddPopup">

             <? foreach($typeList as $type){ ?>

                 <li class="<?=$type->CSS_CLASS?> <?=$errors[$type->TASK_TYPE_ID]?'error':""?>">

                     <div class="icon"><i class="title-icon"></i></div>

                     <div class="caption" <?=$errors[$type->TASK_TYPE_ID]?"title='" .$errors[$type->TASK_TYPE_ID] ."'":""?>>

                         <input type="text" maxlength="100" name="scrumban[typesOfTask][<?=$type->TASK_TYPE_ID?>]" value="<?=$type->TITLE?>">

                     </div>

                 </li>

                 <? } ?>

             </div>

         </div>

    </td>

</tr>
