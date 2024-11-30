<?php

namespace Isidea\HealthNotifier\Infrastructure\Console\Commands;

use Illuminate\Console\Command;
use Isidea\HealthNotifier\Contracts\NotifierFactory;

/**
 * Отправить уведомления о состоянии доступности приложения.
 */
class SendAppHealthNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'health-notifier:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Отправить уведомления о состоянии доступности приложения';

    /**
     * @var NotifierFactory
     */
    protected NotifierFactory $factory;

    /**
     * @param NotifierFactory $notifiers
     */
    public function __construct(NotifierFactory $factory)
    {
        parent::__construct();
        $this->factory = $factory;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach ($this->factory->get()->getNotifiers() as $notifier) {
            $notifier->notify();
        }
    }
}
