<?php declare(strict_types=1);

namespace Automation\Core\Http;

interface ResponseInterface
{
    /**
     * Add a header to be send with the current response.
     * 
     * @param  string  $key
     * @param  string  $value
     * @return void
     */
    public function add_header(string $key, string $value): void;

    /**
     * Get all the headers that will be sent with the current response.
     * 
     * @return array
     */
    public function headers(): array;

    /**
     * Send the response.
     * 
     * @return void
     */
    public function send(): void;

    /**
     * Set content manually.
     * 
     * @param  string  $content
     * 
     * @return void
     */
    public function setContent(string $content): void;
}