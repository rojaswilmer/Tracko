<?php
namespace Tracko\CoreBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * Class CreateUploadsFoldersCommand
 *
 * @author Tobias Nyholm
 *
 *
 */
class CreateUploadsFoldersCommand extends ContainerAwareCommand
{
    /**
     * Init command
     */
    protected function configure()
    {
        $this->setName('alex:folders:create')
            ->addOption('clear', null, InputOption::VALUE_NONE, 'If set - deletes all current folder contents.')
            ->setDescription('Create folders in the web/uploads');
    }

    /**
     *
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = getcwd() . '/web/uploads';

        $folders = array(
            '', //create the base path
            '/profileimages',
        );

        /**
         * Create each folder if not exists. If exists and clear is set to true => delete all folder contents.
         *
         */
        foreach ($folders as $folder) {
            if (!is_dir($path . $folder)) {
                mkdir($path . $folder);
            } else {
                if ($input->getOption('clear') and $folder != "") {
                    @array_map('unlink', glob($path . $folder . '/*'));
                }
            }
        }
    }
}
