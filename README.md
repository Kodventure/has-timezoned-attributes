# HasTimezonedAttributes for Laravel

Automatically adds *_tz attributes to your Eloquent models for timestamp fields, based on the user's or application's timezone.
    
## Installation

```
composer require kodventure/has-timezoned-attributes
```

## Usage

Add the trait to any model:

```php
use Kodventure\HasTimezonedAttributes\HasTimezonedAttributes;

class User extends Model
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
$user->created_at_tz;
$user->last_login_at_tz;
$user->email_verified_at_tz;
$user->getEmailVerifiedAtTzAttribute();
$user->getEmailVerifiedAtTz();
```

## Timezone Resolution

- If a user is authenticated, their `timezone` attribute is used.
- If no user is authenticated, the `app.timezone` config value is used.
- You can override the timezone on a per-model basis by adding a `getTimezone()` method to your model.

---

> Thanks to GPT-4.
