<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/tools/file_dialog/file_dialog.php");

$filemanPerms = $GLOBALS["APPLICATION"]->GetGroupRight("fileman");
if ($filemanPerms > "D"):

/**********************************************************************************/
$selfPath = str_replace("\\", "/", __FILE__);
$uofRootPath = substr($selfPath, 0, strlen($selfPath) - strlen("/panel.php"));
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
<?bfsPrintStyles(DEFAULT_PREVIEW_SIZE);?>
</style>
<script type="text/javascript">
function init()
{
	var oFrame = parent.frames["frmPanel"];
	document.fAction.frame_width.value =  oFrame ? ((document.all) ? oFrame.document.body.offsetWidth : oFrame.innerWidth) : <?= DEFAULT_FRAME_WIDTH ?>;
}

function bfsChangeView(val)
{
	document.fAction.view_type.value = val;
	top.__frmPanelLoaded = false;
	document.fAction.submit();
}

function bfsChangeFileFilter(val)
{
	document.fAction.file_filter.value = val;
	top.__frmPanelLoaded = false;
	document.fAction.submit();
}

function bfsChangeSite(site, bNoEvent)
{
	document.fAction.site.value = site;

	if (!bNoEvent)
		top.bfsChangeSite(site, "frmPanel");

	top.__frmPanelLoaded = false;
	document.fAction.submit();
}

function bfsSetPath(path, bNoEvent)
{
	document.fAction.path.value = path;

	if (!bNoEvent)
		top.bfsChangePath(path, "frmPanel");

	top.__frmPanelLoaded = false;
	document.fAction.submit();
}

function bfsReload()
{
	top.__frmPanelLoaded = false;
	document.fAction.submit();
}

function OpenFile(fileName)
{
	top.bfsOpenFile(fileName, document.fAction.path.value, document.fAction.site.value);
}

function bfsSubmitDialog(fileName)
{
	top.bfsSubmitDialog(fileName, document.fAction.path.value, document.fAction.site.value);
}
</script>
</head>
<body onload="init()">
<?
$viewType = $_GET["view_type"];
if ($viewType != "preview" && $viewType != "detail")
	$viewType = "list";

$arDirs = array();
$arFiles = array();


$site = $_GET["site"];
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

$path = $_GET["path"];
$path = Rel2Abs("/", $path);
if ($path == "/")
	$path = "";

$documentRoot = CSite::GetSiteDocRoot($site);
$arParsedPath = ParsePath($path);
$abs_path = $documentRoot.$path;

$newPath = bfsCheckFilePath($documentRoot, $path);
if($newPath != $path)
{
	$path = $newPath;
	$pathQuote = str_replace("'", "\\'", $path);
	?>
	<script language="JavaScript">
		top.bfsChangePath('<?= $pathQuote ?>', 'frmPanel');
	</script>
	<?
}

CUserOptions::SetOption("file_dialog", "path", $path);

$arFilter = array("MIN_PERMISSION" => "R");

list($userFilterKey, $userFilterValue) = uofPrepareExtFilter($_GET["file_filter"]);
if (strlen($userFilterKey) > 0)
	$arFilter["EXTENSIONS"] = $userFilterKey;

$arSort = array("NAME"=>"ASC");
$arDirs = array();
$arFiles = array();
GetDirList(array($site, $path), $arDirs, $arFiles, $arFilter, $arSort, "DF");
?>

<form method="get" action="panel.php" name="fAction" onsubmit="return false" style="display:inline; margin: 0;">
	<?
	$arAllFilenames = Array();
	if ($viewType == "preview")
	{
		$optionClosedHTAccess = OPTION_CLOSED_HTACCESS;
		if (bfsCheckClosedHTAccess($path))
			$optionClosedHTAccess = "Y";

		$frameWidth = IntVal($_GET["frame_width"]);
		if ($frameWidth <= 0)
			$frameWidth = DEFAULT_FRAME_WIDTH;

		$previewCols = floor($frameWidth / (DEFAULT_PREVIEW_SIZE + 25));

		$colCounter = 0;

		echo "<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\">";
		if (strlen($path) > 0)
		{
			echo "<tr>";
			echo "<td align=\"center\" style=\"width:".(DEFAULT_PREVIEW_SIZE + 20)."px;height:".(DEFAULT_PREVIEW_SIZE + 25)."px\" title=\"\">";
			echo "<table class=\"bfspreviewcell\"><tr><td align=\"center\" vlign=\"middle\">";
			echo "<a href=\"javascript:bfsSetPath('".str_replace("'", "\\'", $arParsedPath["PREV"])."')\">";
			echo "<img src=\"icons/folder_up_big.gif\" width=\"25\" height=\"25\" border=\"0\" title=\"\">";
			echo "</a>";
			echo "</td></tr></table>";
			echo "<div style=\"width:".(DEFAULT_PREVIEW_SIZE + 5)."px;overflow:hidden;white-space: nowrap;\"><font class=\"bfstext\">";
			echo "<a href=\"javascript:bfsSetPath('".str_replace("'", "\\'", $arParsedPath["PREV"])."')\">";
			echo htmlspecialchars("..");
			echo "</a>";
			echo "</font></div>";
			echo "</td>";

			$colCounter++;
		}

		foreach ($arDirs as $Dir)
		{
			$arAllFilenames[] = $Dir["NAME"];

			if($colCounter == 0)
				echo "<tr>";

			echo "<td align=\"center\" style=\"width:".(DEFAULT_PREVIEW_SIZE + 20)."px;height:".(DEFAULT_PREVIEW_SIZE + 25)."px\" title=\"".htmlspecialchars($Dir["NAME"])."\">";
			echo "<table class=\"bfspreviewcell\"><tr><td align=\"center\" vlign=\"middle\">";
			echo "<a href=\"javascript:bfsSetPath('".str_replace("'", "\\'", $path."/".$Dir["NAME"])."')\">";
			echo "<img src=\"icons/types/folder_big.gif\" width=\"25\" height=\"25\" border=\"0\" title=\"".htmlspecialchars($Dir["NAME"])."\">";
			echo "</a>";
			echo "</td></tr></table>";
			echo "<div style=\"width:".(DEFAULT_PREVIEW_SIZE + 5)."px;overflow:hidden;white-space: nowrap;\"><font class=\"bfstext\">";
			echo "<a href=\"javascript:bfsSetPath('".str_replace("'", "\\'", $path."/".$Dir["NAME"])."')\">";
			echo htmlspecialchars($Dir["NAME"]);
			echo "</font></a>";
			echo "</div>";

			echo "</td>";

			$colCounter++;
			if ($colCounter == $previewCols)
			{
				echo "</tr>";
				$colCounter = 0;
			}
		}

		foreach ($arFiles as $File)
		{
			if ($colCounter == 0)
				echo "<tr>";

			$arAllFilenames[] = $File["NAME"];

			echo "<td align=\"center\" style=\"width:".(DEFAULT_PREVIEW_SIZE + 20)."px;height:".(DEFAULT_PREVIEW_SIZE + 25)."px\" title=\"".htmlspecialchars($File["NAME"])."\">";
			echo "<table class=\"bfspreviewcell\"><tr><td align=\"center\" vlign=\"middle\">";
			echo "<a href=\"javascript:OpenFile('".str_replace("'", "\\'", $File["NAME"])."')\" ondblclick=\"bfsSubmitDialog('".str_replace("'", "\\'", $File["NAME"])."')\">";

			$ext_tmp = uofGetFileExtension($File["NAME"]);

			if (in_array($ext_tmp, $arPossiblePreviewTypes))
				echo "<img src=\"image.php?resize=".DEFAULT_PREVIEW_SIZE."&amp;path=".urlencode($path)."&amp;imgname=".urlencode($File["NAME"]).(($optionClosedHTAccess == "Y") ? "&amp;direct_show=Y" : "")."\" alt=\"\" title=\"".htmlspecialchars($File["NAME"])."\" border=\"0\">";
			else
				echo "<img src=\"icons/types/".uofGetFileType($File["NAME"])."_big.gif\" width=\"25\" height=\"25\" border=\"0\" title=\"".htmlspecialchars($File["NAME"])."\">";

			echo "</a>";
			echo "</td></tr></table>";
			echo "<div style=\"width:".(DEFAULT_PREVIEW_SIZE + 5)."px;overflow:hidden;white-space: nowrap;\"><font class=\"bfstext\">";
			echo "<a href=\"javascript:OpenFile('".str_replace("'", "\\'", $File["NAME"])."')\" ondblclick=\"bfsSubmitDialog('".str_replace("'", "\\'", $File["NAME"])."')\">";
			echo htmlspecialchars($File["NAME"]);
			echo "</font></a>";
			echo "</div>";

			echo "</td>";

			$colCounter++;
			if ($colCounter == $previewCols)
			{
				echo "</tr>";
				$colCounter = 0;
			}
		}

		if ($colCounter != 0)
		{
			for ($i = $colCounter; $i < $previewCols; $i++)
				echo "<td style=\"width:".(DEFAULT_PREVIEW_SIZE + 20)."px;height:".(DEFAULT_PREVIEW_SIZE + 25)."px\">&nbsp;</td>";

			echo "</tr>";
		}
		echo "</table>";

	}
	elseif ($viewType == "detail")
	{
		?>
		<table border="0" width="100%" cellpadding="1" cellspacing="1">
		<tr>
			<td class="bfshead" align="center" width="0"><font class="bfstext">&nbsp;</font></td>
			<td class="bfshead" align="center"><font class="bfstext"><?= GetMessage("MAIN_BFSD_DTIT_NAME") ?></font></td>
			<td class="bfshead" align="center"><font class="bfstext"><?= GetMessage("MAIN_BFSD_DTIT_SIZE") ?></font></td>
			<td class="bfshead" align="center"><font class="bfstext"><?= GetMessage("MAIN_BFSD_DTIT_DATE") ?></font></td>
			<td class="bfshead" align="center"><font class="bfstext"><?= GetMessage("MAIN_BFSD_DTIT_TYPE") ?></font></td>
			<td class="bfshead" align="center"><font class="bfstext"><?= GetMessage("MAIN_BFSD_DTIT_PERM") ?></font></td>
		</tr>
		<?
		if (strlen($path) > 0)
		{
			?>
			<tr>
				<td class="bfsdetailcell" align="center">
					<font class="bfstext"><a href="javascript:bfsSetPath('<?= str_replace("'", "\\'", $arParsedPath["PREV"]) ?>')"><img src="/bitrix/images/fileman/folder_up.gif" width="16" height="16" border="0"></a></font>
				</td>
				<td class="bfsdetailcell" align="left">
					<font class="bfstext"><a href="javascript:bfsSetPath('<?= str_replace("'", "\\'", $arParsedPath["PREV"]) ?>')">..</a></font>
				</td>
				<td class="bfsdetailcell">&nbsp;</td>
				<td class="bfsdetailcell">&nbsp;</td>
				<td class="bfsdetailcell">&nbsp;</td>
				<td class="bfsdetailcell">&nbsp;</td>
			</tr>
			<?
		}

		$i = 0;
		foreach ($arDirs as $Dir)
		{
			$arAllFilenames[] = $Dir["NAME"];
			$i++;
			?>
			<tr valign="top">
				<td class="bfsdetailcell" align="center" width="0"><font class="bfstext">
					<a href="javascript:bfsSetPath('<?= str_replace("'", "\\'", $path."/".$Dir["NAME"]) ?>')"><img src="/bitrix/images/fileman/folder.gif" width="16" height="16" border="0"></a>
				</font></td>
				<td class="bfsdetailcell" align="left"><font class="bfstext">
					<a href="javascript:bfsSetPath('<?= str_replace("'", "\\'", $path."/".$Dir["NAME"]) ?>')"><?= htmlspecialchars($Dir["NAME"]) ?></a>
				</font></td>
				<td class="bfsdetailcell" align="left"><font class="bfstext">&nbsp;</font></td>
				<td class="bfsdetailcell" align="left"><font class="bfstext">
					<?= htmlspecialchars($Dir["DATE"]) ?>
				</font></td>
				<td class="bfsdetailcell" align="left"><font class="bfstext">
					<?= htmlspecialchars(GetMessage("MAIN_BFSD_FTYPE_FOLDER")) ?>
				</font></td>
				<td class="bfsdetailcell" align="left"><font class="bfstext">
					<?= htmlspecialchars($arUOFBitrixPerms[$Dir["PERMISSION"]]) ?>
				</font></td>
			</tr>
			<?
		}

		foreach ($arFiles as $File)
		{
			$arAllFilenames[] = $File["NAME"];
			$i++;
			?>
			<tr valign="top">
				<td class="bfsdetailcell" align="center" width="0"><font class="bfstext">
					<a href="javascript:OpenFile('<?= str_replace("'", "\\'", $File["NAME"]) ?>')" ondblclick="bfsSubmitDialog('<?= str_replace("'", "\\'", $File["NAME"]) ?>')"><img src="icons/types/<?= uofGetFileType($File["NAME"]) ?>.gif" width="16" height="16" border="0"></a>
				</font></td>
				<td class="bfsdetailcell" align="left"><font class="bfstext">
					<a href="javascript:OpenFile('<?= str_replace("'", "\\'", $File["NAME"]) ?>')" ondblclick="bfsSubmitDialog('<?= str_replace("'", "\\'", $File["NAME"]) ?>')"><?= htmlspecialchars($File["NAME"]) ?></a>
				</font></td>
				<td class="bfsdetailcell" align="right"><font class="bfstext">
					<?= htmlspecialchars($File["SIZE"]) ?>
				</font></td>
				<td class="bfsdetailcell" align="left"><font class="bfstext">
					<?= htmlspecialchars($File["DATE"]) ?>
				</font></td>
				<td class="bfsdetailcell" align="left"><font class="bfstext">
					<?= htmlspecialchars($arUOFFileTypes[uofGetFileType($File["NAME"])]["name"]) ?>
				</font></td>
				<td class="bfsdetailcell" align="left"><font class="bfstext">
					<?= htmlspecialchars($arUOFBitrixPerms[$File["PERMISSION"]]) ?>
				</font></td>
			</tr>
			<?
		}
		?>
		</table>
		<?
	}
	else
	{
		$frameWidth = IntVal($_GET["frame_width"]);
		if ($frameWidth <= 0)
			$frameWidth = DEFAULT_FRAME_WIDTH;

		$previewCols = floor($frameWidth / (DEFAULT_LIST_SIZE + 40));

		$colCounter = 0;

		echo "<table border=\"0\" width=\"100%\" cellpadding=\"1\" cellspacing=\"1\">";
		if (strlen($path) > 0)
		{
			echo "<tr>";
			echo "<td align=\"left\" style=\"width:".(DEFAULT_LIST_SIZE + 20)."px;\" title=\"\">";

			echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td>";

			echo "<a href=\"javascript:bfsSetPath('".str_replace("'", "\\'", $arParsedPath["PREV"])."')\">";
			echo "<img src=\"/bitrix/images/fileman/folder_up.gif\" width=\"16\" height=\"16\" border=\"0\" title=\"\">";
			echo "</a>&nbsp;";

			echo "</td><td>";

			echo "<div style=\"width:".DEFAULT_LIST_SIZE."px;overflow:hidden\"><font class=\"bfstext\">";
			echo "<a href=\"javascript:bfsSetPath('".str_replace("'", "\\'", $arParsedPath["PREV"])."')\">";
			echo htmlspecialchars("..");
			echo "</a>";
			echo "</font></div>";

			echo "</td></tr></table>";

			echo "</td>";

			$colCounter++;
		}

		foreach ($arDirs as $Dir)
		{
			$arAllFilenames[] = $Dir["NAME"];

			if ($colCounter == 0)
				echo "<tr>";

			echo "<td align=\"left\" style=\"width:".(DEFAULT_LIST_SIZE + 20)."px;\" title=\"".htmlspecialchars($Dir["NAME"])."\">";

			echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td>";

			echo "<a href=\"javascript:bfsSetPath('".str_replace("'", "\\'", $path."/".$Dir["NAME"])."')\">";
			echo "<img src=\"icons/types/folder.gif\" width=\"16\" height=\"16\" border=\"0\" title=\"".htmlspecialchars($Dir["NAME"])."\">";
			echo "</a>&nbsp;";

			echo "</td><td>";

			echo "<div style=\"width:".DEFAULT_LIST_SIZE."px;overflow:hidden;white-space: nowrap;\"><font class=\"bfstext\">";
			echo "<a href=\"javascript:bfsSetPath('".str_replace("'", "\\'", $path."/".$Dir["NAME"])."')\">";
			echo htmlspecialchars($Dir["NAME"]);
			echo "</a>";
			echo "</font></div>";

			echo "</td></tr></table>";

			echo "</td>";

			$colCounter++;
			if ($colCounter == $previewCols)
			{
				echo "</tr>";
				$colCounter = 0;
			}
		}

		foreach ($arFiles as $File)
		{
			$arAllFilenames[] = $File["NAME"];

			if ($colCounter == 0)
				echo "<tr>";

			echo "<td align=\"left\" style=\"width:".(DEFAULT_LIST_SIZE + 20)."px;\" title=\"".htmlspecialchars($File["NAME"])."\">";

			echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td>";

			echo "<a href=\"javascript:OpenFile('".str_replace("'", "\\'", $File["NAME"])."')\" ondblclick=\"bfsSubmitDialog('".str_replace("'", "\\'", $File["NAME"])."')\">";
			echo "<img src=\"icons/types/".uofGetFileType($File["NAME"]).".gif\" width=\"16\" height=\"16\" border=\"0\">";
			echo "</a>&nbsp;";

			echo "</td><td>";

			echo "<div style=\"width:".DEFAULT_LIST_SIZE."px;overflow-x:hidden;overflow-y:hidden;overflow:hidden;white-space: nowrap;\"><font class=\"bfstext\">";
			echo "<a href=\"javascript:OpenFile('".str_replace("'", "\\'", $File["NAME"])."')\" ondblclick=\"bfsSubmitDialog('".str_replace("'", "\\'", $File["NAME"])."')\">";
			echo htmlspecialchars($File["NAME"]);
			echo "</a>";
			echo "</font></div>";

			echo "</td></tr></table>";

			echo "</td>";

			$colCounter++;
			if ($colCounter == $previewCols)
			{
				echo "</tr>";
				$colCounter = 0;
			}
		}

		if ($colCounter != 0)
		{
			for ($i = $colCounter; $i < $previewCols; $i++)
				echo "<td style=\"width:".(DEFAULT_LIST_SIZE + 20)."px;\">&nbsp;</td>";

			echo "</tr>";
		}

		echo "</table>";
	}
	?>

	<input type="hidden" name="view_type" value="<?= $viewType ?>">
	<input type="hidden" name="file_filter" value="<?= htmlspecialchars($file_filter) ?>">
	<input type="hidden" name="lang" value="<?= LANG ?>">
	<?if($_GET['savepage']=='Y'):?>
	<input type="hidden" name="savepage" value="Y">
	<?endif?>
	<input type="hidden" name="site" value="<?= htmlspecialchars($site) ?>">
	<input type="hidden" name="path" value="<?= htmlspecialchars($path) ?>">
	<input type="hidden" name="frame_width" value="">
</form>
<script>
var arAllFilenames = [<?
for($i=0; $i<count($arAllFilenames); $i++)
{
	if($i>0)echo ", ";
	echo "'".CUtil::JSEscape($arAllFilenames[$i])."'";
}
?>];
</script>
<?
$vJS = '';
if($_GET['savepage']=='Y' && CModule::IncludeModule('fileman')):
	$armt = GetMenuTypes();
	$arMenuItems = Array();
	$arAllItems = Array();
	$strSelected = "";
	
	foreach($armt as $key => $title)
	{
		if($APPLICATION->GetFileAccessPermission(Array($site, $path."/.".$key.".menu.php")) < "W")
			continue;

		$arItems = Array();
		$res = CFileMan::GetMenuArray($abs_path."/.".$key.".menu.php");
		$aMenuLinksTmp = $res["aMenuLinks"];
		if(!is_array($aMenuLinksTmp))
			$aMenuLinksTmp = Array();

		for($j=0; $j<count($aMenuLinksTmp); $j++)
		{
			$aMenuLinksItem = $aMenuLinksTmp[$j];
			$arItems[] = htmlspecialchars($aMenuLinksItem[0]);
		}

		$arMenuItems[] = Array("type"=>$key, "name"=>$title, "items"=>$arItems);
	}

	$vJS = 'var arMenuItems = '.JSVal($arMenuItems).';
	function __MenuLoaded()
	{
		if(top.frames["frmButtons"] && top.frames["frmButtons"].MenuLoaded)
			top.frames["frmButtons"].MenuLoaded(arMenuItems);
		else
			setTimeout(__MenuLoaded, 500);
	}
	__MenuLoaded();
	';
endif;
?>
<script language="JavaScript">
<!--
top.__frmPanelLoaded = true;
<?=$vJS?>
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
