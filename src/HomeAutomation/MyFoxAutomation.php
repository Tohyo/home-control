<?php

namespace App\HomeAutomation;

use App\Dto\Shutter;
use App\Dto\Token;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class MyFoxAutomation implements AutomationInterface
{
    private ?Token $token = null;

    public function __construct(
        private HttpClientInterface $client,
        #[Autowire(env: 'string:MYFOX_USERNAME')] private readonly string $username,
        #[Autowire(env: 'string:MYFOX_PASSWORD')] private readonly string $password,
        #[Autowire(env: 'string:MYFOX_SECRET')] private readonly string $secret,
        #[Autowire(env: 'string:MYFOX_CLIENT_ID')] private readonly string $clientId,
        #[Autowire(param: 'MYFOX_API')] private readonly string $api,
    ) {
    }

    public function listShutters(): array
    {
        $shutters = [];

        $sites = $this->client->request(
            'GET',
             $this->api.'/v2/client/site/items?access_token='.$this->getToken()?->accessToken,
        )->toArray();

        foreach ($sites["payload"]["items"] as $site) {
            $shutterApiResponse = $this->client->request(
                'GET',
                $this->api.'/v2/site/'.$site["siteId"].'/device/shutter/items?access_token='.$this->getToken()?->accessToken,
            )->toArray();

            foreach ($shutterApiResponse["payload"]["items"] as $shutter) {
                $shutters[] = new Shutter($shutter["deviceId"], $shutter["label"], $site["siteId"]);
            }
        }

        return $shutters;
    }

    public function closeShutter(Shutter $shutter): void
    {
        $this->client->request(
            'POST',
            $this->api.'/v2/site/'.$shutter->siteId.'/device/'.$shutter->id.'/shutter/close?access_token='.$this->getToken()?->accessToken,
        );
    }

    public function openShutter(Shutter $shutter): void
    {
        $this->client->request(
            'POST',
            $this->api.'/v2/site/'.$shutter->siteId.'/device/'.$shutter->id.'/shutter/open?access_token='.$this->getToken()?->accessToken,
        );
    }

    private function getToken(): Token
    {
        if ($this->token) {
            return $this->token;
        }

        $response = $this->client->request(
            'POST',
            $this->api.'/oauth2/token',
            [
                'body' => [
                    'grant_type' => 'password',
                    'username' => $this->username,
                    'password' => $this->password,
                    'client_secret' => $this->secret,
                    'client_id' => $this->clientId, 
                ]
            ]
        )->toArray();

        $this->token = new Token(
            $response['access_token'],
            $response['refresh_token'],
        );

        return $this->token;
    }
}
