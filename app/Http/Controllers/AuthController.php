<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\WalletAuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $walletAuthService;

    public function __construct(WalletAuthService $walletAuthService)
    {
        $this->walletAuthService = $walletAuthService;
    }

    public function challenge(Request $request)
    {
        $challenge = $this->walletAuthService->getChallenge($request->address);
        return ['challenge' => $challenge];
    }

    public function login(Request $request)
    {
        $result = $this->walletAuthService->login($request->address, $request->signature);
        if ($result === null) {
            abort(401);
        }
        return $result;
    }
}
