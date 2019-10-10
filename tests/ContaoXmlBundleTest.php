<?php

/*
 * This file is part of Contao XML Table Bundle
 *
 * (c) JL
 *
 * @license LGPL-3.0-or-later
 */

namespace Jl\ContaoXmlTableBundle\Tests;

use Jl\ContaoXmlTableBundle\ContaoXmlTableBundle;
use PHPUnit\Framework\TestCase;

class ContaoXmlTableBundleTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new ContaoXmlTableBundle();

        $this->assertInstanceOf('Jl\ContaoXmlTableBundle\ContaoXmlTableBundle', $bundle);
    }
}
