<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
// If True than image thumbnails will be saved in /bitrix/cache_image/
define("CACHE_PREVIEW_IMG", True);
// If "Y" than images will be shown through script
define("OPTION_CLOSED_HTACCESS", "N");

define("DEFAULT_FRAME_WIDTH", 600);
define("DEFAULT_PREVIEW_SIZE", 80);

define("DEFAULT_LIST_SIZE", 150);

define("DEFAULT_INFO_FRAME_WIDTH", 150);
define("DEFAULT_INFO_FRAME_HEIGHT", 150);

IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/tools/file_dialog/file_dialog.php");

$arUOFBitrixPerms = array(
		"D" => GetMessage("MAIN_BFSD_BITRIX_PERMS_D"),
		"R" => GetMessage("MAIN_BFSD_BITRIX_PERMS_R"),
		"U" => GetMessage("MAIN_BFSD_BITRIX_PERMS_U"),
		"W" => GetMessage("MAIN_BFSD_BITRIX_PERMS_W"),
		"X" => GetMessage("MAIN_BFSD_BITRIX_PERMS_X")
	);


function __uofDump($text)
{
	$fff = fopen($_SERVER["DOCUMENT_ROOT"]."/__uof_dump.dat", "a");
	fwrite($fff, date("H:i:s")." - ".$text."\n");
	fclose($fff);
}

function uofCheckSite($site)
{
	if ($site !== false)
	{
		if (strlen($site) > 0)
		{
			$dbRes = CSite::GetByID($site);
			if (!($arRes = $dbRes->Fetch()))
				$site = false;
		}
		else
			$site = false;
	}
	return $site;
}


$arUOFFileTypes = array(
		"css" => array(
				"exts" => array("css"),
				"gtype" => "text",
				"name" => GetMessage("MAIN_BFSD_FTYPE_CSS")
			),
		"htaccess" => array(
				"exts" => array("htaccess"),
				"gtype" => "text",
				"name" => GetMessage("MAIN_BFSD_FTYPE_SYS")
			),
		"html" => array(
				"exts" => array("html", "htm", "shtml", "shtm"),
				"gtype" => "text",
				"name" => GetMessage("MAIN_BFSD_FTYPE_HTML")
			),
		"png" => array(
				"exts" => array("png"),
				"gtype" => "image",
				"name" => GetMessage("MAIN_BFSD_FTYPE_PNG")
			),
		"gif" => array(
				"exts" => array("gif"),
				"gtype" => "image",
				"name" => GetMessage("MAIN_BFSD_FTYPE_GIF")
			),
		"jpeg" => array(
				"exts" => array("jpeg", "jpg", "jpe"),
				"gtype" => "image",
				"name" => GetMessage("MAIN_BFSD_FTYPE_JPG")
			),
		"js" => array(
				"exts" => array("js"),
				"gtype" => "text",
				"name" => "JavaScript"
			),
		"php" => array(
				"exts" => array("php", "php3", "php4", "php5", "phtml"),
				"gtype" => "text",
				"name" => GetMessage("MAIN_BFSD_FTYPE_PHP")
			),
		"txt" => array(
				"exts" => array("txt", "sql"),
				"gtype" => "text",
				"name" => GetMessage("MAIN_BFSD_FTYPE_TXT")
			),
		"xml" => array(
				"exts" => array("xml", "xsl"),
				"gtype" => "text",
				"name" => GetMessage("MAIN_BFSD_FTYPE_XML")
			),
		"csv" => array(
				"exts" => array("csv"),
				"gtype" => "text",
				"name" => GetMessage("MAIN_BFSD_FTYPE_CSV")
			),
		"flash" => array(
				"exts" => array("fla", "swf"),
				"gtype" => "file",
				"name" => GetMessage("MAIN_BFSD_FTYPE_SWF")
			),
		"file" => array(
				"exts" => array(),
				"gtype" => "file",
				"name" => GetMessage("MAIN_BFSD_FTYPE_NA")
			)
	);

function uofGetFileType($fileName)
{
	global $arUOFFileTypes, $arUOFRuntimeFileTypes;

	$fileExt = uofGetFileExtension($fileName);

	if (!isset($arUOFRuntimeFileTypes) || !is_array($arUOFRuntimeFileTypes))
	{
		foreach ($arUOFFileTypes as $key => $value)
			foreach ($value["exts"] as $ext)
				$arUOFRuntimeFileTypes[$ext] = $key;
	}

	if (isset($arUOFRuntimeFileTypes[$fileExt]))
		return $arUOFRuntimeFileTypes[$fileExt];

	return "file";
}

$arPossiblePreviewTypes = array("jpeg", "png", "jpg");
if (function_exists("gd_info"))
{
	$arGDInfo = gd_info();
	if (isset($arGDInfo["GIF Create Support"]))
		if ($arGDInfo["GIF Create Support"] == true)
			array_push($arPossiblePreviewTypes, "gif");
}

function uofGetFileExtension($fileName)
{
	$fileName = trim($fileName, ". \r\n\t");
	$arFileName = explode(".", $fileName);
	$fileExt = strtolower($arFileName[count($arFileName)-1]);
	return $fileExt;
}

function uofPrepareExtFilter($fileFilter)
{
	$result = "";

	$result1 = "";
	$result2 = "";
	$result3 = "";

	$fileFilter = Trim($fileFilter);
	if (strlen($fileFilter) > 0)
	{
		$fileFilter = strtolower($fileFilter);
		if ($fileFilter == "image")
		{
			$result1 .= GetMessage("MAIN_BFSD_FLTR_PIC")." (";
			$result3 .= ")";
			$fileFilter = "jpg,gif,png,jpeg,jpe";
		}
		elseif ($fileFilter == "datum")
		{
			$result1 .= GetMessage("MAIN_BFSD_FLTR_DAT")." (";
			$result3 .= ")";
			$fileFilter = "xml,csv,dat";
		}
		$arFileFilter = explode(",", $fileFilter);
		for ($i = 0; $i < count($arFileFilter); $i++)
		{
			$arFileFilter[$i] = Trim($arFileFilter[$i]);
			if (strlen($arFileFilter[$i]) > 0)
			{
				$arFileFilter[$i] = preg_replace("/[^a-zA-Z0-1_]/i", "", $arFileFilter[$i]);
				if (strlen($arFileFilter[$i]) > 0)
				{
					if (strlen($result2) > 0)
						$result2 .= ", ";
					if (strlen($result) > 0)
						$result .= ",";

					$result2 .= "*.".$arFileFilter[$i];
					$result .= $arFileFilter[$i];
				}
			}
		}
	}
	return array($result, $result1.$result2.$result3);
}

function bfsMakeFolderArray($site, $path, $arInd)
{
	global $APPLICATION;

	if (($fileAccess = $APPLICATION->GetFileAccessPermission(array($site, $path))) >= "R")
	{
		$arFilter = array("MIN_PERMISSION" => "R");
		$arSort = array("name" => "asc");
		$arDirs = array();
		$arFiles = array();
		GetDirList(array($site, $path), $arDirs, $arFiles, $arFilter, $arSort, "D");
		$ind = -1;

		$strInd = "";
		for ($i = 0; $i < count($arInd); $i++)
			$strInd .= "[".$arInd[$i]."]";

		foreach ($arDirs as $Dir)
		{
			$ind++;
			echo "arTreeItems".$strInd."[".(strlen($strInd) > 0 ? $ind + 3 : $ind)."]=new Array();\n";
			echo "arTreeItems".$strInd."[".(strlen($strInd) > 0 ? $ind + 3 : $ind)."][0]='".str_replace("'", "\\'", $Dir["NAME"])."';\n";
			echo "arTreeItems".$strInd."[".(strlen($strInd) > 0 ? $ind + 3 : $ind)."][1]='".str_replace("'", "\\'", $Dir["NAME"])."';\n";
			echo "arTreeItems".$strInd."[".(strlen($strInd) > 0 ? $ind + 3 : $ind)."][2]='N';\n";
			$arInd_tmp = $arInd;
			$arInd_tmp[] = (strlen($strInd) > 0 ? $ind + 3 : $ind);
			if (count($arInd_tmp) < 2)
				bfsMakeFolderArray($site, $path."/".$Dir["NAME"], $arInd_tmp);
		}
		if ($ind == -1)
			echo "arTreeItems".$strInd."[2]='Y';\n";
	}
}

function bfsCheckFilePath($documentRoot, $path)
{
	while (!file_exists($documentRoot.$path) && strlen($path) > 0)
	{
		$p = strrpos($path, "/");
		if ($p !== false)
			$path = substr($path, 0, $p);
		else
			$path = "";
	}

	if (file_exists($documentRoot.$path))
	{
		if (is_file($documentRoot.$path))
		{
			$p = strrpos($path, "/");
			if ($p !== false)
				$path = substr($path, 0, $p);
			else
				$path = "";
		}
		return $path;
	}
	else
	{
		return False;
	}
}

function bfsCheckClosedHTAccess($path)
{
	if (substr($path, 0, strlen("/bitrix/modules")) == "/bitrix/modules")
		return True;

	return False;
}

function bfsPrintStyles($previewSize = 80)
{
	?>
	body {margin:0;padding:0;}
	.bfsbody{background-color:#eeeeee}
	.bfsbutton {}
	.bfstext {font-family:Arial;font-size:12px;color:#000000}
	.bfsinput {font-size:12px;font-family:Arial;border:1px solid #000000}
	.bfsselect {font-size:12px;font-family:Arial}
	.bfspreviewcell{border: 1px solid;border-color: #eeeeee;width: <?= $previewSize + 5 ?>px;height: <?= $previewSize + 5 ?>px;text-align: center;}
	.bfsdetailcell{border: 1px solid;border-color: #ffffff #eeeeee #ffffff #ffffff;}
	.bfshead{background-color:#eeeeee;border: 1px solid;border-color: #eeeeee #ffffff #eeeeee #eeeeee;}
	<?
}
?>