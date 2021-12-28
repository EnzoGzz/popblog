<?php

namespace Utils\TwigExtension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MessageExtension extends AbstractExtension
{
    public function errors():array
    {
        $errors = $_SESSION["errors"] ?? [];
        unset($_SESSION["errors"]);
        return $errors;
    }

    public function messages():array
    {
        $messages = $_SESSION["messages"] ?? [];
        unset($_SESSION["messages"]);
        return $messages;
    }

    public function has(array $array):bool
    {
        return (bool)$array;
    }

    public function getFunctions(): array
    {
        return[
            new TwigFunction("errors",[$this,"errors"]),
            new TwigFunction("messages",[$this,"messages"]),
            new TwigFunction("has",[$this,"has"]),
        ];
    }
}