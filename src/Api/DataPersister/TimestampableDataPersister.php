<?php

declare(strict_types=1);

namespace App\Api\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\DataPersister\ResumableDataPersisterInterface;
use App\Entity\Resource\TimestampableInterface;

final class TimestampableDataPersister implements ContextAwareDataPersisterInterface, ResumableDataPersisterInterface
{

    public function supports($data, array $context = []): bool
    {
        return $data instanceof TimestampableInterface;
    }

    /**
     * @param TimestampableInterface $data
     * @param array $context
     * @return TimestampableInterface
     */
    public function persist($data, array $context = []): TimestampableInterface
    {
        if (null === $data->getCreatedAt()) {
            $data->create();
        } else {
            $data->update();
        }

        return $data;
    }

    public function remove($data, array $context = [])
    {

    }

    public function resumable(array $context = []): bool
    {
        return true;
    }

}
