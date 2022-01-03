<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\PaginatorInterface;
use App\Service\StatsHelper;
use Exception;
use Traversable;

class DailyStatsPaginator implements PaginatorInterface, \IteratorAggregate
{
    private $dailyStatsIterator;
    private StatsHelper $statsHelper;

    public function __construct(StatsHelper $statsHelper)
    {
        $this->statsHelper = $statsHelper;
    }

    public function getLastPage(): float
    {
        return 2;
    }

    public function getTotalItems(): float
    {
        return 25;
    }

    public function getCurrentPage(): float
    {
        return 1;
    }

    public function getItemsPerPage(): float
    {
        return 10;
    }

    public function count()
    {
        return iterator_count($this->getIterator());
    }

    public function getIterator()
    {
        if($this->dailyStatsIterator === null){
            $this->dailyStatsIterator = new \ArrayIterator($this->statsHelper->fetchMany());
        }

        return $this->dailyStatsIterator;
    }
}