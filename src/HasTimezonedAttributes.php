<?php

namespace Kodventure\HasTimezonedAttributes;

use Illuminate\Support\Str;

trait HasTimezonedAttributes
{
    protected static function bootHasTimezonedAttributes()
    {
        static::retrieved(function ($model) {
            foreach ($model->getCasts() as $attribute => $cast) {
                if (Str::endsWith($attribute, '_at') && in_array($cast, ['datetime', 'timestamp'])) {
                    $timezonedAttribute = $attribute . '_tz';

                    if (! in_array($timezonedAttribute, $model->appends ?? [])) {
                        $model->appends[] = $timezonedAttribute;
                    }
                }
            }
        });
    }

    public function __get($key)
    {
        if (Str::endsWith($key, '_tz')) {
            $originalAttribute = Str::beforeLast($key, '_tz');

            if ($this->getAttribute($originalAttribute)) {
                return $this->convertToTimezone($this->getAttribute($originalAttribute));
            }
        }

        return parent::__get($key);
    }

    protected function convertToTimezone($value)
    {
        $timezone = $this->getModelTimezone();

        return $value->copy()->timezone($timezone);
    }

    protected function getModelTimezone()
    {
        if (method_exists($this, 'getTimezone')) {
            return $this->getTimezone();
        }

        if (auth()->check() && auth()->user()->timezone) {
            return auth()->user()->timezone;
        }

        return config('app.timezone', 'UTC');
    }

    public function __call($method, $parameters)
    {
        if (preg_match('/^get(.+)TzAttribute$/', $method, $matches)) {
            $attribute = Str::snake($matches[1]) . '_tz';
            return $this->__get($attribute);
        }
        return parent::__call($method, $parameters);
    }    
}
