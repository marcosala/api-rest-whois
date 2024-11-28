<?php
// src/Error/JsonExceptionRenderer.php
namespace App\Error;

use Cake\Error\ExceptionRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Cake\Http\Response;

class JsonExceptionRenderer implements ExceptionRendererInterface
{
    protected $exception;

    public function __construct($exception)
    {
        $this->exception = $exception;
    }

    /**
     * Render the exception and return a response.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function render(): ResponseInterface
    {
        $statusCode = $this->exception->getCode() ?: 500;

        // Prepara la risposta JSON
        $data = [
            'error' => true,
            'message' => $this->exception->getMessage(),
            'code' => $statusCode,
            'trace' => env('DEBUG') ? $this->exception->getTrace() : [],
        ];

        // Crea una risposta HTTP con il JSON
        $response = new Response(['type' => 'application/json']);
        return $response->withStatus($statusCode)->withStringBody(json_encode($data));
    }

    /**
     * Write the response to the output buffer.
     *
     * @param \Psr\Http\Message\ResponseInterface $response The response to write.
     * @return void
     */
    public function write(ResponseInterface|string $output): void
    {
        if ($output instanceof ResponseInterface) {
            // Gestione di un oggetto ResponseInterface
            foreach ($output->getHeaders() as $header => $values) {
                foreach ($values as $value) {
                    header(sprintf('%s: %s', $header, $value), false);
                }
            }
            http_response_code($output->getStatusCode());
            echo $output->getBody();
        } elseif (is_string($output)) {
            // Gestione di una semplice stringa
            echo $output;
        }
    }
}

