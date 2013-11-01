<?php
namespace Tracko\CoreBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Command\DoctrineCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DatabaseFullReloadCommand
 *
 * @author Tobias Nyholm
 *
 *
 */
class DatabaseFullReloadCommand extends DoctrineCommand
{
    /**
     * Init the command
     */
    protected function configure()
    {
        $this->setName('alex:database:fullreload')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Has to be set to run the operation')
            ->setDescription('Drop, create, load fixtures.');
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
        if (!$input->getOption('force')) {
            $output->writeln('<info>Notice: --force not set. Aborting.</info>');

            return;
        }

        if (!$input->getOption('no-interaction')) {
            $dialog = $this->getHelperSet()->get('dialog');
            if (!$dialog->askConfirmation(
                $output,
                '<question>Continue with this action? It will permanently delete all current database data. [y/n]</question>',
                false
            )
            ) {
                $output->writeln('<info>Reload aborted.</info>');

                return;
            }
        }

        $output->writeln('<info>Dropping database...</info>');
        $this->dropDatabase($output);
        $output->writeln('<info>Reloading acl database...</info>');
        $this->reloadAcl($output);
        $output->writeln('<info>Creating default database...</info>');
        $this->createDatabase($output);

        $output->writeln('<info>Clearing uploads folder.</info>');
        $this->clearUploadsFolders($output);

        //without this it will crash..
        $connection = $this->getDoctrineConnection('default');
        $connection->close();

        $output->writeln('<info>Creating schema...</info>');
        $this->createSchema($output);
        $output->writeln('<info>Loading fixtures...</info>');
        $this->loadFixtures($output);

        $output->writeln('<info>Operation completed.</info>');
    }

    /**
     *
     *
     * @param OutputInterface $output
     *
     * @return int
     */
    private function clearUploadsFolders(OutputInterface $output)
    {
        $command = $this->getApplication()->find('alex:folders:create');
        $arguments = array(
            'command' => 'alex:folders:create',
            '--clear' => true,
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
    private function dropDatabase(OutputInterface $output)
    {
        $command = $this->getApplication()->find('doctrine:database:drop');
        $arguments = array(
            'command' => 'doctrine:database:drop',
            '--force' => true,
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
    private function createDatabase(OutputInterface $output)
    {
        $command = $this->getApplication()->find('doctrine:database:create');
        $arguments = array(
            'command' => 'doctrine:database:create',
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
    private function createSchema(OutputInterface $output)
    {
        $command = $this->getApplication()->find('doctrine:schema:create');
        $arguments = array(
            'command' => 'doctrine:schema:create',
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
    private function loadFixtures(OutputInterface $output)
    {
        $command = $this->getApplication()->find('doctrine:fixtures:load');
        $arguments = array(
            'command' => 'doctrine:fixtures:load',
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
    private function reloadAcl(OutputInterface $output)
    {
        $command = $this->getApplication()->find('alex:database:aclreload');
        $arguments = array(
            'command' => 'alex:database:aclreload',
            '--force' => true,
        );
        $subInput = new ArrayInput($arguments);

        return $command->run($subInput, $output);
    }
}
