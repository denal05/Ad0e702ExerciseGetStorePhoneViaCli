<?php

declare(strict_types=1);

namespace Denal05\Ad0e702ExerciseGetStorePhoneViaCli\Console\Command;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Api\Data\StoreConfigInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GetStorePhoneCommand extends Command
{
    private const PHONE = 'phone';
    protected ScopeConfigInterface $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('get:store:phone');
        $this->setDescription("This command will return the store phone in Admin > Stores > Configuration");
        $this->addOption(
            self::PHONE,
            null,
            InputOption::VALUE_REQUIRED,
            'Name'
        );

        parent::configure();
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $exitCode = 0;

        // $output->writeln('<info>Success message.</info>');
        // $output->writeln('<comment>Some comment.</comment>');

        try {
            $storePhone = $this->scopeConfig->getValue(
                'general/store_information/phone'
            );
            $output->writeln("<info>The store phone is: $storePhone</info>");
        } catch (LocalizedException $e) {
            $output->writeln(sprintf(
                '<error>%s</error>',
                $e->getMessage()
            ));
            $exitCode = 1;
        }

        return $exitCode;
    }
}
