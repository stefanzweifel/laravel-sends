<?php

declare(strict_types=1);

namespace Wnx\Sends\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionProperty;
use Symfony\Component\Mime\Email;
use Wnx\Sends\Contracts\HasSends;
use Wnx\Sends\Header;

trait StoreMailables
{
    public function storeClassName(): self
    {
        $this->withSymfonyMessage(function (Email $message) {
            $header = $this->getMailClassHeader();

            $message->getHeaders()->addTextHeader($header->getName(), $header->getValue());
        });

        return $this;
    }

    public function getMailClassHeader(): Header
    {
        return new Header(
            name: config('sends.headers.mail_class'),
            value: encrypt(static::class)
        );
    }

    /**
     * @param array<HasSends>|HasSends $models
     * @return StoreMailables
     */
    public function associateWith(array|HasSends $models = []): static
    {
        $models = $models instanceof HasSends ? func_get_args() : $models;

        $this->withSymfonyMessage(function (Email $message) use ($models) {
            $message->getHeaders()->addTextHeader(
                config('sends.headers.models'),
                encrypt($this->getCollectionOfAssociatedModels($models)->toJson())
            );
        });

        return $this;
    }

    /**
     * @param array<Model> $models
     * @return Collection
     * @throws \ReflectionException
     */
    private function getCollectionOfAssociatedModels(array $models): Collection
    {
        return collect($models)
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
                'id' => $model->getKey(),
            ]);
    }

    /**
     * @param array<HasSends>|HasSends $models
     * @return Header
     * @throws \ReflectionException
     */
    public function getMailModelsHeader(array|HasSends $models = []): Header
    {
        $models = $models instanceof HasSends ? func_get_args() : $models;

        return new Header(
            name: config('sends.headers.models'),
            value: encrypt($this->getCollectionOfAssociatedModels($models)->toJson()),
        );
    }
}
