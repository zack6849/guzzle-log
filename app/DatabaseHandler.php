<?php


namespace App;


use App\Models\ThirdPartyApiRequest;
use App\Models\ThirdPartyApiResponse;
use GuzzleHttp\TransferStats;
use GuzzleLogMiddleware\Handler\HandlerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class DatabaseHandler implements HandlerInterface
{
    public function log(
        LoggerInterface $logger,
        RequestInterface $request,
        ?ResponseInterface $response = null,
        ?Throwable $exception = null,
        ?TransferStats $stats = null,
        array $options = []
    ): void {
        $request_obj = $request;
//        $request_obj = clone $request;
//        $request_obj = $stats->getRequest();
        $req = ThirdPartyApiRequest::create([
            'method' => $request_obj->getMethod(),
            'url' => $request_obj->getUri(),
            'body' => $request_obj->getBody()->getContents(),
            'headers' => json_encode($this->formatHeaders($request_obj->getHeaders())),
        ]);
        //$request->getBody()->rewind();
        
        
        $response_obj = $response;
//            $response_obj = clone $response;
//            $response_obj = $stats->getResponse();
        if ($response_obj !== null) {
            ThirdPartyApiResponse::create([
                'third_party_api_request_id' => $req->id,
                'status' => $response_obj->getStatusCode(),
                'body' => $response_obj->getBody()->getContents(),
                'headers' => json_encode($this->formatHeaders($response_obj->getHeaders())),
            ]);
            //$response->getBody()->rewind();
        }
        return;
    }

    function formatHeaders($headers)
    {
        $real_headers = [];
        foreach ($headers as $header_name => $values) {
            $real_headers[$header_name] = implode(",", $values);
        }
        return $real_headers;
    }
}
