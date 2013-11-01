<?php

namespace Tracko\CoreBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Converts a public ID to a private one
 *
 */
class PublicIdConverter implements ParamConverterInterface
{

    protected $idTranslationService;

    /**
     * @param var $idTranslationService
     */
    public function __construct($idTranslationService)
    {
        $this->idTranslationService = $idTranslationService;
    }

    /**
     * Change the public id to a private one
     *
     * @param Request $request
     * @param ConfigurationInterface $configuration
     *
     * @return bool false to hide the that we changed the id and to allow other param converters to run
     * @throws NotFoundHttpException
     */
    function apply(Request $request, ConfigurationInterface $configuration)
    {
        $name = $configuration->getName();
        $options = $configuration->getOptions();

        //try to fetch an id
        $id = $this->getIdentifier($request, $options, $name);
        if ($id === false) {
            return false;
        }

        $privateId = $this->idTranslationService->convertToPrivateId($id);

        if (!$privateId) {
            throw new NotFoundHttpException('Invalid id given.');
        }
        if (!$name) {
            $name = "id";
        }

        $request->attributes->set($name, $privateId);

        //set this as well to allow doctrine param convert to continue
        if (isset($options['id'])) {
            $request->attributes->set($options['id'], $privateId);
        }

        //hide that we have been doing anything
        return false;
    }

    /**
     *
     *
     * @param ConfigurationInterface $configuration
     *
     * @return bool
     */
    function supports(ConfigurationInterface $configuration)
    {
        if (!$configuration instanceof ParamConverter) {
            return false;
        }

        $options = $configuration->getOptions();

        return isset($options["public_id"]) && $options["public_id"];
    }

    /**
     * Get the identifier
     *
     * @param Request $request
     * @param array $options
     * @param string $name
     *
     * @return array|bool|string
     */
    protected function getIdentifier(Request $request, $options, $name)
    {
        if (isset($options['id'])) {
            if (!is_array($options['id'])) {
                $name = $options['id'];
            } elseif (is_array($options['id'])) {
                $id = array();
                foreach ($options['id'] as $field) {
                    $id[$field] = $request->attributes->get($field);
                }

                return $id;
            }
        }

        if ($request->attributes->has($name)) {
            return $request->attributes->get($name);
        }

        if ($request->attributes->has('id')) {
            return $request->attributes->get('id');
        }

        return false;
    }
}