<?php

namespace Tracko\CoreBundle\Twig;

use Tracko\CoreBundle\Services\IdTranslationService;

/**
 * Class NumberExtension
 *
 * A better extension than the number_format
 */
class NumberExtension extends \Twig_Extension
{

    protected $idTranslationService;

    /**
     * @param IdTranslationService $idTranslationService
     */
    public function __construct(IdTranslationService $idTranslationService)
    {
        $this->idTranslationService = $idTranslationService;
    }

    /**
     * @inherit
     *
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('number', array($this, 'number')),
            new \Twig_SimpleFilter('toPublicId', array($this->idTranslationService, 'convertToPublicId')),

        );
    }

    /**
     * This is the swedish number format standard...
     *
     * @param float $number
     * @param int $decimals
     * @param string $decPoint
     * @param string $thousandsSep
     *
     * @return float
     */
    public function number($number, $decimals = 2, $decPoint = '.', $thousandsSep = ' ')
    {
        //TODO: Check with the request what locale it is and change the default parameters according to that..
        return number_format($number, $decimals, $decPoint, $thousandsSep);
    }

    /**
     * @inherit
     *
     * @return string
     */
    public function getName()
    {
        return 'number_extension';
    }
}