<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/tools/file_dialog/file_dialog.php");

$filemanPerms = $GLOBALS["APPLICATION"]->GetGroupRight("fileman");
if ($filemanPerms > "D"):

/**********************************************************************************/
$selfPath = str_replace("\\", "/", __FILE__);
$uofRootPath = substr($selfPath, 0, strlen($selfPath) - strlen("/head.php"));
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
<script type="text/javascript">
function bfsChangeView(val)
{
	top.bfsChangeView(val);
}

function bfsSetPath(path)
{
	top.bfsChangePath(path, "frmHead");
}

function bfsShowPath(path)
{
	document.frmHead.address.value = path;
}

function bfsChangeSite(site, bNoEvent)
{
	if(!document.frmHead.siteSelection)
		return;
	for (var i = 0; i < document.frmHead.siteSelection.options.length; i++)
	{
		if (document.frmHead.siteSelection.options[i].value == site)
		{
			document.frmHead.siteSelection.selectedIndex = i;
			break;
		}
	}

	if (!bNoEvent)
		top.bfsChangeSite(site, "frmHead");
}

function bfsDual()
{
}
</script>
</head>
<body class="bfsbody">

<table width="100%" border="0" cellpadding="1" cellspacing="1">
<form name="frmHead" action="head.php" method="post" onsubmit="return false" style="display:inline; margin: 0;">
<?
$site = $_GET["site"];
$newSite = CSite::GetDefSite($site);
if ($site != $newSite)
{
	$site = $newSite;
	$siteQuote = str_replace("'", "\\'", $site);
	?>
	<script language="JavaScript">
		top.bfsChangeSite('<?= $siteQuote ?>', 'frmHead');
	</script>
	<?
}

$bDistinctDocRoots = CSite::IsDistinctDocRoots();
if ($bDistinctDocRoots)
{
	?>
	<tr>
		<td width="150" align="right"><font class="bfstext"><?= GetMessage("MAIN_BFSD_SITE") ?>:</font></td>
		<td align="left">
			<select id="siteSelection" name="siteSelection" onchange="bfsChangeSite(this.options[this.selectedIndex].value)" class="bfsselect">
				<?
				$dbSites = CSite::GetList($b="NAME", $o="asc");
				while ($arSites = $dbSites->Fetch())
				{
					?><option value="<?= htmlspecialchars($arSites["ID"]) ?>"<?= ($site == $arSites["ID"] ? ' selected' : '') ?>>(<?= htmlspecialchars($arSites["ID"]) ?>) <?= htmlspecialchars($arSites["NAME"]) ?></option><?
				}
				?>
			</select>
			<a href="javascript:bfsDual()" onclick="bfsChangeSite(document.frmHead.siteSelection.options[document.frmHead.siteSelection.selectedIndex].value)"><img src="icons/redirl.gif" title="<?= GetMessage("MAIN_BFSD_APPLY") ?>" style="cursor:pointer" border="0" hspace="4"/></a>
		</td>
		<td align="right">&nbsp;</td>
		<td align="left">&nbsp;</td>
	</tr>
	<?
}

$path = $_GET["path"];
$path = Rel2Abs("/", $path);
?>
<tr>
	<td width="150" align="right" valign="middle"><font class="bfstext"><?= GetMessage("MAIN_BFSD_URL") ?>:</font></td>
	<td align="left" valign="middle"><font class="bfstext">
		<input type="text" onkeyup="if (event.keyCode==13) bfsSetPath(document.frmHead.address.value)" id="adr" name="address" style="width:300px;" value="<?= htmlspecialchars($path) ?>" class="bfsinput"/>
		<a href="javascript:bfsDual()" onclick="bfsSetPath(document.frmHead.address.value)"><img src="icons/folder.gif" alt="" title="<?= GetMessage("MAIN_BFSD_PRT_OPEN") ?>" style="cursor:pointer" border="0" hspace="4"/></a>
	</font></td>
	<td align="right" valign="middle"><font class="bfstext"><?= GetMessage("MAIN_BFSD_VIEW") ?>:</font></td>
	<td align="left" valign="middle"><font class="bfstext">
		<select name="actionSelection" onchange="bfsChangeView(this.options[this.selectedIndex].value)" class="bfsselect">
			<option value="list" <?= ($sAction == "list" ? ' selected' : '') ?>><?= GetMessage("MAIN_BFSD_VIEW_LIST") ?></option>
			<option value="detail" <?= ($sAction == "detail" ? ' selected' : '') ?>><?= GetMessage("MAIN_BFSD_VIEW_DET") ?></option>
			<option value="preview" <?= ($sAction == "preview" ? ' selected' : '') ?>><?= GetMessage("MAIN_BFSD_VIEW_PREW") ?></option>
		</select>
		<a href="javascript:bfsDual()" onclick="bfsChangeView(document.frmHead.actionSelection.options[document.frmHead.actionSelection.selectedIndex].value)"><img src="icons/instable.gif" title="<?= GetMessage("MAIN_BFSD_APPLY") ?>" style="cursor:pointer" border="0" hspace="4"/></a>
	</font></td>
</tr>
</form>
</table>

<script language="JavaScript">
<!--
top.__frmHeadLoaded = true;
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
