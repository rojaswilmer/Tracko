<?php

namespace Tracko\CoreBundle\Services;

/**
 * This class encrypts a string of any length to a other string
 * This is a symmetric encryption. TEXT=encode(decode(TEXT))
 */
class StringEncryptionService
{
    private $strUtils;

    /**
     * Constructor
     *
     * @param StringUtils $strUtils
     */
    public function __construct(StringService $strUtils)
    {
        $this->strUtils = $strUtils;
    }

    /**
     * Generates a nice has that hides the email
     */

    /**
     * Generates a cipher from a $str
     *
     * @param string $str can be any text string
     *
     * @return string
     */
    public function encode($str)
    {
        return str_rot13(
            $this->strUtils->generateRandomString(5) .
            base64_encode($str) .
            $this->strUtils->generateRandomString(4)
        );
    }

    /**
     * Return the email form our nice hash
     */

    /**
     * Returns a text string from a given $cipher
     *
     * @param string $cipher
     *
     * @return string
     */
    public function decode($cipher)
    {
        $str = str_rot13($cipher);

        //remove garbage before and after the base64_encoded string
        $str = substr($str, 5, -4);

        return base64_decode($str);
    }
}