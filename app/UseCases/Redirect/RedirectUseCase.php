<?php

declare(strict_types=1);

namespace App\UseCases\Redirect;

use App\Exceptions\LinkNotAvailableException;
use App\Models\Link;
use Exception;
use Illuminate\Support\Facades\Http;
use Throwable;

class RedirectUseCase
{
    public function handle(string $slug): string
    {
        try{
            $link = Link::where('slug', $slug)->firstOrFail(); 

            $this->checkLinkAvailability($link->url);

            return $link->url; 

        } catch (Throwable $e) {

            return config('redirect.baseRedirectUrl'); 
        }
    }

    public function checkLinkAvailability(string $url): bool
    {
        try {
            $response = Http::get($url);

            if ($response->successful()) { 
                return true;
            } else {
                throw new LinkNotAvailableException();
            }
        } catch (Exception $e) {
            throw new LinkNotAvailableException();
        }
    }
}