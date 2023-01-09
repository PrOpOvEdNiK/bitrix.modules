<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/tools/file_dialog/file_dialog.php");
IncludeModuleLangFile(__FILE__);

$filemanPerms = $GLOBALS["APPLICATION"]->GetGroupRight("fileman");
if ($filemanPerms > "D"):

/**********************************************************************************/
$selfPath = str_replace("\\", "/", __FILE__);
$uofRootPath = substr($selfPath, 0, strlen($selfPath) - strlen("/buttons_save.php"));
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

var arMenuItems;
function MenuLoaded(arMenuIts)
{
	arMenuItems = arMenuIts;

	var lMenuType = document.getElementById("menu_type");

	while(lMenuType.length>1)
		lMenuType.remove(1);

	var oOption;
	for(var i=0; i<arMenuItems.length; i++)
	{
		oOption = new Option(arMenuItems[i].name, arMenuItems[i].type, false, false);
		//oOption.innerText = arMenuItems[i].name; oOption.value = arMenuItems[i].type;
		lMenuType.options.add(oOption);
	}

	menu_type_change();
}

function __CHRow(row, bShow)
{
	if(bShow)
	{
		try{row.style.display = 'table-row';}
		catch(e){row.style.display = 'block';}
	}
	else
	{
		row.style.display = 'none';
	}
}

function menu_type_change()
{
	var lMenuType = document.getElementById("menu_type");
	if(lMenuType.selectedIndex==0)
	{
		__CHRow(document.getElementById('r1'), false);
		__CHRow(document.getElementById('r2'), false);
		__CHRow(document.getElementById('r3'), false);
		__CHRow(document.getElementById('r4'), false);
	}
	else
	{
		__CHRow(document.getElementById('r1'), true);

		document.getElementById("menu_add_new").checked = true;
		menu_add_change();
	}
}

function menu_add_change()
{
	var lMenuType = document.getElementById("menu_type");
	var arItems = arMenuItems[lMenuType.selectedIndex-1].items;

	var oOption;
	if(document.getElementById("menu_add_new").checked)
	{
		__CHRow(document.getElementById('r2'), true);
		__CHRow(document.getElementById('r3'), true);
		__CHRow(document.getElementById('r4'), false);

		var lMenuItems = document.getElementById("menu_item_pos_new");
		while(lMenuItems.length>0)
			lMenuItems.remove(0);

		for(var i=0; i<arItems.length; i++)
		{
			oOption = new Option(arItems[i], i+1, false, false);
			//oOption.innerText = arMenuItems[i].name; oOption.value = arMenuItems[i].type;
			lMenuItems.options.add(oOption);
		}

		oOption = new Option('<?=GetMessage("MAIN_FD_LAST_MENU_ITEM")?>', arItems.length, false, true);
		lMenuItems.options.add(oOption);
	}
	else
	{
		__CHRow(document.getElementById('r2'), false);
		__CHRow(document.getElementById('r3'), false);
		__CHRow(document.getElementById('r4'), true);

		var lMenuItems = document.getElementById("menu_item_pos_exists");
		while(lMenuItems.length>0)
			lMenuItems.remove(0);

		for(var i=0; i<arItems.length; i++)
		{
			oOption = new Option(arItems[i], i+1, false, false);
			//oOption.innerText = arMenuItems[i].name; oOption.value = arMenuItems[i].type;
			lMenuItems.options.add(oOption);
		}
	}
}

function ReturnTitle()
{
	return document.getElementById("title").value;
}

function ReturnMenuObject()
{
	var result = false;
	var type = document.getElementById("menu_type").value;
	if(type)
	{
		result = {'type': type};
		if(document.getElementById("menu_add_new").checked)
		{
			result.menu_add_new = true;
			result.menu_add_name = document.getElementById("menu_item_name").value;
			result.menu_add_pos = document.getElementById("menu_item_pos_new").value;
		}
		else
		{
			result.menu_add_new = false;
			result.menu_add_pos = document.getElementById("menu_item_pos_exists").value;
		}
	}
	return result;
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
	document.frmButtons.filename.value = <?= ($bAllowFolderSelect ? "path + '/' + " : "") ?>fileName;
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
						<td align="right" width="50%"><font class="bfstext"><?= GetMessage("MAIN_BFSD_FILENAME") ?>:</font></td>
						<td align="left" width="50%"><font class="bfstext">
							<input type="text" name="filename" id="filename" style="width:280px;" class="bfsinput" value="<?= htmlspecialchars($filename) ?>" size="40">
						</font></td>
					</tr>
					<tr>
						<td align="right"><font class="bfstext"><?= GetMessage("MAIN_BFSD_FILETYPE") ?>:</font></td>
						<td align="left"><font class="bfstext">
							<?
							list($userFilterKey, $userFilterValue) = uofPrepareExtFilter($file_filter);
							?>
							<select name="file_filter" onchange="bfsChangeFilter(this.options[this.selectedIndex].value)" class="bfsselect">
								<?
								if(strlen($userFilterKey) > 0)
								{
									?><option selected value="<?= htmlspecialchars($userFilterKey) ?>"><?= htmlspecialchars($userFilterValue) ?></option><?
								}
								?>
								<option value=""><?= GetMessage("MAIN_BFSD_ALL_FILES") ?> (*.*)</option>
							</select>
						</font></td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td align="right" nowrap><font class="bfstext"><?echo GetMessage("MAIN_FD_TITLE")?></font></td>
						<td align="left"><font class="bfstext">
							<input type="text" name="title" id="title" style="width:280px;" class="bfsinput" value="<?=htmlspecialchars($title)?>" size="40">
						</font></td>
					</tr>
					<tr>
						<td align="right"><font class="bfstext"><?echo GetMessage("MAIN_FD_ADD_2_MENU")?></font></td>
						<td align="left"><select id="menu_type" onchange="menu_type_change()"><option value=""><?echo GetMessage("MAIN_FD_ADD_2_MENU_NOT")?></option></select></td>
					</tr>
					<tr id="r1" style="display:none">
						<td align="right"><font class="bfstext"><?echo GetMessage("MAIN_FD_ADD_2_MENU_ITEM")?></font></td>
						<td align="left"><font class="bfstext">
							<input type="radio" id="menu_add_new" name="menu_add" onclick="menu_add_change()"> <label for="menu_add_new"><?echo GetMessage("MAIN_FD_ADD_2_MENU_ADD_NEW")?></label> / <input type="radio" onclick="menu_add_change()" id="menu_add_exists" name="menu_add"> <label for="menu_add_exists"><?echo GetMessage("MAIN_FD_ADD_2_MENU_REUSE")?></label>
						</font></td>
					</tr>
					<tr id="r2" style="display:none">
						<td align="right" nowrap><font class="bfstext"><?echo GetMessage("MAIN_FD_ADD_2_MENU_NEW_NAME")?></font></td>
						<td align="left"><input type="text" style="width:280px;" class="bfsinput" id="menu_item_name"></td>
					</tr>
					<tr id="r3" style="display:none">
						<td align="right" nowrap><font class="bfstext"><?echo GetMessage("MAIN_FD_ADD_2_MENU_REUSE_NAME")?></font></td>
						<td align="left"><select id="menu_item_pos_new"><option value=""><?echo GetMessage("MAIN_FD_ADD_2_MENU_NA")?></option></select></td>
					</tr>
					<tr id="r4" style="display:none">
						<td align="right" nowrap><font class="bfstext"><?echo GetMessage("MAIN_FD_ADD_2_MENU_REUSE_ITEM")?></font></td>
						<td align="left"><select id="menu_item_pos_exists"><option value=""><?echo GetMessage("MAIN_FD_ADD_2_MENU_NA")?></option></select></td>
					</tr>
				</table>
			</td>
			<td width="10%" valign="top">
				<table width="100%" border="0" cellpadding="1" cellspacing="1">
					<tr>
						<td align="right">
							<input type="button" OnClick="bfsSubmitDialog()" name="save_file" value="<?echo GetMessage("MAIN_FD_SAVE")?>" style="width:100px" class="bfsbutton">
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

	<input type="hidden" name="lang" value="<?=LANG?>">
	<input type="hidden" name="site" value="<?=htmlspecialchars($site)?>">
	<input type="hidden" name="path" value="<?=htmlspecialchars($path)?>">
</form>

<script language="JavaScript">
<!--
top.__frmButtonsLoaded = true;
if(top.window.opener && top.window.opener.document)
{
	if(top.window.opener.document.getElementById('title'))
		document.getElementById('title').value = top.window.opener.document.getElementById('title').value;

	if(top.window.opener.document.getElementById('filename'))
		document.getElementById('filename').value = top.window.opener.document.getElementById('filename').value;
}
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
