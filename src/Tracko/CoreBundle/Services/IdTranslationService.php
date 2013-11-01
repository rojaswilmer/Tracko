<?php

namespace Tracko\CoreBundle\Services;

/**
 * This service translates a private id back and forth to a public id.
 *
 *
 */
class IdTranslationService
{

    protected $charMap = array(
        0 => 'kzs',
        1 => 'w',
        2 => 'xg',
        3 => 'nu',
        4 => 'i',
        5 => 'crby',
        6 => 'tl',
        7 => 'j',
        8 => 'pqd',
        9 => 'vh',
    );

    /**
     * This function generates a string that represent a public id.
     * With a 32 char id it will become quite unguessable
     *
     * @param integer $id
     *
     * @return null|string  null if the input is messed up
     */
    public function convertToPublicId($id)
    {
        if (is_object($id)) {
            if (method_exists($id, 'getId')) {
                $id = $id->getId();
            }
        }

        if ($id == null || $id == '' || $id <= 0) {
            return null;
        }

        $hash = $this->getHash($id);
        $strId = str_replace(array_keys($this->charMap), $this->charMap, $id);

        return $hash . '-' . $strId;
    }

    /**
     * Convert a public api into  a private one
     *
     * @param string $publicId
     *
     * @return int|null if id is invalid
     */
    public function convertToPrivateId($publicId)
    {
        if ($publicId == null || $publicId == '') {
            return null;
        }

        try {
            list($hash, $id) = explode("-", $publicId);
        } catch (\Exception $e) {
            return null;
        }
        $id = str_replace($this->charMap, array_keys($this->charMap), $id);

        if ($hash == $this->getHash($id)) {
            //success!
            return $id;
        }

        return null;
    }

    /**
     * Returns a hash string
     *
     * @param integer $the
     *
     * @return string
     */
    protected function getHash($the)
    {
        return substr(md5('jabba' . $the . 'hut'), 5, 5);
    }
}