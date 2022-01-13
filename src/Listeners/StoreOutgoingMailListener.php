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
        return config('sends.send_model')::create([
            'uuid' => $this->getSendUuid($event),
            'mail_class' => $this->getMailClassHeaderValue($event),
            'subject' => $event->message->getSubject(),
            'content' => $this->getContent($event),
            'from' => $this->getAddressesValue($event->message->getFrom()),
            'reply_to' => $this->getAddressesValue($event->message->getReplyTo()),
            'to' => $this->getAddressesValue($event->message->getTo()),
            'cc' => $this->getAddressesValue($event->message->getCc()),
            'bcc' =>$this->getAddressesValue($event->message->getBcc()),
            'sent_at' => now(),
        ]);
    }

    protected function getSendUuid(MessageSent $event): ?string
    {
        if (! $event->message->getHeaders()->has(config('sends.headers.send_uuid'))) {
            return null;
        }

        $headerValue = $event->message->getHeaders()->get(config('sends.headers.send_uuid'));

        if (is_null($headerValue)) {
            return null;
        }

        return $headerValue->getBodyAsString();
    }

    protected function getMailClassHeaderValue(MessageSent $event): ?string
    {
        if (! $event->message->getHeaders()->has(config('sends.headers.mail_class'))) {
            return null;
        }

        $headerValue = $event->message->getHeaders()->get(config('sends.headers.mail_class'));

        if (is_null($headerValue)) {
            return null;
        }

        return decrypt($headerValue->getBodyAsString());
    }

    /**
     * @throws \JsonException
     */
    protected function attachModelsToSendModel(MessageSent $event, Send $send): void
    {
        $this->getModels($event)
            ->each(fn (HasSends $model) => $model->sends()->attach($send));
    }

    /**
     * @throws \JsonException
     */
    protected function getModels(MessageSent $event): Collection
    {
        if (! $event->message->getHeaders()->has(config('sends.headers.models'))) {
            return collect([]);
        }

        $headerValue = $event->message->getHeaders()->get(config('sends.headers.models'));

        if (is_null($headerValue)) {
            return collect([]);
        }

        $models = decrypt($headerValue->getBodyAsString());

        return collect(json_decode($models, true, 512, JSON_THROW_ON_ERROR))
            ->map(function (array $tuple): Model {
                $model = $tuple['model'];
                $id = $tuple['id'];

                return $model::find($id);
            })
            ->filter(fn (Model $model) => (new ReflectionClass($model))->implementsInterface(HasSends::class));
    }

    protected function getContent(MessageSent $event): ?string
    {
        if (config('sends.store_content', false) === false) {
            return null;
        }

        return $event->message->getHtmlBody();
    }

    /**
     * @param array<Address> $address
     * @return Collection|null
     */
    private function getAddressesValue(array $address): ?Collection
    {
        $addresses = collect($address)
            ->flatMap(fn(Address $address) => [$address->getAddress() => $address->getName()]);

        return $addresses->count() > 0 ? $addresses : null;
    }
}
