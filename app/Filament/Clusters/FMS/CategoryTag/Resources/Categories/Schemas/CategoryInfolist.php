<?php

namespace App\Filament\Clusters\FMS\CategoryTag\Resources\Categories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('type')
                    ->label('收支类型')
                    ->badge(),
                TextEntry::make('name')
                    ->label('名称')
            ]);
    }
}
