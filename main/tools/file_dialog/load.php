<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/tools/file_dialog/file_dialog.php");

$filemanPerms = $GLOBALS["APPLICATION"]->GetGroupRight("fileman");
if ($filemanPerms > "D"):

/**********************************************************************************/
$selfPath = str_replace("\\", "/", __FILE__);
$uofRootPath = substr($selfPath, 0, strlen($selfPath) - strlen("/load.php"));
require_once($uofRootPath."/options.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?= GetMessage("MAIN_BFSD_TITLE") ?></title>
<script language="JavaScript">
<!--
if (self.parent.frames.length == 0)
{
	self.parent.location = "fd.php";
}
//-->
</script>
<style>
<?bfsPrintStyles();?>
</style>
<?
$site = $_REQUEST["site"];
$newSite = CSite::GetDefSite($site);
if ($site != $newSite)
{
	$site = $newSite;
	$siteQuote = str_replace("'", "\\'", $site);
	?>
	<script language="JavaScript">
		top.bfsChangeSite('<?= $siteQuote ?>', 'frmPanel');
	</script>
	<?
}

$path = $_REQUEST["path"];
$path = Rel2Abs("/", $path);

$documentRoot = CSite::GetSiteDocRoot($site);
$absPath = $documentRoot.$path;

$bDisabled = False;
if (($fileAccess = $APPLICATION->GetFileAccessPermission(array($site, $path))) <= "U")
	$bDisabled = True;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if (isset($_FILES["load_file"])
		&& isset($_FILES["load_file"]["tmp_name"])
		&& strlen($_FILES["load_file"]["tmp_name"]) > 0
		&& strlen($_FILES["load_file"]["name"]) > 0)
	{
		if(is_uploaded_file($_FILES["load_file"]["tmp_name"]))
		{
			if(strlen($filename)>0)
				$pathto = Rel2Abs($path, $filename);
			else
				$pathto = Rel2Abs($path, $_FILES["load_file"]["name"]);

			$fn = basename($pathto);
			if($APPLICATION->GetFileAccessPermission(array($site, $pathto)) > "R"
				&& ($USER->IsAdmin() || (!in_array(uofGetFileExtension($fn), GetScriptFileExt()) && substr($fn, 0, 1) != "."))
			)
			{
				if(!file_exists($documentRoot.$pathto) || $_REQUEST["rewrite"] == "Y")
				{
				//************************** Quota **************************//
					$bQuota = true;
					if(COption::GetOptionInt("main", "disk_space") > 0)
					{
						$bQuota = false;
						$quota = new CDiskQuota();
						if ($quota->checkDiskQuota(array("FILE_SIZE"=>filesize($_FILES["load_file"]["tmp_name"]))))
							$bQuota = true;
					}
				//************************** Quota **************************//
					if ($bQuota)
					{
						copy($_FILES["load_file"]["tmp_name"], $documentRoot.$pathto);
						@chmod($documentRoot.$pathto, BX_FILE_PERMISSIONS);
					//************************** Quota **************************//
						if(COption::GetOptionInt("main", "disk_space") > 0)
						{
							CDiskQuota::updateDiskQuota("file", filesize($documentRoot.$pathto), "copy");
						}
					//************************** Quota **************************//
						?>
						<script type="text/javascript">
						//top.bfsReload();
						top.bfsSubmitDialog('<?=basename($pathto)?>', '<?=$path?>', '<?=$site?>');
						</script>
						<?
					}
					else 
					{
						?><script>alert('<?=$quota->LAST_ERROR?>');</script><?
					}
				}
				else
				{
					?>
					<script type="text/javascript">
					alert('<?=GetMessage("MAIN_BFSD_LOAD_EXIST_ALERT")?>');
					</script>
					<?
				}
			}
			else
			{
				?>
				<script type="text/javascript">
				alert('<?=GetMessage("MAIN_BFSD_LOAD_DENY_ALERT")?>');
				</script>
				<?
			}
		}
	}
}
?>
<script type="text/javascript">
function bfsSetFilePath(path)
{
	document.frmLoad.path.value = path;
	document.frmLoad.submit();
}

function bfsChangeSite(site)
{
	document.frmLoad.site.value = site;
	document.frmLoad.submit();
}

function bfsFileFieldChange()
{
	var str_file = document.frmLoad.load_file.value;
	str_file = str_file.replace(/\\/g, '/');
	var filename = str_file.substr(str_file.lastIndexOf("/")+1);
	top.bfsSetFilename(filename);
}

function bfsSubmitFile()
{
	document.frmLoad.filename.value = top.bfsGetFilename();
	if(document.frmLoad.filename.value=='')
	{
		alert('<?= GetMessage("MAIN_BFSD_LOAD_ENTERNAME_ALERT") ?>');
		return false;
	}

	if(document.getElementById("id_rewrite").checked)
		return true;

	var arAllFilenames = top.bfsGetPanelFiles();
	for(var i=0; i<arAllFilenames.length; i++)
	{
		if(arAllFilenames[i] == document.frmLoad.filename.value)
		{
			alert('<?= GetMessage("MAIN_BFSD_LOAD_EXIST_ALERT") ?>');
			return false;
		}
	}

	return true;
}
</script>
</head>
<body class="bfsbody">

<form name="frmLoad" action="load.php" onsubmit="return bfsSubmitFile()" method="post" style="display:inline; margin: 0;" enctype="multipart/form-data">

	<table width="100%" border="0" cellpadding="1" cellspacing="1">
		<tr>
			<td width="150">
			</td>
			<td>

				<table width="100%" border="0" cellpadding="1" cellspacing="1">
					<tr>
						<td width="90%" valign="top">
							<table width="100%" border="0" cellpadding="1" cellspacing="1">
								<tr>
									<td align="left" width="20%"><font class="bfstext"><?= GetMessage("MAIN_BFSD_LOAD_FILE") ?>:</font></td>
									<td align="left" width="50%"><font class="bfstext">
										<input type="file" onchange="bfsFileFieldChange()" name="load_file" size="20"<?if ($bDisabled) echo " disabled";?> class="bfsinput">
									</font></td>
									<td align="left" width="30%"><font class="bfstext">
										<input type="checkbox" name="rewrite" id="id_rewrite" value="Y"<?if ($_REQUEST["rewrite"] == "Y") echo " checked";?><?if ($bDisabled) echo " disabled";?>>
										<label for="id_rewrite"><?= GetMessage("MAIN_BFSD_REWRITE") ?></label>
									</font></td>
								</tr>
							</table>
						</td>
						<td width="10%" valign="top">
							<input type="submit" name="do_load_file"<?if ($bDisabled) echo " disabled";?> value="<?= GetMessage("MAIN_BFSD_DO_LOAD") ?>" style="width:100px" class="bfsbutton">
						</td>
					</tr>
				</table>

			</td>
		</tr>
	</table>

	<input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
	<input type="hidden" name="lang" value="<?= LANG ?>">
	<input type="hidden" name="site" value="<?= htmlspecialchars($site) ?>">
	<input type="hidden" name="path" value="<?= htmlspecialchars($path) ?>">
	<input type="hidden" name="filename" value="">
</form>

<script language="JavaScript">
<!--
top.__frmLoadLoaded = true;
//-->
</script>
</body>
</html>
<?
/**********************************************************************************/

else:

/**********************************************************************************/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?= GetMessage("MAIN_BFSD_TITLE") ?></title>
</head>
<body>
	<?= GetMessage("MAIN_BFSD_NO_PERMS") ?>
</body>
</html>
<?
/**********************************************************************************/

endif;

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin_after.php");
?>
