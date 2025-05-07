<?php

declare(strict_types=1);

namespace App\UseCases\Link;

use App\Models\Link;
use Carbon\Carbon;

class CreateLinkUseCase
{
    public function handle(array $data): void
    {
        $data = $this->addExpiresAtIfNeeded($data);

        $link = new Link;
        $link->fill($data);
        $link->save();
    }

    public function addExpiresAtIfNeeded(array $data): array
    {
        if (!isset($data['expires_at']) || empty($data['expires_at'])) {
            $data['expires_at'] = Carbon::now()->addDays(30)->toDateTimeString();
        }

        return $data;
    }
}