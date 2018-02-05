<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpDynamicCast\TypeException;
use function PhpDynamicCast\cast;

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
