<?php
namespace Ksb\Helper\Extension;

use Bootstrap\Utility\Math;
use Slim\Views\TwigExtension;
use Twig\TwigFunction;

class KsbTwigExtension extends TwigExtension
{
    /**
     * Đổi sang hệ số 62
     *
     * @param [type] $number
     * @return void
     */
    public function toBase($number)
    {
        return Math::toBase($number);
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function getFunctions()
    {
        return [
            new TwigFunction("urlFor", [$this, "urlFor"]),
            new TwigFunction("fullUrlFor", [$this, "fullUrlFor"]),
            new TwigFunction("isCurrentUrl", [$this, "isCurrentUrl"]),
            new TwigFunction("currentUrl", [$this, "getCurrentUrl"]),
            new TwigFunction("getUri", [$this, "getUri"]),
            new TwigFunction("toBase", [$this, "toBase"]),
        ];
    }
}
