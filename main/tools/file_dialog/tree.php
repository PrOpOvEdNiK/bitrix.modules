<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/tools/file_dialog/file_dialog.php");

$filemanPerms = $GLOBALS["APPLICATION"]->GetGroupRight("fileman");
if ($filemanPerms > "D"):

/**********************************************************************************/
$selfPath = str_replace("\\", "/", __FILE__);
$uofRootPath = substr($selfPath, 0, strlen($selfPath) - strlen("/tree.php"));
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
</head>
<body>

<form name="frmTree" action="tree.php" method="get" onsubmit="return false" style="display:inline; margin: 0;">

<table cellspacing="0" width="100%">
<tr>
	<td>
		<?
		$site = $_GET["site"];
		$newSite = CSite::GetDefSite($site);
		if ($site != $newSite)
		{
			$site = $newSite;
			$siteQuote = str_replace("'", "\\'", $site);
			?>
			<script language="JavaScript">
				top.bfsChangeSite('<?= $siteQuote ?>', 'frmTree');
			</script>
			<?
		}

		$path = $_GET["path"];
		$path = Rel2Abs("/", $path);
		?>
		<script language="JavaScript">
			var arTreeItems = new Array();
			<?
			bfsMakeFolderArray($site, "", array());
			?>

			var bfsTree;

			bfsGetElement = document.all ? function (pID) { return document.all[pID] } : function (pID) { return document.getElementById(pID) };

			var arBFSIconsList = {
					'icon_empty' : 'icons/empty.gif',
					'icon_folder' : 'icons/folder.gif',
					'icon_folderopen' : 'icons/folderopen.gif',
					'icon_plus' : 'icons/plus.gif',
					'icon_minus' : 'icons/minus.gif'
				};

			function bfsTreeItem(pParent, pOrder)
			{
				this.pDepth  = pParent.pDepth + 1;
				this.pLevel = pParent.pLevel[pOrder + (this.pDepth ? 3 : 0)];
				if (!this.pLevel)
					return;

				this.pRoot    = pParent.pRoot;
				this.pParent  = pParent;
				this.pOrder   = pOrder;
				this.bOpened  = false;
				this.bEmpty  = ((this.pLevel[2] == "Y") ? true : false);

				this.pInd = this.pRoot.arIndex.length;
				this.pRoot.arIndex[this.pInd] = this;
				pParent.arChildren[pOrder] = this;

				this.arChildren = [];
				for (var i = 0; i < this.pLevel.length - 3; i++)
					new bfsTreeItem(this, i);

				this.GetIcon = bfsTreeItemIcon;
				this.OpenItem = bfsTreeItemOpen;
				this.SelectItem = bfsTreeItemSelect;
				this.InitItem = bfsTreeItemInit;
				this.ShowStatus = bfsTreeItemStatus;
				this.IsLast = function () { return this.pOrder == this.pParent.arChildren.length - 1 };
			}

			function bfsTree(pItems)
			{
				this.pLevel = pItems;
				this.pRoot = this;
				this.arIndex = [];
				this.itemSelected = null;
				this.pDepth = -1;

				var oIcon = new Image();
				oIcon.src = arBFSIconsList['icon_empty'];
				arBFSIconsList['image_empty'] = oIcon;

				var oIcon = new Image();
				oIcon.src = arBFSIconsList['icon_folder'];
				arBFSIconsList['image_folder'] = oIcon;

				var oIcon = new Image();
				oIcon.src = arBFSIconsList['icon_folderopen'];
				arBFSIconsList['image_folderopen'] = oIcon;

				var oIcon = new Image();
				oIcon.src = arBFSIconsList['icon_plus'];
				arBFSIconsList['image_plus'] = oIcon;

				var oIcon = new Image();
				oIcon.src = arBFSIconsList['icon_minus'];
				arBFSIconsList['image_minus'] = oIcon;

				this.ToggleItem = function (pInd) {	var oItem = this.arIndex[pInd]; oItem.OpenItem(oItem.bOpened) };
				this.SelectItem = function (pInd) { return this.arIndex[pInd].SelectItem(); };
				this.MouseOut   = function (pInd) { this.arIndex[pInd].ShowStatus(true) };
				this.MouseIn  = function (pInd) { this.arIndex[pInd].ShowStatus() };

				this.arChildren = [];
				for (var i = 0; i < pItems.length; i++)
					new bfsTreeItem(this, i);

				bfsTree = this;

				for (var i = 0; i < this.arChildren.length; i++)
					document.write(this.arChildren[i].InitItem());
			}

			function bfsChangeSite(site, bNoEvent)
			{
				document.frmTree.site.value = site;

				if (!bNoEvent)
					top.bfsChangeSite(site, "frmTree");

				top.__frmTreeLoaded = false;
				document.frmTree.submit();
			}

			function bfsAddFolders(pID, arPTreeItems)
			{
				if (arPTreeItems.length > 0 && arPTreeItems[0] && typeof(arPTreeItems[0]) == "object")
				{
					var i;
					for (i = 0; i < arPTreeItems.length; i++)
						bfsTree.arIndex[pID].pLevel[i + 3] = arPTreeItems[i];

					bfsTree.arIndex[pID].arChildren = [];
					for (i = 0; i < arPTreeItems.length; i++)
						new bfsTreeItem(bfsTree.arIndex[pID], i);
				}
				else
				{
					bfsTree.arIndex[pID].bEmpty = true;
				}

				bfsTree.arIndex[pID].OpenItem(false);
			}

			function bfsMakeFilePath(pItem)
			{
				var result = "";

				var n = pItem.pDepth;
				var pItem_tmp = pItem;

				for (var i = 0; i <= n; i++)
				{
					result = "/" + pItem_tmp.pLevel[1] + result;
					pItem_tmp = pItem_tmp.pParent;
				}

				return result;
			}

			function __bfsFindTreeItem(arVal, ind, parentItem)
			{
				var i;

				if ((parentItem.pDepth != -1) && !parentItem.bOpened)
					parentItem.OpenItem(false);

				if (arVal.length > ind)
				{
					for (i = 0; i < parentItem.arChildren.length; i++)
					{
						if (arVal[ind] == parentItem.arChildren[i].pLevel[1])
						{
							return __bfsFindTreeItem(arVal, ind + 1, parentItem.arChildren[i]);
						}
					}
				}

				return parentItem.pInd;
			}

			function bfsFindTreeItem(path)
			{
				if (path && (path.length > 0))
				{
					while (path.substr(0, 1) == "/")
						path = path.substr(1);
				}

				if (path && (path.length > 0))
				{
					var arPath = path.split("/");
					var pInd;

					pInd = __bfsFindTreeItem(arPath, 0, bfsTree);

					bfsTree.arIndex[pInd].SelectItem(false, true);
				}
				else
				{
					if (bfsTree.itemSelected
						&& typeof(bfsTree.itemSelected) == "object")
					{
						bfsTree.itemSelected.SelectItem(true);
					}
				}
			}

			function bfsTreeItemOpen(bClose)
			{
				var oTreeDiv = bfsGetElement('tree_div_' + this.pInd);
				if (!oTreeDiv)
					return;

				if (!oTreeDiv.innerHTML)
				{
					// Add new elements
					if (!this.bEmpty && this.arChildren.length <= 0)
					{
						window.frames["hidden_action_frame"].location.replace('get_folders.php?path=' + escape(bfsMakeFilePath(this)) + '&site=<?= UrlEncode($site) ?>&item_id=' + this.pInd);
						return;
					}

					var arChildren = [];
					for (var i = 0; i < this.arChildren.length; i++)
						arChildren[i]= this.arChildren[i].InitItem();
					oTreeDiv.innerHTML = arChildren.join('');
				}
				oTreeDiv.style.display = ((bClose || oTreeDiv.innerHTML.length <= 0) ? 'none' : 'block');

				this.bOpened = !bClose;

				var oTreeIcon = document.images['tree_img_' + this.pInd],
					oItemIcon = document.images['item_img_' + this.pInd];
				if (oTreeIcon)
					oTreeIcon.src = this.GetIcon(true);
				if (oItemIcon)
					oItemIcon.src = this.GetIcon();

				this.ShowStatus();
			}

			function bfsTreeItemSelect(bUnSelect, bSkipPanel)
			{
				if (!bUnSelect)
				{
					var o_olditem = this.pRoot.itemSelected;
					this.pRoot.itemSelected = this;

					if (!bSkipPanel)
						top.bfsChangePath(bfsMakeFilePath(this), "frmTree");

					if (o_olditem)
						o_olditem.SelectItem(true);
				}
				var oItemIcon = document.images['item_img_' + this.pInd];
				if (oItemIcon)
					oItemIcon.src = this.GetIcon();
				bfsGetElement('item_txt_' + this.pInd).style.fontWeight = bUnSelect ? 'normal' : 'bold';

				this.ShowStatus();

				return Boolean(this.pLevel[1]);
			}

			function bfsTreeItemStatus(bClear)
			{
				window.setTimeout('window.status="' + (bClear ? '' : this.pLevel[0]) + '"', 10);
			}

			function bfsDual()
			{
			}

			function bfsTreeItemInit()
			{
				var a_offset = [], o_current_item = this.pParent;
				for (var i = this.pDepth; i > 0; i--)
				{
					a_offset[i] = '<img src="' + arBFSIconsList['icon_empty'] + '" border="0" align="absbottom">';
					o_current_item = o_current_item.pParent;
				}

				return '<table cellpadding="0" cellspacing="0" border="0"><tr><td nowrap>' +
					a_offset.join('') + (!this.bEmpty
					? '<a href="javascript:bfsTree.ToggleItem(' + this.pInd + ')" onmouseover="bfsTree.MouseIn(' + this.pInd + ')" onmouseout="bfsTree.MouseOut(' + this.pInd + ')"><img src="' + this.GetIcon(true) + '" border="0" align="absbottom" name="tree_img_' + this.pInd + '"></a>'
					: '<img src="' + this.GetIcon(true) + '" border="0" align="absbottom">')
					+ '<a href="javascript:bfsDual()" onclick="return bfsTree.SelectItem(' + this.pInd + ')" ondblclick="bfsTree.ToggleItem(' + this.pInd + ')" onmouseover="bfsTree.MouseIn(' + this.pInd + ')" onmouseout="bfsTree.MouseOut(' + this.pInd + ')" class="bfstext" id="item_txt_' + this.pInd + '"><img src="' + this.GetIcon() + '" border="0" align="absbottom" name="item_img_' + this.pInd + '">' + this.pLevel[0] + '</a></td></tr></table>' + (!this.bEmpty ? '<div id="tree_div_' + this.pInd + '" style="display:none"></div>' : '');
			}

			function bfsTreeItemIcon(bTreeIcon)
			{
				if (bTreeIcon)
				{
					if (!this.bEmpty)
					{
						if (this.bOpened)
							return arBFSIconsList['icon_minus'];
						else
							return arBFSIconsList['icon_plus'];
					}
					else
						return arBFSIconsList['icon_empty'];
				}
				else
				{
					if (!this.bOpened && this.pRoot.itemSelected != this)
						return arBFSIconsList['icon_folder'];
					else
						return arBFSIconsList['icon_folderopen'];
				}
			}
		</script>

		<script language="JavaScript">
			new bfsTree(arTreeItems);
		</script>
	</td>
</tr>
</table>
<iframe style="width:0px; height:0px; border: 0px" name="hidden_action_frame" src="" width="0" height="0"></iframe>

<input type="hidden" name="lang" value="<?= LANG ?>">
<input type="hidden" name="site" value="<?= htmlspecialchars($site) ?>">

</form>

<script language="JavaScript">
	<?
	$pathQuoted = str_replace("'", "\\'", $path);
	?>
	bfsFindTreeItem('<?= $pathQuoted ?>');
</script>

<script language="JavaScript">
<!--
top.__frmTreeLoaded = true;
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
