<?php

namespace Tracko\CoreBundle\Tests\Services;

usTrackoex\CoreBundle\Services\IdTranslationService;

/**
 * Class IdTranslationServiceTest
 *
 *
 */
class IdTranslationServiceTest extends \PHPUnit_Framework_TestCase
{

    protected $service;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->service = new IdTranslationService();
    }

    /**
     * test the convertion between public and private id
     */
    public function testIdConvertion()
    {
        $id = 2;
        $publicId = $this->service->convertToPublicId($id);
        $this->assertEquals($id, $this->service->convertToPrivateId($publicId));

        $id = 291402;
        $publicId = $this->service->convertToPublicId($id);
        $this->assertEquals($id, $this->service->convertToPrivateId($publicId));

        $id = 100000000000;
        $publicId = $this->service->convertToPublicId($id);
        $this->assertEquals($id, $this->service->convertToPrivateId($publicId));
    }

    /**
     * Test the public id convertion
     */
    public function testPublicId()
    {
        $id = 2160;
        $publicId = $this->service->convertToPublicId($id);
        $this->assertEquals('794da-xgwtlkzs', $publicId);

        $id = 'ad';
        $publicId = $this->service->convertToPublicId($id);
        $this->assertNull($publicId);

        $id = '';
        $publicId = $this->service->convertToPublicId($id);
        $this->assertNull($publicId);

        $id = -1;
        $publicId = $this->service->convertToPublicId($id);
        $this->assertNull($publicId);

        $id = null;
        $publicId = $this->service->convertToPublicId($id);
        $this->assertNull($publicId);
    }

    /**
     * Test the private id convertion
     */
    public function testPrivateId()
    {
        $publicId = '794da-xgwtlkzs';
        $this->assertEquals(2160, $this->service->convertToPrivateId($publicId));

        $publicId = 'ad';
        $this->assertNull($this->service->convertToPrivateId($publicId));

        $publicId = '';
        $this->assertNull($this->service->convertToPrivateId($publicId));

        $publicId = -1;
        $this->assertNull($this->service->convertToPrivateId($publicId));

        $publicId = null;
        $this->assertNull($this->service->convertToPrivateId($publicId));
    }

    /**
     * @group speedtest
     */
    public function testSpeed()
    {
        $turns = 10000;
        for ($i = 0; $i < $turns; $i++) {
            $ids[$i] = rand(1, 10000);
        }

        $start = microtime(true);
        /**
         * Convert to public id
         */
        for ($i = 0; $i < $turns; $i++) {
            $publicId[$i] = $this->service->convertToPublicId($ids[$i]);
        }

        /**
         * Convert to private id
         */
        for ($i = 0; $i < $turns; $i++) {
            $privateId[$i] = $this->service->convertToPrivateId($publicId[$i]);
        }
        $stop = microtime(true);

        /**
         * Make sure we are doing things right
         */
        for ($i = 0; $i < $turns; $i++) {
            $this->assertEquals($ids[$i], $privateId[$i]);
        }

        $mseconds = ($stop - $start) * 1000;
        echo "IdTranslationService ran in $mseconds milliseconds";
    }
}
