<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Webauthn\AttestationStatement\AttestationStatementSupportManager;
use Webauthn\AttestationStatement\NoneAttestationStatementSupport;
use Webauthn\Denormalizer\WebauthnSerializerFactory;
use Webauthn\PublicKeyCredentialCreationOptions;
use Webauthn\PublicKeyCredentialRpEntity;
use Webauthn\PublicKeyCredentialUserEntity;

class PasskeyController extends Controller
{
    public function registerOptions(Request $request)
    {
        $options = new PublicKeyCredentialCreationOptions(
            rp: new PublicKeyCredentialRpEntity(
                name: config('app.name'),
                id: parse_url(config('app.url'), PHP_URL_HOST)
            ),
            user: new PublicKeyCredentialUserEntity(
                name: $request->user()->email,
                id: $request->user()->id,
                displayName: $request->user()->name,
            ),
            challenge: str()->random(),
        );

        return $this->serializeCredentials($options);
    }

    protected function serializeCredentials(PublicKeyCredentialCreationOptions $options)
    {
        $attestationStatementSupportManager = AttestationStatementSupportManager::create();
        $attestationStatementSupportManager->add(NoneAttestationStatementSupport::create());
        $factory = new WebauthnSerializerFactory($attestationStatementSupportManager);
        $serializer = $factory->create();

        return $serializer->serialize($options, format: 'json');
    }
}
