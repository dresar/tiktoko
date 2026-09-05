<?php

namespace Tikstore\Notifications;

abstract class Base
{
    abstract public function default_message($event);

    abstract public function sent($receiver, $message);
}
