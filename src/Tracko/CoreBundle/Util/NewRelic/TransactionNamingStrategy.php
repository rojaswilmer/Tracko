<?php

namespace Tracko\CoreBundle\Util\NewRelic;

use Ekino\Bundle\NewRelicBundle\TransactionNamingStrategy\TransactionNamingStrategyInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Make better names to new relic
 *
 */
class TransactionNamingStrategy implements TransactionNamingStrategyInterface
{
    /**
     * Get a good name for this transaction
     *
     * @param Request $request
     *
     * @return string
     */
    public function getTransactionName(Request $request)
    {
        $name = $request->get('_controller');
        if ($name) {
            /*
             * before: Tracko\User\UserBundle\Controller\SecurityController::loginAction
             * after: Tracko\User\UserBundle\Security::loginAction
             */
            $name = preg_replace('|Controller\\\?|', '', $name);
        } else {
            $name = 'Unknown Symfony controller';
        }

        return $name;
    }
}