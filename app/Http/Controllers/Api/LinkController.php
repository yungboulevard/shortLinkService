<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateLinkRequest;
use App\UseCases\Link\CreateLinkUseCase;
use App\UseCases\Redirect\RedirectUseCase;
use Exception;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class LinkController extends Controller
{
    public function __construct(
        private readonly RedirectUseCase $redirectUseCase,
        private readonly CreateLinkUseCase $createLinkUseCase

    ) {}

    public function redirect(string $slug): RedirectResponse
    {
        return redirect($this->redirectUseCase->handle($slug));
    }

    public function create(CreateLinkRequest $request): Response
    {
        try{
            $this->createLinkUseCase->handle($request->validated());

            return response()->json(['success' => true], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
