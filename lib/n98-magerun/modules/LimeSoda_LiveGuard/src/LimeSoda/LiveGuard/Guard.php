<?php

namespace LimeSoda\LiveGuard;
use N98\Magento\Command\AbstractMagentoCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\OutputInterface;
use WebDriver\Exception;
use N98\Util\Console\Helper\Table\Renderer\RendererFactory;
use Symfony\Component\Console\Input\InputOption;
use LimeSoda\LiveGuard\ErrorCollection;
use N98\Magento\Command\System\CheckCommand;

/**
 * Class Guard
 * @package LimeSoda\LiveGuard
 */
class Guard extends AbstractMagentoCommand
{

    protected static $_tableHeaders = array('Message', 'File');
    const ERROR_MSG = '%s %s Errors(s) found';
    const SUCCESS_MSG = '%s No Errors found';
    const CONFIG_MISSING_MSG = '%s No Configuration found. Please add guards to the configuration.';

    protected function configure()
    {
        $this
            ->setName('ls:liveguard')
            ->setDescription(
                'Helps you to protect your live environment (and others)'
            );
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->detectMagento($output, true);
        if ($this->initMagento()) {

            $config = \Mage::getModel('limesoda_liveguard/config');

            if (!$config->configExists()) {
                $this->printConfigMissing($output);
                return $this;
            }

            $errorCollection = new ErrorCollection();
            foreach ($config->getGuards() as $guard) {

                try {
                    $guard->process();
                }
                catch( \Exception $e ) {
                    $errorCollection->addError($e);
                }
            }

            if ($errorCollection->countErrors()) {
                $this->printErrors($output, $errorCollection);
            } else {
                $this->printSuccess($output);
            }

        }
    }

    /**
     * @param OutputInterface $output
     * @param ErrorCollection $errorCollection
     */
    protected function printErrors(
        OutputInterface $output,
        ErrorCollection $errorCollection
    ) {
        $this->writeSection(
            $output,
            sprintf(
                self::ERROR_MSG,
                \N98\Util\Unicode\Charset::convertInteger(
                    CheckCommand::UNICODE_CROSS_CHAR
                ),
                $errorCollection->countErrors()
            ),
            'bg=red;fg=white'
        );
        $this->printErrorsTable($output, $errorCollection);
    }

    /**
     * @param OutputInterface $output
     * @param ErrorCollection $errorCollection
     */
    protected function printErrorsTable(
        OutputInterface $output,
        ErrorCollection $errorCollection
    ) {

        $table = $this->getHelper('table');
        $table->setHeaders(self::$_tableHeaders);

        foreach ($errorCollection->getErrors() as $error) {

            $row = array(
                $error->getMessage(),
                $error->getFirstTraceFile()
            );

            $table->addRow($row);
        }

        $table->render($output);
    }

    /**
     * @param OutputInterface $output
     */
    protected function printConfigMissing(OutputInterface $output)
    {
        $this->writeSection(
            $output,
            sprintf(
                self::CONFIG_MISSING_MSG,
                \N98\Util\Unicode\Charset::convertInteger(
                    CheckCommand::UNICODE_CROSS_CHAR
                )
            ),
            'bg=blue;fg=white'
        );
    }

    /**
     * @param OutputInterface $output
     */
    protected function printSuccess(OutputInterface $output)
    {
        $this->writeSection(
            $output,
            sprintf(
                self::SUCCESS_MSG,
                \N98\Util\Unicode\Charset::convertInteger(
                    CheckCommand::UNICODE_CHECKMARK_CHAR
                )
            ),
            'bg=green;fg=white'
        );
    }

}
