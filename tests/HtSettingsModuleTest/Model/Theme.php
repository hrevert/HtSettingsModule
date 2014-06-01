<?php
namespace HtSettingsModuleTest\Model;

class Theme
{
    protected $fontSize;

    protected $fontColor;

    public function setFontSize($fontSize)
    {
        $this->fontSize = $fontSize;
    }

    public function getFontSize()
    {
        return $this->fontSize;
    }

    public function setFontColor($fontColor)
    {
        $this->fontColor = $fontColor;
    }

    public function getFontColor()
    {
        return $this->fontColor;
    }
}
