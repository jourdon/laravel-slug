<?php
namespace Jourdon\Slug;
use Illuminate\Support\Facades\Facade;
class Slug extends Facade
{
    /**
     * Get the binding in the IoC container.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Slug';
    }
}