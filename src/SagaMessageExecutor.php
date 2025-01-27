<?php

/**
 * Saga pattern implementation module.
 *
 * @author  Maksim Masiukevich <dev@async-php.com>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 1);

namespace ServiceBus\Sagas\Module;

use function Amp\call;
use Amp\Promise;
use ServiceBus\Common\Context\ServiceBusContext;
use ServiceBus\Common\MessageExecutor\MessageExecutor;
use ServiceBus\Common\MessageHandler\MessageHandler;

/**
 *
 */
final class SagaMessageExecutor implements MessageExecutor
{
    /** @var MessageHandler */
    private $messageHandler;

    public function __construct(MessageHandler $messageHandler)
    {
        $this->messageHandler = $messageHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(object $message, ServiceBusContext $context): Promise
    {
        /** @psalm-suppress InvalidArgument */
        return call($this->messageHandler->closure, $message, $context);
    }
}
