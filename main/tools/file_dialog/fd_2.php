<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/tools/file_dialog/file_dialog.php");

$filemanPerms = $GLOBALS["APPLICATION"]->GetGroupRight("fileman");
if ($filemanPerms > "D"):

/**********************************************************************************/
$selfPath = str_replace("\\", "/", __FILE__);
$uofRootPath = substr($selfPath, 0, strlen($selfPath) - strlen("/fd_2.php"));
//echo $uofRootPath."/options.php";
require_once($uofRootPath."/options.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?= GetMessage("MAIN_BFSD_TITLE") ?></title>
<style>
<?bfsPrintStyles(DEFAULT_PREVIEW_SIZE);?>
</style>
<script type="text/javascript">
	//alert(window.opener.dubug_vd);

	__frmHeadLoaded = false;
	__frmTreeLoaded = false;
	__frmInfoLoaded = false;
	__frmPanelLoaded = false;
	__frmButtonsLoaded = false;
	__frmLoadLoaded = false;

	// CHANGE PATH
	var __path;

	function __bfsChangePathTree()
	{
		if (__frmTreeLoaded)
		{
			top.frames["frmTree"].bfsFindTreeItem(__path);
		}
		else
		{
			setTimeout(__bfsChangePathTree, 1000);
		}
	}

	function __bfsChangePathPanel()
	{
		if (__frmPanelLoaded)
		{
			top.frames["frmPanel"].bfsSetPath(__path, true);
		}
		else
		{
			setTimeout(__bfsChangePathPanel, 1000);
		}
	}

	function __bfsChangePathHead()
	{
		if (__frmHeadLoaded)
		{
			top.frames["frmHead"].bfsShowPath(__path);
		}
		else
		{
			setTimeout(__bfsChangePathHead, 1000);
		}
	}

	function __bfsChangePathLoad()
	{
		if (__frmLoadLoaded)
		{
			top.frames["frmLoad"].bfsSetFilePath(__path);
		}
		else
		{
			setTimeout(__bfsChangePathLoad, 1000);
		}
	}

	function __bfsChangePathInfo()
	{
		if (__frmInfoLoaded)
		{
			top.frames["frmInfo"].bfsCloseFile();
		}
		else
		{
			setTimeout(__bfsChangePathInfo, 1000);
		}
	}

	function __bfsChangePathButton()
	{
		if (__frmButtonsLoaded)
		{
			top.frames["frmButtons"].bfsSetFilePath(__path);
		}
		else
		{
			setTimeout(__bfsChangePathButton, 1000);
		}
	}

	function bfsChangePath(path, frameName)
	{
		__path = path;

		__bfsChangePathButton();
		__bfsChangePathInfo();

		if (frameName != "frmTree")
			__bfsChangePathTree();

		if (frameName != "frmPanel")
			__bfsChangePathPanel();

		if (frameName != "frmHead")
			__bfsChangePathHead();

		if (frameName != "frmLoad")
			__bfsChangePathLoad();
	}


	// CHANGE VIEW
	var __view;

	function bfsChangeView(view)
	{
		__view = view;

		if (__frmPanelLoaded)
		{
			top.frames["frmPanel"].bfsChangeView(__view);
		}
		else
		{
			setTimeout(bfsChangeView, 1000);
		}
	}


	// OPEN FILE
	var __openFileName, __openPath, __openSite;

	function __bfsOpenFileInfo()
	{
		if (__frmInfoLoaded)
		{
			top.frames["frmInfo"].bfsOpenFile(__openFileName, __openPath, __openSite);
		}
		else
		{
			setTimeout(__bfsOpenFileInfo, 1000);
		}
	}

	function bfsSetFilename(filename)
	{
		if (__frmButtonsLoaded)
		{
			top.frames["frmButtons"].bfsSetFilename(filename);
		}
		else
		{
			setTimeout(bfsSetFilename, 1000);
		}
	}

	function bfsGetFilename()
	{
		if(__frmButtonsLoaded)
		{
			return top.frames["frmButtons"].bfsGetFilename();
		}
		return '';
	}

	function bfsGetPanelFiles()
	{
		if(__frmPanelLoaded)
			return top.frames["frmPanel"].arAllFilenames;
		return [];
	}

	function __bfsOpenFileButton()
	{
		if (__frmButtonsLoaded)
		{
			top.frames["frmButtons"].bfsSelectFile(__openFileName, __openPath, __openSite);
		}
		else
		{
			setTimeout(__bfsOpenFileButton, 1000);
		}
	}

	function bfsOpenFile(fileName, path, site)
	{
		__openFileName = fileName;
		__openPath = path;
		__openSite = site;

		__bfsOpenFileInfo();
		__bfsOpenFileButton();
	}


	// RELOAD PANEL
	function bfsReload()
	{
		if (__frmPanelLoaded)
		{
			top.frames["frmPanel"].bfsReload();
		}
		else
		{
			setTimeout(bfsReload, 1000);
		}
	}


	// SUBMIT DIALOG
	function bfsCloseDialog()
	{
		//alert('window.close();');
		window.close();
	}

	function bfsSubmitDialog(filename, path, site)
	{
		<?if($_GET['savepage']=='Y'):?>
			if(filename.length<=0)
			{
				alert('Введите, пожалуйста, имя файла.');
				return;
			}

			var menu_res = top.frames["frmButtons"].ReturnMenuObject();
			var title = top.frames["frmButtons"].ReturnTitle();
			<?
			$function_name = $_GET["function_name"];
			$function_name = preg_replace("/[^a-zA-Z0-9_]/i", "", $function_name);
			if (strlen($function_name) > 0)
			{
				?>window.opener.<?=$function_name?>(filename, path, site, title, menu_res);<?
			}
			?>
			bfsCloseDialog();
		<?else:?>
			<?
			$function_name = $_GET["function_name"];
			$function_name = preg_replace("/[^a-zA-Z0-9_]/i", "", $function_name);
			if (strlen($function_name) > 0)
			{
				?>
				//alert('!');
				
				//alert(window.opener.dubug_vd());
				alert('window.opener.<?= $function_name ?> = '+window.opener.<?= $function_name ?>);
				//alert('window.opener.dubug_vd = '+dubug_vd);
				//document.write(result);
								
				window.opener.<?= $function_name ?>(filename, path, site);<?
			}
			?>
			bfsCloseDialog();
		<?endif;?>
	}


	// CHANGE FILE FILTER
	var __file_filter;

	function __bfsChangeFileFilter()
	{
		if (__frmPanelLoaded)
		{
			top.frames["frmPanel"].bfsChangeFileFilter(__file_filter);
		}
		else
		{
			setTimeout(__bfsChangeFileFilter, 1000);
		}
	}

	function bfsChangeFileFilter(file_filter)
	{
		__file_filter = file_filter;

		__bfsChangeFileFilter();
	}


	// CHANGE SITE
	var __site;

	function __bfsChangeSiteTree()
	{
		if (__frmTreeLoaded)
		{
			top.frames["frmTree"].bfsChangeSite(__site, true);
		}
		else
		{
			setTimeout(__bfsChangeSiteTree, 1000);
		}
	}

	function __bfsChangeSitePanel()
	{
		if (__frmPanelLoaded)
		{
			top.frames["frmPanel"].bfsChangeSite(__site, true);
		}
		else
		{
			setTimeout(__bfsChangeSitePanel, 1000);
		}
	}

	function __bfsChangeSiteHead()
	{
		if (__frmHeadLoaded)
		{
			top.frames["frmHead"].bfsChangeSite(__site, true);
		}
		else
		{
			setTimeout(__bfsChangeSiteHead, 1000);
		}
	}

	function __bfsChangeSiteLoad()
	{
		if (__frmLoadLoaded)
		{
			top.frames["frmLoad"].bfsChangeSite(__site);
		}
		else
		{
			setTimeout(__bfsChangeSiteLoad, 1000);
		}
	}

	function __bfsChangeSiteButton()
	{
		if (__frmButtonsLoaded)
		{
			top.frames["frmButtons"].bfsChangeSite(__site);
		}
		else
		{
			setTimeout(__bfsChangeSiteButton, 1000);
		}
	}

	function __bfsChangeSiteInfo()
	{
		if (__frmInfoLoaded)
		{
			top.frames["frmInfo"].bfsCloseFile();
		}
		else
		{
			setTimeout(__bfsChangeSiteInfo, 1000);
		}
	}

	function bfsChangeSite(site, frameName)
	{
		__site = site;

		__bfsChangeSiteButton();
		__bfsChangeSiteInfo();

		if (frameName != "frmTree")
			__bfsChangeSiteTree();

		if (frameName != "frmPanel")
			__bfsChangeSitePanel();

		if (frameName != "frmHead")
			__bfsChangeSiteHead();

		if (frameName != "frmLoad")
			__bfsChangeSiteLoad();
	}
</script>
</head>

<?
$bDistinctDocRoots = CSite::IsDistinctDocRoots();
$site = $_GET["site"];
$site = CSite::GetDefSite($site);

$folder_select = (($_GET["folder_select"] == "Y") ? "Y" : "N");

$path = $_GET["path"];
if(strlen($path)<=0)
	$path = CUserOptions::GetOption("file_dialog", "path", "");
$path = urlencode($path);
?>
<?if($_GET['noload']!='Y' && $_GET['savepage']!='Y'):?>
<frameset rows="<?= ($bDistinctDocRoots ? "60" : "30") ?>,*,30" bordercolor="#eeeeee">
<?else:?>
<frameset rows="<?= ($bDistinctDocRoots ? "60" : "30") ?>,*" bordercolor="#eeeeee">
<?endif?>
	<frame src="head.php?file_filter=<?= urlencode($_GET["file_filter"]) ?>&lang=<?= LANG ?>&site=<?= urlencode($site) ?>&path=<?= $path ?>" name="frmHead" scrolling="no" frameborder="0" framespacing="0" noresize="noresize"/>
	<frameset cols="150,*">
		<frameset rows="*,150">
			<frame src="tree.php?file_filter=<?= urlencode($_GET["file_filter"]) ?>&lang=<?= LANG ?>&site=<?= urlencode($site) ?>&path=<?= $path ?>" name="frmTree" scrolling="yes" frameborder="1"/>
			<frame src="info.php?file_filter=<?= urlencode($_GET["file_filter"]) ?>&lang=<?= LANG ?>&site=<?= urlencode($site) ?>&path=<?= $path ?>" name="frmInfo" frameborder="1" scrolling="no"/>
		</frameset>
		<?if($_GET['savepage']=='Y'):?>
			<frameset rows="*,220">
				<frame src="panel.php?savepage=Y&file_filter=<?=urlencode($_GET["file_filter"])?>&lang=<?= LANG ?>&site=<?= urlencode($site) ?>&path=<?= $path?>" name="frmPanel" scrolling="yes" frameborder="1"/>
				<frame src="buttons_save.php?file_filter=<?=urlencode($_GET["file_filter"])?>&lang=<?= LANG ?>&site=<?= urlencode($site) ?>&path=<?= $path?>&folder_select=<?= urlencode($folder_select) ?>" name="frmButtons" frameborder="0" framespacing="0" scrolling="no"/>
			</frameset>
		<?else:?>
			<frameset rows="*,70">
				<frame src="panel.php?file_filter=<?= urlencode($_GET["file_filter"]) ?>&lang=<?= LANG ?>&site=<?= urlencode($site) ?>&path=<?= $path?>" name="frmPanel" scrolling="yes" frameborder="1"/>
				<frame src="buttons.php?file_filter=<?= urlencode($_GET["file_filter"]) ?>&lang=<?= LANG ?>&site=<?= urlencode($site) ?>&path=<?= $path?>&folder_select=<?= urlencode($folder_select) ?>" name="frmButtons" frameborder="0" framespacing="0" scrolling="no"/>
			</frameset>
		<?endif?>
	</frameset>
	<?if($_GET['noload']!='Y' && $_GET['savepage']!='Y'):?>
		<frame src="load.php?file_filter=<?= urlencode($_GET["file_filter"]) ?>&lang=<?= LANG ?>&site=<?= urlencode($site) ?>&path=<?= $path?>" name="frmLoad" frameborder="0" framespacing="0" scrolling="no" noresize="noresize"/>
	<?endif?>
</frameset>

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
