<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

$filemanPerms = $GLOBALS["APPLICATION"]->GetGroupRight("fileman");
if ($filemanPerms > "D"):

/**********************************************************************************/
$selfPath = str_replace("\\", "/", __FILE__);
$uofRootPath = substr($selfPath, 0, strlen($selfPath) - strlen("/get_folders.php"));
require_once($uofRootPath."/options.php");
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<script language="JavaScript">
<?
$item_id = IntVal($_GET["item_id"]);

$site = $_GET["site"];
$site = CSite::GetDefSite($site);
$documentRoot = CSite::GetSiteDocRoot($site);

$path = Rel2Abs("/", $path);

$abs_path = $documentRoot.$path;
?>
var arTreeItems = new Array();
<?
bfsMakeFolderArray($site, $path, array());
?>
window.parent.bfsAddFolders(<?= $item_id ?>, arTreeItems);
</script>
</head>
<body>
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
<title></title>
</head>
<body>
</body>
</html>
<?
/**********************************************************************************/

endif;

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin_after.php");
?>