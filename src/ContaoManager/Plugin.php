<?php

/*
 * This file is part of Contao XML Table Bundle.
 *
 * (c) JL
 *
 * @license LGPL-3.0-or-later
 */

namespace Jl\ContaoXmlTableBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Jl\ContaoXmlTableBundle\ContaoXmlTableBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(ContaoXmlTableBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
