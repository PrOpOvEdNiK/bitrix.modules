<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/tools/file_dialog/file_dialog.php");

$filemanPerms = $GLOBALS["APPLICATION"]->GetGroupRight("fileman");
if ($filemanPerms > "D"):

/**********************************************************************************/
$selfPath = str_replace("\\", "/", __FILE__);
$uofRootPath = substr($selfPath, 0, strlen($selfPath) - strlen("/info.php"));
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
$bCorrectFile = True;

$filename = $_GET["filename"];
if (strlen($filename) <= 0)
	$bCorrectFile = False;

if ($bCorrectFile)
{
	$filename = str_replace("/", "", $filename);
	$filename = str_replace("\\", "", $filename);
	$filename = preg_replace("'[\\\/]+'", "", $filename);

	if (($p = strpos($filename, "\0"))!==false)
		$filename = substr($filename, 0, $p);

	$filename = rtrim($filename, "\0");

	if (strlen($filename) <= 0)
		$bCorrectFile = False;
}

if ($bCorrectFile)
{
	$filename_tmp = preg_replace("/[^a-zA-Z0-1_]+/i", "", $filename);
	if (strlen($filename_tmp) <= 0)
		$bCorrectFile = False;
}

if ($bCorrectFile)
{
	$path = $_GET["path"];
	$path = Rel2Abs("/", $path);

	$site = $_GET["site"];
	$site = CSite::GetDefSite($site);

	$documentRoot = CSite::GetSiteDocRoot($site);
	$absPath = $documentRoot.$path;

	$absFilePath = $absPath."/".$filename;

	if (!file_exists($absFilePath) || !is_file($absFilePath))
		$bCorrectFile = False;
}

if ($bCorrectFile)
{
	$fileAccessPerms = $APPLICATION->GetFileAccessPermission(array($site, $path."/".$filename));
	if ($fileAccessPerms < "R")
		$bCorrectFile = False;
}

if ($bCorrectFile)
{
	$frameWidth = IntVal($_GET["frame_width"]);
	$frameHeight = IntVal($_GET["frame_height"]);

	if ($frameWidth <= 0)
		$frameWidth = DEFAULT_INFO_FRAME_WIDTH;
	if ($frameHeight <= 0)
		$frameHeight = DEFAULT_INFO_FRAME_HEIGHT;
}
?>
<script type="text/javascript">
function init()
{
	var oFrame = parent.frames["frmInfo"];
	document.frmInfo.frame_width.value =  oFrame ? ((document.all) ? oFrame.document.body.offsetWidth : oFrame.innerWidth) : <?= DEFAULT_INFO_FRAME_WIDTH ?>;
	document.frmInfo.frame_height.value =  oFrame ? ((document.all) ? oFrame.document.body.offsetHeight : oFrame.innerHeight) : <?= DEFAULT_INFO_FRAME_HEIGHT ?>;
}

function bfsOpenFile(fileName, path, site)
{
	document.frmInfo.path.value = path;
	document.frmInfo.site.value = site;
	document.frmInfo.filename.value = fileName;
	top.__frmInfoLoaded = false;
	document.frmInfo.submit();
}

function bfsCloseFile()
{
	document.frmInfo.path.value = "";
	document.frmInfo.site.value = "";
	document.frmInfo.filename.value = "";
	top.__frmInfoLoaded = false;
	document.frmInfo.submit();
}
</script>
</head>
<body onload="init()" class="bfsbody">

<form name="frmInfo" action="info.php" method="get" onsubmit="return false" style="display:inline; margin: 0;">

	<table width="100%" border="0" cellpadding="1" cellspacing="1">
		<tr>
			<td align="center">
				<?
				if ($bCorrectFile)
				{
					$ext_tmp = uofGetFileExtension($filename);

					if (in_array($ext_tmp, $arPossiblePreviewTypes))
					{
						$optionClosedHTAccess = OPTION_CLOSED_HTACCESS;
						if (bfsCheckClosedHTAccess($path))
							$optionClosedHTAccess = "Y";

						$resize = $frameWidth - 10;
						if ($resize > $frameHeight - 40)
							$resize = $frameHeight - 40;

						echo "<img src=\"image.php?resize=".$resize."&amp;path=".urlencode($path)."&amp;imgname=".urlencode($filename).(($optionClosedHTAccess == "Y") ? "&amp;direct_show=Y" : "")."\" alt=\"\" title=\"".htmlspecialchars($filename)."\" border=\"0\">";
					}
					elseif (in_array($ext_tmp, $arUOFFileTypes["flash"]["exts"]))
					{
						$resize = $frameWidth - 10;
						if ($resize > $frameHeight - 40)
							$resize = $frameHeight - 40;

						$arImageSize = getImageSize($absFilePath);
						$sizeX = IntVal($arImageSize[0]);
						$sizeY = IntVal($arImageSize[1]);

						if (($sizeX > $sizeY) && ($sizeX > $resize) || ($sizeX <= $sizeY) && ($sizeY > $resize))
						{
							if ($sizeX > $sizeY)
							{
								$sizeY = Floor($sizeY * ($resize / $sizeX));
								$sizeX = $resize;
							}
							else
							{
								$sizeX = Floor($sizeX * ($resize / $sizeY));
								$sizeY = $resize;
							}
						}
						?>
						<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="<?= $sizeX ?>" height="<?= $sizeY ?>" id="preview_flash" align="middle">
						<param name="allowScriptAccess" value="sameDomain" />
						<param name="movie" value="<?= htmlspecialchars($path."/".$filename) ?>" />
						<param name="quality" value="high" />
						<param name="wmode" value="transparent" />
						<param name="bgcolor" value="#ffffff" />
						<embed src="<?= htmlspecialchars($path."/".$filename) ?>" quality="high" bgcolor="#ffffff" width="<?= $sizeX ?>" height="<?= $sizeY ?>" name="preview_flash" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>
						<?
					}
					else
						echo "<img src=\"icons/types/".uofGetFileType($filename)."_big.gif\" width=\"25\" height=\"25\" border=\"0\" title=\"".htmlspecialchars($filename)."\">";
					?>
					<div style="width:<?= ($frameWidth - 10) ?>px;overflow:hidden"><font class="bfstext"><?= htmlspecialchars($filename) ?></font></div>
					<div style="width:<?= ($frameWidth - 10) ?>px;overflow:hidden"><font class="bfstext"><?
						$fs = FileSize($absFilePath);
						if ($fs / 1000000 > 1)
							$fs = Round($fs / 1000000.0, 1)." Mb";
						elseif ($fs / 1000 > 1)
							$fs = Round($fs / 1000.0, 1)." Kb";
						else
							$fs = $fs." b";
						echo $fs;

						if (in_array($ext_tmp, $arPossiblePreviewTypes))
						{
							$arImageSize = getimagesize($absFilePath);
							echo " (".$arImageSize[0]."&nbsp;x&nbsp;".$arImageSize[1]." px)";
						}
					?></font></div>
					<?
				}
				?>
			</td>
		</tr>
	</table>

	<input type="hidden" name="lang" value="<?= LANG ?>">
	<input type="hidden" name="site" value="<?= htmlspecialchars($_GET["site"]) ?>">
	<input type="hidden" name="path" value="<?= htmlspecialchars($_GET["path"]) ?>">
	<input type="hidden" name="filename" value="<?= htmlspecialchars($_GET["filename"]) ?>">
	<input type="hidden" name="frame_width" value="">
	<input type="hidden" name="frame_height" value="">
</form>

<script language="JavaScript">
<!--
top.__frmInfoLoaded = true;
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