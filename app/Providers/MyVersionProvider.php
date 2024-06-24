<?php

namespace App\Providers;

use Awcodes\FilamentVersions\Providers\Contracts\VersionProvider;

class MyVersionProvider implements VersionProvider
{
    public function getName(): string
    {
        return 'CRM';
    }

    public function getVersion(): string
    {
        return '1.0.0';
    }
}
