<?php

namespace Lune\Http;

class Response
{
    protected int $status = 200;
    protected array $headers = [];
    protected string | null $content = null;

    // -------------------------------------------------------------

    public function status(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    // -------------------------------------------------------------

    public function headers(): array
    {
        return $this->headers;
    }

    public function setHeader(string $header, string | int $value): self
    {
        $this->headers[strtolower($header)] = $value;
        return $this;
    }

    public function removeHeader(string $header): self
    {
        unset($this->headers[strtolower($header)]);
        return $this;
    }

    // -------------------------------------------------------------

    public function content(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    // -------------------------------------------------------------

    public function setContentType(string $value): self
    {
        $this->setHeader('Content-Type', $value);
        return $this;
    }

    public function prepare(): self
    {
        if (is_null($this->content)) {
            $this->removeHeader('Content-Type');
            $this->removeHeader('Content-Length');
        } else {
            $this->setHeader('Content-Length', strlen($this->content));
        }
        return $this;
    }

    // ----------------------------------------------------------

    public static function json(array $data, int $status = 200): self
    {
        return (new self())
            ->setStatus($status)
            ->setContentType('application/json')
            ->setContent(json_encode($data));
    }

    public static function text(string $text, int $status = 200): self
    {
        return (new self())
            ->setStatus($status)
            ->setContentType('text/plain')
            ->setContent($text);
    }

    public static function redirect(string $url): self
    {
        return (new self())
            ->setStatus(302)
            ->setHeader('Location', $url);
    }
}
