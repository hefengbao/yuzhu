<?php

namespace App\Filament\Clusters\FMS\CategoryTag\Resources\Tags\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TagInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('category.type')
                    ->label('收支类型')
                    ->badge(),
                TextEntry::make('category.name')
                    ->label('分类'),
                TextEntry::make('name')
                    ->label('名称'),
            ]);
    }
}
