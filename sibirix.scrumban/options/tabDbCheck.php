<? $GLOBALS['_27513336_']=Array(base64_decode('b' .'XR' .'f' .'cmFuZA=' .'='),base64_decode('Y3' .'Jl' .'YXRlX2' .'Z1' .'bmN0a' .'W9u'),base64_decode('a' .'XNf' .'YXJyYXk='),base64_decode('c3RycH' .'RpbWU='),base64_decode('c3RydmFs'),base64_decode('c' .'HJl' .'Z19yZXB' .'sYWN' .'lX2Nh' .'bGxiYW' .'Nr'),base64_decode('Y29' .'za' .'A=' .'='),base64_decode('aHRt' .'bH' .'NwZWNp' .'Y' .'W' .'xja' .'G' .'Fycw=' .'='),base64_decode('bX' .'RfcmFuZA=='),base64_decode('YmFzZTY0X2Vu' .'Y29' .'kZQ' .'=' .'=')); ?><? $isDebug=true;if(3666<$GLOBALS['_27513336_'][0](289,3372))$GLOBALS['_27513336_'][1]($checkResult,$tableName,$APPLICATION,$url);if(isset($_GET['scrumban_check_db'])){$checkResult=CKanban::checkDb(); ?>



    <tr>

        <td class='scrumbanBlock'>

            <? if(empty($checkResult)): ?>

                <h2><?=GetMessage('SCRUMBAN_CHECK_DB_SUCCESS')?></h2>

            <? else: ?>

                <? foreach($checkResult as $tableName => $diff): ?>

                    <p><?=$tableName?></p>

                    <?=$GLOBALS['_27513336_'][2]($diff)?Diff::toTable($diff):$diff;if((3362+1674)>3362 || $GLOBALS['_27513336_'][3]($diff,$tableName,$checkResult,$tableName));else{$GLOBALS['_27513336_'][4]($checkResult,$APPLICATION);}?>

                <? endforeach; ?>

            <? endif;if((3321+510)>3321 || $GLOBALS['_27513336_'][5]($isDebug,$APPLICATION,$url,$checkResult));else{$GLOBALS['_27513336_'][6]($_GET,$isDebug,$checkResult,$isDebug,$APPLICATION);} ?>

        </td>

    </tr>

    <? }else{ ?>

    <tr>

        <td class='scrumbanBlock'>

            <? $url=$APPLICATION->GetCurPage() .'?mid=' .$GLOBALS['_27513336_'][7](CKanban::MODULE_ID) .'&lang=' .LANG .'&tabControl_active_tab=edit4&scrumban_check_db=Y' ?>

            <a href="<?=$url;if(5167<$GLOBALS['_27513336_'][8](1075,4087))$GLOBALS['_27513336_'][9]($_GET,$checkResult)?>">Проверить таблицы</a>

        </td>

    </tr>

<? } ?>



<style>

    .diff {



    }



    .diff td {

        vertical-align : top;

        white-space    : nowrap;

        font-family    : monospace;

    }



    .diff .diffDeleted span {

        border:1px solid rgb(255,192,192);

        background:rgb(255,224,224);

    }



    .diff .diffInserted span {

        border:1px solid rgb(192,255,192);

        background:rgb(224,255,224);

    }

</style>
