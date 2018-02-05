# PhpDynamicCast

You can cast value dynamically with helper function.

Type is a primitive, class, or closure.

```php
<?php
// example/index.php
require __DIR__ . '/vendor/autoload.php';

use function PhpCastDesign\cast;
use PhpCastDesign\TypeException;

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
    
    public static function fromBool($val)
    {
        return new self($val ? 'on' : 'off');
    }
}

$text = cast('hi', Text::class);
$text->val; // 'hi'

$text = cast(true, Text::class . '::fromBool');
$text->val; // 'yes'

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
