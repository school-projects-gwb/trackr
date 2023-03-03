<?php


namespace App\Filters;


class FullTextFilter
{
    public static function apply($collection, $fieldName, $searchTerms) {
        return $searchTerms == '' ? $collection : $collection->whereFullText($fieldName, $searchTerms);
    }
}
