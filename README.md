# PhpDynamicCast

You can cast value dynamically with helper function.

Type is a primitive, class, or closure.

```php
<?php
use function PhpDynamicCast\cast;
use PhpDynamicCast\TypeException;

cast(1, 'bool'); // true

cast(1, function ($v) {
    return '@' . $v;
});
// '@1'

class Text
{
    public $val;

    public function __construct($val)
    {
        $this->val = $val;
    }
}

$text = cast('hi', Text::class);
$text->val; // 'hi'

try {
    cast(0, 'undefined type');
} catch (TypeException $e) {
}
```

**primitive type**

+ bool/boolean
+ int/integer
+ float
+ string
