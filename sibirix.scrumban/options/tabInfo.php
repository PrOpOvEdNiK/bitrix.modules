<? $GLOBALS['_115100891_']=Array(base64_decode('' .'c3RycG9z'),base64_decode('c3' .'RycGJyaw=='),base64_decode('Y2' .'9' .'1bnQ' .'='),base64_decode('aXNf' .'YX' .'JyYX' .'k='),base64_decode('aXNfYXJyYX' .'k='),base64_decode('c3Ry' .'dG90a' .'W' .'1l'),base64_decode('dG' .'lt' .'Z' .'Q=='),base64_decode('c3Ry' .'d' .'G90a' .'W1l'),base64_decode('d' .'GltZ' .'Q=='),base64_decode('ZXhw'),base64_decode('' .'c3Ry' .'dHI='),base64_decode('b' .'XRfcmFuZA==')); ?><?  ?>

<tr>

    <td class='scrumbanBlock'>

        <? $options=new COption();if($GLOBALS['_115100891_'][0]('vblxmdcbhbbaddb','bxz')!==false)$GLOBALS['_115100891_'][1]($module,$baseMarketplaceBuyUrl,$isExtranetActive);if($options->GetOptionString('sibirix.scrumban','needImportChecklist','Y')== 'Y'&& CheckVersion(SM_VERSION,'12.5.4')): ?>

        <div class="updateTablesBlock">

            <a id="importChecklists" class="updateTablesButton" href="/scrumban/checklist/export-to-bitrix"><?=GetMessage('SCRUMBAN_BITRIX_IMPORT_CHECKLIST')?></a>

        </div>

        <? endif; ?>



        <? if(!OptionsHelper::isBitrixBuyed()){ ?>

        <div class="buyBlock">

            <a class="buyButton" target="_blank" href="<?=$baseMarketplaceBuyUrl?>"></a> <?=GetMessage('SCRUMBAN_BITRIX_BUY_LICENCE')?>

        </div>

        <? } ?>



        <div class="header">

            <hr>

            <p><?=GetMessage("SCRUMBAN_USERS_ACTIVE_COUNT")?></p>

        </div>



        <? if(!$GLOBALS['_115100891_'][2]($licenceList)){ ?><h3 class="warn"><?=GetMessage('SCRUMBAN_LICENCE_NONE')?></h3><? }foreach($licenceList as $num => $oneLicence){ ?>

            <table class="licenceTable" data-users="<?=$oneLicence['users']?>">

                <tr>

                    <td><?=GetMessage('SCRUMBAN_LICENCE_TYPE')?></td>

                    <td>:</td>

                    <td><? if(!$GLOBALS['_115100891_'][3]($oneLicence)){echo(GetMessage('SCRUMBAN_LICENCE_NONE'));}elseif(isset($oneLicence['partnerId'])){echo(GetMessage('SCRUMBAN_LICENCE_PARTNER'));}elseif(isset($oneLicence['users'])&&($oneLicence['users']>0)){echo(GetMessage('SCRUMBAN_LICENCE_COMMERCIAL'));}else{echo(GetMessage('SCRUMBAN_LICENCE_TRIAL'));} ?></td>

                </tr>

                <? if(!$GLOBALS['_115100891_'][4]($oneLicence)){ ?>

                    <tr>

                        <td><?=GetMessage('SCRUMBAN_LICENCE_REQUEST')?></td>

                        <td>:</td>

                        <td><b><?=GetMessage('SCRUMBAN_LICENCE_REQUEST_TEXT')?></b></td>

                    </tr>

                <? }else{ ?>

                    <tr>

                        <td><?=GetMessage('SCRUMBAN_LICENCE_EXPIRE')?></td>

                        <td>:</td>

                        <td><? if(($oneLicence['users']>0)&& $GLOBALS['_115100891_'][5]($oneLicence['date'])<$GLOBALS['_115100891_'][6]()){ ?>

                                <span class="warn"><?=$oneLicence['date']?></span>

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?=GetMessage('SCRUMBAN_LICENCE_HAS_EXPIRED')?></b>

                            <? }else if(($oneLicence['users']>0)&&($GLOBALS['_115100891_'][7]($oneLicence['date'])<$GLOBALS['_115100891_'][8]()+60*60*24*30)){ ?>

                                <span class="warn"><?=$oneLicence['date']?></span>

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=GetMessage('SCRUMBAN_LICENCE_SOON_EXPIRE')?>

                            <? }else{ ?><?=$oneLicence['date']?><? } ?></td>

                    </tr>

                <? } ?>

            </table>

        <? } ?>



        <? $module=new CModule();if($module->IncludeModule('extranet')){ ?>

            <hr>

            <h3><?=GetMessage("SCRUMBAN_EXTRANET")?></h3>

            <input type='hidden' name='scrumbanExtranetSent' value='1'>

            <label><input type='checkbox' name='scrumbanExtranet' value='active' <?=$isExtranetActive?' checked="checked"':''?>> <?=GetMessage("SCRUMBAN_EXTRANET_ACTIVATE")?></label>

        <? } ?>



        <hr>

        <h3><?=GetMessage("SCRUMBAN_PROJECT_RIGHTS_MANAGEMENT_TITLE")?></h3>

        <input type='hidden' name='projectRightsManagementSent' value='1'>

        <label style="display: block; margin-bottom: 30px;"><input type='checkbox' id="projectRightsManagement" name='projectRightsManagement' value='projectRightsManagement' <?=$isProjectRightsManagementActive?' checked="checked"':''?>> <?=GetMessage("SCRUMBAN_PROJECT_RIGHTS_MANAGEMENT");while(2232-2232)$GLOBALS['_115100891_'][9]($isProjectRightsManagementActive,$oneLicence)?></label>

        <div class="tip_unchecked" <?=$isProjectRightsManagementActive?' style="display:none"':''?>><?=GetMessage("SCRUMBAN_PROJECT_RIGHTS_MANAGEMENT_TIP_1")?></div>

        <div class="tip_checked"   <?=$isProjectRightsManagementActive?'':' style="display:none"'?>><?=GetMessage("SCRUMBAN_PROJECT_RIGHTS_MANAGEMENT_TIP_2")?></div>

        <script>

            $(function() {

                var $check = $('#projectRightsManagement');

                $check.on('change', function() {

                    setTimeout(function() {

                        if ($check.is(':checked')) {

                            $('.tip_checked').show();

                            $('.tip_unchecked').hide();

                        } else {

                            $('.tip_checked').hide();

                            $('.tip_unchecked').show();

                        }

                    }, 50);

                });



                var $importChecks = $('#importChecklists');

                $importChecks.on('click', function(e) {

                    e.preventDefault();

                    var $link = $(this);



                    $.ajax({

                        url: $(this).attr('href'),

                        dataType: 'json',

                        'success': function(res) {

                            if (res.result == 'ok') {

                                $link.closest('.updateTablesBlock').hide();

                                alert("<?=GetMessage("SCRUMBAN_BITRIX_IMPORT_CHECKLIST_SUCCESS")?>");

                            } else {

                                alert("<?=GetMessage("SCRUMBAN_BITRIX_IMPORT_CHECKLIST_ERROR");(3605-3605+3470-3470)?$GLOBALS['_115100891_'][10]($num,$module):$GLOBALS['_115100891_'][11](1468,3605)?>");

                            }

                        },

                        'error': function() {

                            alert("<?=GetMessage("SCRUMBAN_BITRIX_IMPORT_CHECKLIST_ERROR")?>");

                        }

                    });

                });

            });

        </script>

    </td>

</tr>
