<?php
namespace HtSettingsModule\Entity;

class IdAwareParameter extends Parameter implements IdAwareParameterInterface
{
    use IdAwareParameterTrait;
}
