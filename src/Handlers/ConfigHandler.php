<?php

namespace Mafftor\LaravelFileManager\Handlers;

class ConfigHandler
{
    public function userField()
    {
        return auth()->id();
    }
}
