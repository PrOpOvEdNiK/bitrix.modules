<?
$HTTP_ACCEPT_ENCODING = "";
$_SERVER["HTTP_ACCEPT_ENCODING"] = "";
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

$filemanPerms = $GLOBALS["APPLICATION"]->GetGroupRight("fileman");
if ($filemanPerms > "D"):

/**********************************************************************************/
$selfPath = str_replace("\\", "/", __FILE__);
$uofRootPath = substr($selfPath, 0, strlen($selfPath) - strlen("/image.php"));
require_once($uofRootPath."/options.php");

/****************************** FUNCTIONS ********************************/
function uofCreatePreviewImage($sizeX, $sizeY, $directShow)
{
	global $imgname, $absPath, $resize, $bGD2, $previewFilePath, $quality, $previewFileUrl, $documentRoot, $path;

	$ext_tmp = uofGetFileExtension($imgname);

	switch ($ext_tmp)
	{
		case 'jpg':
			$imageInput = imagecreatefromjpeg($absPath."/".$imgname);
		break;
		case 'jpeg':
			$imageInput = imagecreatefromjpeg($absPath."/".$imgname);
		break;
		case 'gif':
			$imageInput = imagecreatefromgif($absPath."/".$imgname);
		break;
		case 'png':
			$imageInput = imagecreatefrompng($absPath."/".$imgname);
		break;
		default:
			die();
	}

	if ($sizeX > $sizeY)
	{
		$newY = $sizeY * ($resize / $sizeX);

		if ($bGD2)
			$imageOutput = ImageCreateTrueColor($resize, $newY);
		else
			$imageOutput = ImageCreate($resize, $newY);

		if ($bGD2)
			imagecopyresampled($imageOutput, $imageInput, 0, 0, 0, 0, $resize, $newY, $sizeX, $sizeY);
		else
			imagecopyresized($imageOutput, $imageInput, 0, 0, 0, 0, $resize, $newY, $sizeX, $sizeY);
	}
	else
	{
		$newX = $sizeX * ($resize / $sizeY);

		if ($bGD2)
			$imageOutput = ImageCreateTrueColor($newX, $resize);
		else
			$imageOutput = ImageCreate($newX, $resize);

		if ($bGD2)
			imagecopyresampled($imageOutput, $imageInput, 0, 0, 0, 0, $newX, $resize, $sizeX, $sizeY);
		else
			imagecopyresized($imageOutput, $imageInput, 0, 0, 0, 0, $newX, $resize, $sizeX, $sizeY);
	}

	if (CACHE_PREVIEW_IMG)
	{
		CheckDirPath($documentRoot.BX_PERSONAL_ROOT."/cache_image".$path."/".$resize."/");

		switch ($ext_tmp)
		{
			case 'jpg':
				imageJPEG($imageOutput, $previewFilePath, $quality);
				break;
			case 'jpeg':
				imageJPEG($imageOutput, $previewFilePath, $quality);
				break;
			case 'gif':
				imageGIF($imageOutput, $previewFilePath);
				break;
			case 'png':
				imagePNG($imageOutput, $previewFilePath);
				break;
		}
	}

	if (($directShow == "Y") || !CACHE_PREVIEW_IMG)
	{
		switch ($ext_tmp)
		{
			case 'jpg':
				imageJPEG($imageOutput, null, $quality);
				break;
			case 'jpeg':
				imageJPEG($imageOutput, null, $quality);
				break;
			case 'gif':
				imageGIF($imageOutput);
				break;
			case 'png':
				imagePNG($imageOutput);
				break;
		}
	}
	else
	{
		header("Location: " . $previewFileUrl);
	}

	if (isset($imageInput))
	{
		imagedestroy($imageInput);
		imagedestroy($imageOutput);
	}
}

function uofShowImage($file, $directShow)
{
	global $documentRoot;

	if ($directShow == "Y")
	{
		$ext_tmp = uofGetFileExtension($file);

		header("Content-type: image/".$ext_tmp);
		readfile($documentRoot.$file);
	}
	else
	{
		header("Location: ".$file);
	}
}

/****************************** END FUNCTIONS ********************************/


if (function_exists("gd_info"))
{
	$arGDInfo = gd_info();
	$bGD2 = ((strpos($arGDInfo['GD Version'], "2.") !== false) ? true : false);
}
else
{
	$bGD2 = false;
}

$resize = IntVal($_GET["resize"]);
$directShow = (($_GET["direct_show"] == "Y") ? "Y" : "N");

$bCorrectFile = True;

$imgname = $_GET["imgname"];
if (strlen($imgname) <= 0)
	$bCorrectFile = False;

if ($bCorrectFile)
{
	$imgname = str_replace("/", "", $imgname);
	$imgname = str_replace("\\", "", $imgname);
	$imgname = preg_replace("'[\\\/]+'", "", $imgname);

	if (($p = strpos($imgname, "\0"))!==false)
		$imgname = substr($imgname, 0, $p);

	$imgname = rtrim($imgname, "\0");

	if (strlen($imgname) <= 0)
		$bCorrectFile = False;
}

if ($bCorrectFile)
{
	$imgname_tmp = preg_replace("/[^a-zA-Z0-1_]+/i", "", $imgname);
	if (strlen($imgname_tmp) <= 0)
		$bCorrectFile = False;
}

if ($bCorrectFile)
{
	$path = $_GET["path"];
	$path = Rel2Abs("/", $path);

	$site = $_GET["site"];
	$site = uofCheckSite($site);
	if (!$site)
		$site = CSite::GetSiteByFullPath($_SERVER["DOCUMENT_ROOT"].$path);

	$documentRoot = CSite::GetSiteDocRoot($site);
	$absPath = $documentRoot.$path;

	$absFilePath = $absPath."/".$imgname;

	if (!file_exists($absFilePath) || !is_file($absFilePath))
		$bCorrectFile = False;
}

if ($bCorrectFile)
{
	$fileAccessPerms = $APPLICATION->GetFileAccessPermission(array($site, $path."/".$imgname));

	if ($fileAccessPerms < "R")
		$bCorrectFile = False;
	else
	{
		$ext_tmp = uofGetFileExtension($imgname);
		if($ext_tmp!='jpg' && $ext_tmp!='jpeg' && $ext_tmp!='gif' && $ext_tmp!='png')
			$bCorrectFile = False;
	}

}


$quality = 75;
$previewFilePath = $documentRoot.BX_PERSONAL_ROOT."/cache_image".$path."/".$resize."/".$imgname;
$previewFileUrl = BX_PERSONAL_ROOT."/cache_image".$path."/".$resize."/".$imgname;

if (!$bCorrectFile)
{
	$imageError = ImageCreate(100, 100);
	$backgroundColor = ImageColorAllocate($imageError, 255, 255, 255);
	ImageString($imageError, 3, 25, 25, "Access", ImageColorAllocate($imageError, 0, 0, 0));
	ImageString($imageError, 3, 25, 45, "denied", ImageColorAllocate($imageError, 0, 0, 0));
	ImagePNG($imageError);
}
else
{
	if (!file_exists($previewFilePath)
		|| filemtime($absPath."/".$imgname) > filemtime($previewFilePath)
		|| !CACHE_PREVIEW_IMG)
	{
		if ($resize > 0)
		{
			$arSize = getImageSize($absPath."/".$imgname);

			$sizeX = $arSize[0];
			$sizeY = $arSize[1];

			if (($sizeX > $sizeY) && ($sizeX > $resize) || ($sizeX <= $sizeY) && ($sizeY > $resize))
			{
				uofCreatePreviewImage($sizeX, $sizeY);
			}
			else
			{
				uofShowImage($path."/".$imgname, $directShow);
				exit;
			}
		}
		else
		{
			uofShowImage($path."/".$imgname, $directShow);
			exit;
		}
	}
	else
	{
		uofShowImage($previewFileUrl, $directShow);
		exit;
	}
}
/**********************************************************************************/

else:

/**********************************************************************************/
$imageError = ImageCreate(100, 100);
$backgroundColor = ImageColorAllocate($imageError, 255, 255, 255);
ImageString($imageError, 3, 25, 25, "Access", ImageColorAllocate($imageError, 0, 0, 0));
ImageString($imageError, 3, 25, 45, "denied", ImageColorAllocate($imageError, 0, 0, 0));
ImagePNG($imageError);
/**********************************************************************************/

endif;

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin_after.php");
?>
