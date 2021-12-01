<?php

declare(strict_types=1);

namespace Wnx\Sends\Support;

use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionProperty;
use Swift_Message;
use Wnx\Sends\Contracts\HasSends;

trait StoreMailables
{
    protected function storeClassName(): self
    {
        $this->withSwiftMessage(function (Swift_Message $message) {
            $message->getHeaders()->addTextHeader(config('sends.headers.mail_class'), encrypt(self::class));
        });

        return $this;
    }

    /**
     * @param array<HasSends> $models
     * @return StoreMailables
     * @throws \ReflectionException
     */
    protected function associateWith(array $models = []): static
    {
        $models = collect($models)
            ->when(count($models) === 0, function (Collection $collection) {
                $publicPropertyWithHasSends = collect((new ReflectionClass($this))
                    ->getProperties(ReflectionProperty::IS_PUBLIC))
                    ->map(fn (ReflectionProperty $property) => $property->getValue($this))
                    ->filter(fn ($propertyValue) => $propertyValue instanceof HasSends);

                return $collection->merge($publicPropertyWithHasSends);
            })
            ->unique()
            ->map(fn (HasSends $model) => [
                'model' => get_class($model),
                'id' => $model->id,
            ])
            ->toJson();

        $this->withSwiftMessage(function (Swift_Message $message) use ($models) {
            $message->getHeaders()->addTextHeader(config('sends.headers.models'), encrypt($models));
        });

        return $this;
    }
}
