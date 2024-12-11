<?php

namespace App\Filament\Clusters\Finance;

use Filament\Clusters\Cluster;

class Category extends Cluster
{
    protected static ?string $navigationLabel = '分类';
    protected static ?string $navigationGroup = '财务';
    protected static ?int $navigationSort = 3;
    protected static ?string $clusterBreadcrumb = '分类';
    protected static ?string $slug = 'finance/categories';
}
