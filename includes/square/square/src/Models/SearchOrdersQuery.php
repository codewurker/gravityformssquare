<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Contains query criteria for the search.
 */
class SearchOrdersQuery implements \JsonSerializable
{
    /**
     * @var SearchOrdersFilter|null
     */
    private $filter;

    /**
     * @var SearchOrdersSort|null
     */
    private $sort;

    /**
     * Returns Filter.
     *
     * Filtering criteria to use for a SearchOrders request. Multiple filters
     * will be ANDed together.
     */
    public function getFilter(): ?SearchOrdersFilter
    {
        return $this->filter;
    }

    /**
     * Sets Filter.
     *
     * Filtering criteria to use for a SearchOrders request. Multiple filters
     * will be ANDed together.
     *
     * @maps filter
     */
    public function setFilter(?SearchOrdersFilter $filter): void
    {
        $this->filter = $filter;
    }

    /**
     * Returns Sort.
     *
     * Sorting criteria for a SearchOrders request. Results can only be sorted
     * by a timestamp field.
     */
    public function getSort(): ?SearchOrdersSort
    {
        return $this->sort;
    }

    /**
     * Sets Sort.
     *
     * Sorting criteria for a SearchOrders request. Results can only be sorted
     * by a timestamp field.
     *
     * @maps sort
     */
    public function setSort(?SearchOrdersSort $sort): void
    {
        $this->sort = $sort;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['filter'] = $this->filter;
        $json['sort']   = $this->sort;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
