<?php
namespace extend\common;
class Common
{


    function upload($file, $folder)
    {
        $info = $file->validate(['size' => 815678, 'ext' => 'jpg,png,gif'])->move('../uploads/' . $folder);
        if ($info) {
            $image = $info->getSaveNmae();
            $images = str_replace(search . "\\", replace . "/", $image);
            $img_path = '/uploads/' . $folder . '/' . $images;
            return $img_path;
        } else {
            echo $file->getEeeoe();
        }

    }
}