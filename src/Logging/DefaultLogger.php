<?php

declare(strict_types=1);

namespace Upmind\Sdk\Logging;

use Psr\Log\AbstractLogger;
use Stringable;

/**
 * Default logger which sends logs to a stream such as STDERR.
 */
class DefaultLogger extends AbstractLogger
{
    /** @var resource $stream Resource to stream messages to */
    private $stream = STDERR;

    /** @var bool $includeContext Whether or not to include context data in logs */
    private bool $includeContext = false;

    /** @var int $contextJsonOptions JSON options for serializing context data */
    private int $contextJsonOptions = JSON_PRETTY_PRINT;

    /**
     * @param $stream
     * @param bool $includeContext
     * @param int $contextJsonOptions JSON_PRETTY_PRINT|JSON_INVALID_UTF8_SUBSTITUTE
     */
    public function __construct(
        $stream = STDERR,
        bool $includeContext = false,
        int $contextJsonOptions = JSON_PRETTY_PRINT
    )
    {
        $this->stream = $stream;
        $this->includeContext = $includeContext;
        $this->contextJsonOptions = $contextJsonOptions;
    }

    public function log($level, $message, array $context = []): void
    {
        $context = $this->includeContext && !empty($context)
            ? json_encode($context, $this->contextJsonOptions)
            : null;

        fwrite(
            $this->stream,
            sprintf(
                "[%s] %s: %s\n",
                date('Y-m-d H:i:s'),
                strtoupper($level),
                implode("\n", array_filter([$message, $context]))
            )
        );
    }
}
