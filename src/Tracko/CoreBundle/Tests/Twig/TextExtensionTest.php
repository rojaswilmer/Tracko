<?php

namespace Tracko\CoreBundle\Tests;

use Tracko\CoreBundle\Twig\TextExtension;

/**
 * Class TextExtensionTest
 *
 * Test the MoreTwigExtention
 */
class TextExtensionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test short texts
     */
    public function testMoreFilterSortText()
    {
        $more = new TextExtension();
        $this->assertEquals('test', $more->moreFilter('test', 10));
    }

    /**
     * Test to see if truncate works
     */
    public function testMoreFilterLongText()
    {
        $more = new TextExtension();
        $this->assertEquals('test56...', $more->moreFilter('test567890test', 6));
    }

    /**
     * test when the texts is exact the length required
     */
    public function testMoreFilterExactText()
    {
        $more = new TextExtension();
        $this->assertEquals('test56', $more->moreFilter('test56', 6));
    }

    /**
     * Test if it trims spaces
     */
    public function testSuperTrimSpaces()
    {
        $class = new TextExtension();

        $this->assertEquals('test', $class->superTrim(' test'));
        $this->assertEquals('case', $class->superTrim('case '));
        $this->assertEquals('one', $class->superTrim('on e'));
        $this->assertEquals('long', $class->superTrim('l   on g'));
    }

    /**
     * Test if it trims tabs
     */
    public function testSuperTrimTabs()
    {
        $class = new TextExtension();

        $this->assertEquals('test', $class->superTrim('	test'));
        $this->assertEquals('case', $class->superTrim('case	'));
        $this->assertEquals('two', $class->superTrim('tw		o'));
        $this->assertEquals('two', $class->superTrim("tw\to"));
    }

    /**
     * Test if it trims new lines
     */
    public function testSuperTrimNewline()
    {
        $class = new TextExtension();

        $this->assertEquals(
            'test',
            $class->superTrim(
                '
                        test'
            )
        );

        $this->assertEquals(
            'case',
            $class->superTrim(
                'case
                        '
            )
        );

        $this->assertEquals(
            'one',
            $class->superTrim(
                'on
                         e'
            )
        );

        $this->assertEquals(
            'long',
            $class->superTrim(
                'l

                          on
                          g'
            )
        );

        $this->assertEquals('more', $class->superTrim("m\n\nor\ne"));
    }
}
