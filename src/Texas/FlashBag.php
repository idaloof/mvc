<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Texas;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * FlashBag flash message container.
 *
 * @author Drak <drak@zikula.org>
 */
class FlashBag implements FlashBagInterface
{
    private string $name = 'flashes';

    /**
     * @var array<mixed> $flashes
     */
    private array $flashes = [];
    private string $storageKey;

    /**
     * @param string $storageKey The key used to store flashes in the session
     */
    public function __construct(string $storageKey = '_symfony_flashes')
    {
        $this->storageKey = $storageKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets name of object.
     *
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     *
     * @param array<mixed> $flashes
     *
     * @return void
     */
    public function initialize(array &$flashes): void
    {
        $this->flashes = &$flashes;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $type
     * @param mixed $message
     *
     * @return void
     */
    public function add(string $type, mixed $message): void
    {
        $this->flashes[$type][] = $message;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $type
     * @param array<mixed> $default
     *
     * @return array<mixed>
     */
    public function peek(string $type, array $default = []): array
    {
        return $this->has($type) ? $this->flashes[$type] : $default;
    }

    /**
     * {@inheritdoc}
     *
     * @return array<mixed>
     */
    public function peekAll(): array
    {
        return $this->flashes;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $type
     * @param array<mixed> $default
     *
     * @return array<mixed>
     */
    public function get(string $type, array $default = []): array
    {
        if (!$this->has($type)) {
            return $default;
        }

        $return = $this->flashes[$type];

        unset($this->flashes[$type]);

        return $return;
    }

    /**
     * {@inheritdoc}
     *
     * @return array<mixed>
     */
    public function all(): array
    {
        $return = $this->peekAll();
        $this->flashes = [];

        return $return;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $type
     * @param string|array<mixed> $messages
     *
     * @return void
     */
    public function set(string $type, string|array $messages): void
    {
        $this->flashes[$type] = (array) $messages;
    }

    /**
     * {@inheritdoc}
     *
     * @param array<mixed> $messages
     *
     * @return void
     */
    public function setAll(array $messages): void
    {
        $this->flashes = $messages;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $type
     *
     * @return bool
     */
    public function has(string $type): bool
    {
        return \array_key_exists($type, $this->flashes) && $this->flashes[$type];
    }

    /**
     * {@inheritdoc}
     *
     * @return array<mixed>
     */
    public function keys(): array
    {
        return array_keys($this->flashes);
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getStorageKey(): string
    {
        return $this->storageKey;
    }

    /**
     * {@inheritdoc}
     *
     * @return mixed
     */
    public function clear(): mixed
    {
        return $this->all();
    }
}
