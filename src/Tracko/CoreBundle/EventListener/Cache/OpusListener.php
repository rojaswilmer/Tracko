<?php

namespace Tracko\CoreBundle\EventListener\Cache;

use Tracko\CoreBundle\Services\CacheService;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class OpusListener
 *
 * @author Tobias Nyholm
 *
 */
class OpusListener
{
    /**
     * @var \Tracko\CoreBundle\Services\CacheService cacheService
     *
     *
     */
    protected $cacheService;

    /**
     * @param CacheService $cacheService
     */
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Purge opus cache
     *
     * @param Event $event
     *
     */
    public function purgeOpusCache(Event $event)
    {
        /*
        $opus=$event->getOpus();
        $this->cacheService->invalidateRoute('_public_opus_show', array(
            'opus_id'=>$opus->getId(),
            'opus_slug'=>$opus->getHeadlineSlug()
        ));
        */
    }
}