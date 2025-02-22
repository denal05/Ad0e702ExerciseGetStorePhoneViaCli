<?php

declare(strict_types=1);

namespace Denal05\Ad0e702ExerciseGetStorePhoneViaCli\Console\Command;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Api\Data\StoreConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GetStorePhoneCommand extends Command
{
    private const PHONE = 'phone';
    protected ScopeConfigInterface $scopeConfig;
    protected StoreManagerInterface $storeManager;
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
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
            $currentWebsite = $this->storeManager->getWebsite()->getName();
            $currentWebsiteCode = $this->storeManager->getWebsite()->getCode();

            $currentGroup = $this->storeManager->getGroup()->getName();
            $currentGroupCode = $this->storeManager->getGroup()->getCode();

            $currentStore = $this->storeManager->getStore()->getName();
            $currentStoreCode = $this->storeManager->getStore()->getCode();

            $scopeType = 'store';
            $scopeCode = 'default';

            $storePhone = $this->scopeConfig->getValue(
                'general/store_information/phone',
                // ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                $scopeType,
                $scopeCode
            );

            $output->writeln("<info>The store phone for scope type `$scopeType` and scope code `$scopeCode` is: $storePhone</info>");
            $output->writeln("<info>The current website is: $currentWebsite</info>");
            $output->writeln("<info>The current website code is: $currentWebsiteCode</info>");
            $output->writeln("<info>The current group is: $currentGroup</info>");
            $output->writeln("<info>The current group code is: $currentGroupCode</info>");
            $output->writeln("<info>The current store is: $currentStore</info>");
            $output->writeln("<info>The current store code is: $currentStoreCode</info>");
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
