# HasTimezonedAttributes for Laravel

Automatically adds *_timezoned attributes to your Eloquent models for timestamp fields, based on the user's or application's timezone.
    
## Installation

```
composer require kodventure/has-timezoned-attributes
```

## Usage

Add the trait to any model:

```php
use Kodventure\HasTimezonedAttributes\HasTimezonedAttributes;

class Member extends Model
{
    use HasTimezonedAttributes;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];
}
```

Then access:

```php
$member->created_at_tz;
$member->last_login_at_tz;
```

## Timezone Resolution

- If a user is authenticated, their `timezone` attribute is used.
- If no user is authenticated, the `app.timezone` config value is used.
- You can override the timezone on a per-model basis by adding a `getTimezone()` method to your model.

---

> Thanks to GPT-4.
