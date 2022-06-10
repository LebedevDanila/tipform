<?php namespace App\Libraries\Utils;

class SimpleImage
{
    var $image;
    var $image_type;
    var $filename;

    function load($filename)
    {
        $this->filename   = $filename;
        $image_info       = getimagesize($filename);
        $this->image_type = $image_info[2];
        if ($this->image_type === IMAGETYPE_JPEG)
        {
            $this->image = imagecreatefromjpeg($filename);
        }
        elseif ($this->image_type === IMAGETYPE_GIF)
        {
            $this->image = imagecreatefromgif($filename);
        }
        elseif ($this->image_type === IMAGETYPE_PNG)
        {
            $this->image = imagecreatefrompng($filename);
        }
    }
    function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 100, $permissions = 0755)
    {
        if ($image_type === IMAGETYPE_JPEG)
        {
            imagejpeg($this->image, $filename, $compression);
        }
        elseif ($image_type === IMAGETYPE_GIF)
        {
            imagegif($this->image, $filename);
        }
        elseif ($image_type === IMAGETYPE_PNG)
        {
            imagepng($this->image, $filename);
        }
        if ($permissions !== null)
        {
            chmod($filename, $permissions);
        }
    }
    function output($image_type = IMAGETYPE_JPEG)
    {
        if ($image_type === IMAGETYPE_JPEG)
        {
            imagejpeg($this->image);
        }
        elseif ($image_type === IMAGETYPE_GIF)
        {
            imagegif($this->image);
        }
        elseif ($image_type === IMAGETYPE_PNG)
        {
            imagepng($this->image);
        }
    }
    function getWidth()
    {
        return imagesx($this->image);
    }
    function getHeight()
    {
        return imagesy($this->image);
    }
    function resizeToHeight($height)
    {
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width, $height);
    }
    function resizeToWidth($width)
    {
        if ($width < $this->getWidth())
        {
            //return false;
        }
        $ratio  = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width, $height);
    }
    function scale($scale)
    {
        $width  = $this->getWidth() * $scale / 100;
        $height = $this->getheight() * $scale / 100;
        $this->resize($width, $height);
    }
    function resize($width, $height)
    {
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }

    function crop($x_o, $y_o, $w_o, $h_o)
    {
        if (($x_o < 0) || ($y_o < 0) || ($w_o < 0) || ($h_o < 0))
        {
            return false;
        }
        list($w_i, $h_i, $type) = getimagesize($this->filename);
        if ($x_o + $w_o > $w_i)
        {
            $w_o = $w_i - $x_o;
        }
        if ($y_o + $h_o > $h_i)
        {
            $h_o = $h_i - $y_o;
        }
        chmod($this->filename, 0755);
        $img_o = imagecreatetruecolor($w_o, $h_o);
        imagecopy($img_o, $this->image, 0, 0, $x_o, $y_o, $w_o, $h_o);
        chmod($this->filename, 0755);
        $this->image = $img_o;
    }
}
