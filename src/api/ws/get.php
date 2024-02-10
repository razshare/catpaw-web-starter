<?php
use Amp\Http\Server\Request;
use Amp\Http\Server\Response;
use Amp\Websocket\Server\WebsocketClientHandler;
use Amp\Websocket\WebsocketClient;
use CatPaw\Core\State;
use CatPaw\Web\Attributes\IgnoreOpenApi;
use function CatPaw\Web\websocket;
use Revolt\EventLoop;

return 
    #[IgnoreOpenApi]
    static fn (Request $request) => websocket($request, new class implements WebsocketClientHandler {
        public function handleClient(WebsocketClient $client, Request $request, Response $response): void {
            $state = new class extends State {
                public string $name = '...';
            };

            $state->run(function() use ($client, $state) {
                $client->sendText("hello $state->name");
            });

            EventLoop::delay(2, function() use ($state) {
                $state->name = 'world!';
            });

            foreach ($client as $message) {
                echo $message.PHP_EOL;
            }
        }
    });