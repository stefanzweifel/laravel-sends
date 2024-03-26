<?php

declare(strict_types=1);

namespace Wnx\Sends\Listeners;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Collection;
use ReflectionClass;
use Symfony\Component\Mime\Address;
use Wnx\Sends\Contracts\HasSends;
use Wnx\Sends\Models\Send;

class StoreOutgoingMailListener
{
    /**
     * @throws \JsonException
     */
    public function handle(MessageSent $event): void
    {
        $send = $this->createSendModel($event);

        $this->attachModelsToSendModel($event, $send);
    }

    protected function createSendModel(MessageSent $event): Send
    {
        /** @var Send $modelClass */
        $modelClass = config('sends.send_model');

        return $modelClass::forceCreate(
            $this->getSendAttributes($event, $this->getDefaultSendAttributes($event))
        );
    }

    protected function getSendAttributes(MessageSent $event, array $defaultAttributes): array
    {
        // Implement this method in your own application to override the attributes stored in the Send Model.
        return $defaultAttributes;
    }

    protected function getDefaultSendAttributes(MessageSent $event): array
    {
        return [
            'uuid' => $this->getSendUuid($event),
            'mail_class' => $this->getMailClassHeaderValue($event),
            'subject' => $event->message->getSubject(),
            'content' => $this->getContent($event),
            'from' => $this->getAddressesValue($event->message->getFrom()),
            'reply_to' => $this->getAddressesValue($event->message->getReplyTo()),
            'to' => $this->getAddressesValue($event->message->getTo()),
            'cc' => $this->getAddressesValue($event->message->getCc()),
            'bcc' => $this->getAddressesValue($event->message->getBcc()),
            'sent_at' => now(),
        ];
    }

    protected function getSendUuid(MessageSent $event): ?string
    {
        /** @var string $sendUuidHeader */
        $sendUuidHeader = config('sends.headers.send_uuid');

        if ($sendUuidHeader === 'Message-ID') {
            return $event->sent->getMessageId();
        }

        if (! $event->message->getHeaders()->has($sendUuidHeader)) {
            return null;
        }

        $headerValue = $event->message->getHeaders()->get($sendUuidHeader);

        if (is_null($headerValue)) {
            return null;
        }

        return $headerValue->getBodyAsString();
    }

    protected function getMailClassHeaderValue(MessageSent $event): ?string
    {
        /** @var string $mailClassHeader */
        $mailClassHeader = config('sends.headers.mail_class');

        if (! $event->message->getHeaders()->has($mailClassHeader)) {
            return null;
        }

        $headerValue = $event->message->getHeaders()->get($mailClassHeader);

        if (is_null($headerValue)) {
            return null;
        }

        /** @phpstan-var string */
        return decrypt($headerValue->getBodyAsString());
    }

    /**
     * @throws \JsonException
     */
    protected function attachModelsToSendModel(MessageSent $event, Send $send): void
    {
        $this->getModels($event)
            /** @phpstan-ignore-next-line  */
            ->each(fn (HasSends $model) => $model->sends()->attach($send));
    }

    /**
     * @throws \JsonException
     */
    protected function getModels(MessageSent $event): Collection
    {
        /** @var string $modelsHeader */
        $modelsHeader = config('sends.headers.models');

        if (! $event->message->getHeaders()->has($modelsHeader)) {
            return collect([]);
        }

        $headerValue = $event->message->getHeaders()->get($modelsHeader);

        if (is_null($headerValue)) {
            return collect([]);
        }

        /** @var string $models */
        $models = decrypt($headerValue->getBodyAsString());

        /** @var array<array<string, mixed>> $modelsArray */
        $modelsArray = json_decode($models, true, 512, JSON_THROW_ON_ERROR);

        return collect($modelsArray)
            ->map(function (array $tuple): Model {
                /** @var Model $model */
                $model = $tuple['model'];
                $id = $tuple['id'];

                /** @phpstan-ignore-next-line  */
                return $model::find($id);
            })
            ->filter(fn (Model $model) => (new ReflectionClass($model))->implementsInterface(HasSends::class));
    }

    protected function getContent(MessageSent $event): ?string
    {
        if (config('sends.store_content', false) === false) {
            return null;
        }

        /** @phpstan-ignore-next-line  */
        return $event->message->getHtmlBody();
    }

    /**
     * @param array<Address> $address
     * @return Collection|null
     */
    protected function getAddressesValue(array $address): ?Collection
    {
        $addresses = collect($address)
            ->flatMap(fn (Address $address) => [$address->getAddress() => $address->getName() === '' ? null : $address->getName()]);

        return $addresses->count() > 0 ? $addresses : null;
    }
}
