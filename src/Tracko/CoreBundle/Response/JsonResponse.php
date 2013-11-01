<?php

namespace Tracko\CoreBundle\Response;

use Symfony\Component\HttpFoundation\JsonResponse as BaseResponse;

/**
 * Class JsonResponse
 *
 * @author Tobias Nyholm
 *
 */
class JsonResponse extends BaseResponse
{
    /**
     * @param mixed $data
     * @param int $status
     * @param array $headers
     */
    public function __construct($data = null, $status = 200, $headers = array())
    {
        if (null === $data) {
            $data = new \ArrayObject();
        }

        if (!isset($data['status'])) {
            $data['status'] = $status;
        }

        parent::__construct($data, 200, $headers);
    }
}