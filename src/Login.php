<?php

declare(strict_types=1);

namespace Expando\TransladoPackage;

use Expando\TransladoPackage\Exceptions\LoginException;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;

class Login
{
    private int $clientId;
    private string $clientSecret;
    private string $redirectUri;
    private array $scopes = [];
    private string $transladoUrl;

    public function __construct(int $clientId, string $clientSecret, string $redirectUrl, string $transladoUrl = 'https://app.transla.do')
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUrl;
        $this->transladoUrl = $transladoUrl;
    }

    /**
     * @param string $scope
     */
    public function addScope(string $scope)
    {
        $this->scopes[] = $scope;
    }

    /**
     * @return array|null
     * @throws LoginException
     */
    public function getToken(): ?array
    {
        $provider = new GenericProvider([
            'clientId'                => $this->clientId,    // The client ID assigned to you by the provider
            'clientSecret'            => $this->clientSecret,    // The client password assigned to you by the provider
            'redirectUri'             => $this->redirectUri,
            'urlAuthorize'            => $this->transladoUrl . '/oauth/authorize',
            'urlAccessToken'          => $this->transladoUrl . '/oauth/token',
            'urlResourceOwnerDetails' => '',
        ]);

        $code = $_GET['code'] ?? null;

        if (($_GET['error'] ?? null) !== null) {
            throw new LoginException($_GET['error'] . ' - ' . ($_GET['error_description'] ?? null));
        } elseif ($code === null) {
            $authorizationUrl = $provider->getAuthorizationUrl([
                'scope' => implode(' ', $this->scopes)
            ]);
            $_SESSION['oauth2state'] = $provider->getState();
            header('Location: ' . $authorizationUrl);
            exit;
        } elseif (empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])) {
            if (isset($_SESSION['oauth2state'])) {
                unset($_SESSION['oauth2state']);
            }
            throw new LoginException('Invalid state');
        }

        try {
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);
            return $accessToken->jsonSerialize();

        } catch (IdentityProviderException $e) {
            throw new LoginException($e->getMessage());
        }
    }
}