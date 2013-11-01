<?php
namespace Tracko\CoreBundle\Services;

/**
 * Class StringService
 *
 * @author Tobias Nyholm
 *
 *
 */
class StringService
{
    /**
     * Generate random string
     *
     * @param int $length
     * @param bool $allowNumbers
     *
     * @return string
     */
    public function generateRandomString($length = 10, $allowNumbers = true)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = '';
        $max = strlen($characters) - 1;
        $min = $allowNumbers ? 0 : 10;

        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand($min, $max)];
        }

        return $string;
    }
}
