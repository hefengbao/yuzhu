<?php

namespace App\Filament\Clusters\FMS;

use Filament\Clusters\Cluster;

class Category extends Cluster
{
    protected static ?string $navigationLabel = '分类';
    protected static string|\UnitEnum|null $navigationGroup = '财务';
    protected static ?int $navigationSort = 3;
    protected static ?string $clusterBreadcrumb = '分类';
    protected static ?string $slug = 'finance/categories';
}
