<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/tools/file_dialog/file_dialog.php");

$filemanPerms = $GLOBALS["APPLICATION"]->GetGroupRight("fileman");
if ($filemanPerms > "D"):

/**********************************************************************************/
$selfPath = str_replace("\\", "/", __FILE__);
$uofRootPath = substr($selfPath, 0, strlen($selfPath) - strlen("/buttons.php"));
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
$folder_select = (($_GET["folder_select"] == "Y") ? "Y" : "N");
$bAllowFolderSelect = (($folder_select == "Y") ? True : False);

$path = $_GET["path"];
$path = Rel2Abs("/", $path);

$filename = $_GET["filename"];
if ($bAllowFolderSelect)
	$filename = $path.((strlen($filename) > 0) ? "/".$filename : "");

$site = $_GET["site"];
$file_filter = strtolower($_GET["file_filter"]);
?>
<script type="text/javascript">
function bfsSetFilePath(path)
{
	document.frmButtons.filename.value = <?= ($bAllowFolderSelect ? "path" : "''") ?>;
	document.frmButtons.path.value = path;
}

function bfsChangeSite(site)
{
	document.frmButtons.filename.value = "";
	document.frmButtons.path.value = "";
	document.frmButtons.site.value = site;
}

function bfsSelectFile(fileName, path, site)
{
	document.frmButtons.path.value = path;
	document.frmButtons.site.value = site;
	bfsSetFilename(fileName);
}

function bfsSetFilename(fileName)
{
	var path = document.frmButtons.path.value;
	document.frmButtons.filename.value = <?= ($bAllowFolderSelect ? "path + '/' + " : "") ?>fileName;
}

function bfsGetFilename()
{
	return document.frmButtons.filename.value;
}

function bfsUnSelectFile()
{
	document.frmButtons.path.value = "";
	document.frmButtons.site.value = "";
	document.frmButtons.filename.value = "";
}

function bfsCloseDialog()
{
	top.bfsCloseDialog();
}

function bfsSubmitDialog()
{
	var filename = document.frmButtons.filename.value;
	var path = document.frmButtons.path.value;
	var site = document.frmButtons.site.value;
	if (filename.length > 0 && site.length > 0)<?/*= ($bAllowFolderSelect ? "" : " && path.length > 0") */?>
		top.bfsSubmitDialog(filename, <?= ($bAllowFolderSelect ? "''" : "path") ?>, site);
}

function bfsChangeFilter(val)
{
	top.bfsChangeFileFilter(val);
}
</script>
</head>
<body class="bfsbody">

<form name="frmButtons" action="buttons.php" method="get" onsubmit="return false" style="display:inline; margin: 0;">

	<table width="100%" border="0" cellpadding="1" cellspacing="1">
		<tr>
			<td width="90%" valign="top">
				<table width="100%" border="0" cellpadding="1" cellspacing="1">
					<tr>
						<td align="left" width="20%"><font class="bfstext"><?= GetMessage("MAIN_BFSD_FILENAME") ?>:</font></td>
						<td align="left" width="80%"><font class="bfstext">
							<input type="text" name="filename" style="width:300px;" class="bfsinput" value="<?= htmlspecialchars($filename) ?>" size="40">
						</font></td>
					</tr>
					<tr>
						<td align="left" width="20%"><font class="bfstext"><?= GetMessage("MAIN_BFSD_FILETYPE") ?>:</font></td>
						<td align="left" width="80%"><font class="bfstext">
							<?
							list($userFilterKey, $userFilterValue) = uofPrepareExtFilter($file_filter);
							?>
							<select name="file_filter" onchange="bfsChangeFilter(this.options[this.selectedIndex].value)" class="bfsselect">
								<?
								if (strlen($userFilterKey) > 0)
								{
									?><option selected value="<?= htmlspecialchars($userFilterKey) ?>"><?= htmlspecialchars($userFilterValue) ?></option><?
								}
								?>
								<option value=""><?= GetMessage("MAIN_BFSD_ALL_FILES") ?> (*.*)</option>
							</select>
						</font></td>
					</tr>
				</table>
			</td>
			<td width="10%" valign="top">
				<table width="100%" border="0" cellpadding="1" cellspacing="1">
					<tr>
						<td align="right">
							<input type="button" OnClick="bfsSubmitDialog()" name="open_file" value="<?= GetMessage("MAIN_BFSD_OPEN") ?>" style="width:100px" class="bfsbutton">
						</td>
					</tr>
					<tr>
						<td align="right">
							<input type="button" OnClick="bfsCloseDialog()" name="cancel_file" value="<?= GetMessage("MAIN_BFSD_CLOSE") ?>" style="width:100px" class="bfsbutton">
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<input type="hidden" name="lang" value="<?= LANG ?>">
	<input type="hidden" name="site" value="<?= htmlspecialchars($site) ?>">
	<input type="hidden" name="path" value="<?= htmlspecialchars($path) ?>">
</form>

<script language="JavaScript">
<!--
top.__frmButtonsLoaded = true;
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
