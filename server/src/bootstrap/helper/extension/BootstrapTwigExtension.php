<?php
namespace Bootstrap\Helper\Extension;

use Slim\Views\TwigExtension;
use Twig\TwigFunction;

class BootstrapTwigExtension extends TwigExtension
{
    /**
     * @inheritDoc
     *
     * @return void
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('urlFor', [$this, 'urlFor']),
            new TwigFunction('fullUrlFor', [$this, 'fullUrlFor']),
            new TwigFunction('isCurrentUrl', [$this, 'isCurrentUrl']),
            new TwigFunction('currentUrl', [$this, 'getCurrentUrl']),
            new TwigFunction('getUri', [$this, 'getUri']),
        ];
    }
}
