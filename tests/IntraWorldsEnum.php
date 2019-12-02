<?php

declare(strict_types=1);

namespace IW;

/**
 * @method static mixed KIEV()
 */
class IntraWorldsEnum extends Enum
{
    public const PILSEN   = true;
    public const MUNICH   = ['foo' => ['bar']];
    public const NEW_YORK = 42;
    public const TAMPA    = 1 / 3;
}
