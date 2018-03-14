<?php
/**
 * Created by PhpStorm.
 * User: Roy
 * Date: 14/03/2018
 * Time: 11:14
 */

class Uploader
{
    public Static $THUMB_LOC="media/thumbnail/";
    public Static $VIDEO_LOC="media/video/";
    public static function upload($file, $folder){
        $p=pathinfo($file["name"]);
        $filename=$p["filename"];
        $num=0;
        $fileExt=$p["extension"];
        while(file_exists($folder.$filename.$num.$fileExt)){
            $num++;
        }
        $newFile=$folder.$filename.$num.$fileExt;
        if(move_uploaded_file($file["tmp_name"], $newFile)){
            return $filename.$num.$fileExt;
        }else{
            return "";
        }
    }
    public static function checkImage($file){
        return true;
    }
    public static function checkVideo($file){
        return true;
    }
}