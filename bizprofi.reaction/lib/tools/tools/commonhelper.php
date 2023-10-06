<?

namespace Bizprofi\Reaction\Tools;

class CommonHelper
{
    public function writeLog($message = null, $data = null): bool
    {
        $allowLogging = false;
        if($_GET['test'] == 1){
            $allowLogging = true;
        }

        if(!$allowLogging){
            return false;
        }

        $fileFullPath = '../../../logs/';
        //self::logCleaner($fileFullPath);
        $fileFullPath .= date('Y').'/'.date('m').'/';
        $result = false;

        if(empty($message)){
            return $result;
        }

        if(!file_exists($fileFullPath)){
            if (!mkdir($fileFullPath, 0775, true)) {
                return $result;
            }
        }

        $fileFullPath .= date('dmy').'_log';

        $fp = null;
        try {
            $fp = fopen($fileFullPath, 'a');
            if($fp == false){
                return $result;
            }
        } catch (Exception $e) {
            return $result;
        }

        if(!$fp){
            return $result;
        }
        
        $result = true;
        fwrite($fp, '//----------'.date('d.m.Y H:i:s').PHP_EOL);
        if(!empty($message)){
            if(is_string($message)){
                fwrite($fp, $message.PHP_EOL);
            } else {
                fwrite($fp, print_r($message, true).PHP_EOL);
            }
        }

        if(!empty($data) || $data === 0){
            fwrite($fp, print_r($data, true).PHP_EOL);
        }
        
        fclose($fp);
        return $result;
    }
}
