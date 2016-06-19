<?php namespace NZS\Core;
use Carbon\Carbon;

trait TimelineTrait {
    protected function convertToTimestampObject(Carbon $timestamp) {
        return [
            'month' => $timestamp->format('m'),
            'year' => $timestamp->format('Y'),
            'day' => $timestamp->format('d'),
            'hour' => $timestamp->format('H'),
            'minute' => $timestamp->format('i'),
            'second' => $timestamp->format('s')
        ];
    }
}
