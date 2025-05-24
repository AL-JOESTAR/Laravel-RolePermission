<?php

namespace App\Filament\Admin\Resources\TestResource\Pages;

use App\Filament\Admin\Resources\TestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTest extends CreateRecord
{
    protected static string $resource = TestResource::class;
}
