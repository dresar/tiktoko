<?php

namespace Tikstore\Shippings;

abstract class Base
{
    abstract public function origin_id();

    abstract public function origin_name($query = false);

    abstract public function method($destination, $weight = 100);

    abstract public function validate_cost($id);
}
