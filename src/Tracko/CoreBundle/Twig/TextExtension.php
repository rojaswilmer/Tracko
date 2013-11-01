<?php

namespace Tracko\CoreBundle\Twig;

/**
 * Class MoreExtension
 *
 * A twig extension to truncate strings
 */
class TextExtension extends \Twig_Extension
{
    /**
     * @inherit
     *
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('more', array($this, 'moreFilter')),
            new \Twig_SimpleFilter('supertrim', array($this, 'superTrim')),

        );
    }

    /**
     * Make sure the string is only $length long
     *
     * @param string $text
     * @param int $length
     *
     * @return string
     */
    public function moreFilter($text, $length = 16)
    {
        if (strlen($text) <= $length) {
            return $text;
        } else {
            return mb_substr($text, 0, $length, 'UTF-8') . '...';
        }
    }

    /**
     * Removes all spaces
     *
     * @param string $text
     *
     * @return mixed
     */
    public function superTrim($text)
    {
        return preg_replace('|\s+|', '', $text);
    }

    /**
     * @inherit
     *
     * @return string
     */
    public function getName()
    {
        return 'text_extension';
    }
}