<?php

namespace Tracko\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author tobias
 */
class YesNoType extends AbstractType
{
    /**
     * Build a radio form
     *
     * @param OptionsResolverInterface $resolver
     *
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'choices' => array(
                    '1' => 'word.yes',
                    '0' => 'word.no',
                ),
                'expanded' => true,
                'multiple' => false,
                'empty_value' => false,

            )
        );
    }

    /**
     * Who's your daddy?
     *
     *
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * The name of the form
     *
     *
     * @return string
     */
    public function getName()
    {
        return 'yesno';
    }
}