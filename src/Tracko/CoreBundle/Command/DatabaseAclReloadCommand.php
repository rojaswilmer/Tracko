<?php
namespace Tracko\CoreBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Command\DoctrineCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DatabaseAclReloadCommand
 *
 * @author Tobias Nyholm
 *
 *
 */
class DatabaseAclReloadCommand extends DoctrineCommand
{
    /**
     * Init command
     */
    protected function configure()
    {
        $this->setName('alex:database:aclreload')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Has to be set to run the operation')
            ->setDescription('Drop and init acl.');
    }

    /**
     *
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('force')) {
            $output->writeln('<info>Notice: --force not set. Aborting.</info>');

            return;
        }

        $output->writeln('<info>Dropping acl database...</info>');
        $this->dropAclDatabase($output);
        $output->writeln('<info>Creating acl database...</info>');
        $this->createAclDatabase($output);

        //without this it will crash..
        $connection = $this->getDoctrineConnection('acl');
        $connection->close();

        $output->writeln('<info>Init ACL...</info>');
        $this->initAcl($output);
    }

    /**
     *
     *
     * @param OutputInterface $output
     *
     * @return int
     */
    private function dropAclDatabase(OutputInterface $output)
    {
        $command = $this->getApplication()->find('doctrine:database:drop');
        $arguments = array(
            'command' => 'doctrine:database:drop',
            '--force' => true,
            '--connection' => 'acl',
        );
        $subInput = new ArrayInput($arguments);

        return $command->run($subInput, $output);
    }

    /**
     *
     *
     * @param OutputInterface $output
     *
     * @return int
     */
    private function createAclDatabase(OutputInterface $output)
    {
        $command = $this->getApplication()->find('doctrine:database:create');
        $arguments = array(
            'command' => 'doctrine:database:create',
            '--connection' => 'acl',
        );
        $subInput = new ArrayInput($arguments);

        return $command->run($subInput, $output);
    }

    /**
     *
     *
     * @param OutputInterface $output
     *
     * @return int
     */
    private function initAcl(OutputInterface $output)
    {
        $command = $this->getApplication()->find('init:acl');
        $arguments = array(
            'command' => 'init:acl',
        );

        return $command->run(new ArrayInput($arguments), $output);
    }
}
