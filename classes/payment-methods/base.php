<?php

namespace Tikstore\PaymentMethods;

abstract class Base
{
    /**
     * is_enable
     *
     * @var bool
     */
    protected $is_enable = false;

    /**
     * payment ID
     * 
     * @var string
     */
    protected $id;

    /**
     * payment name
     * 
     * @var string
     */
    protected $name;

    /**
     * description
     *
     * @var string
     */
    protected $description;

    /**
     * payment icon url
     * 
     * @var string
     */
    protected $icon;

    /**
     * is support unique number pricing ?
     * 
     * @var bool
     */
    protected $use_unique_number_pricing = false;

    /**
     * instruction
     *
     * @var string
     */
    protected $instruction = '';

    /**
     * is_enable
     *
     * @return bool
     */
    public function is_enable()
    {
        return $this->is_enable;
    }
    /**
     * id
     *
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * name
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * description
     *
     * @return string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * icon
     *
     * @return string
     */
    public function icon()
    {
        return $this->icon;
    }

    /**
     * unique_number_pricing
     *
     * @return bool
     */
    public function use_unique_number_pricing()
    {
        return $this->use_unique_number_pricing;
    }

    /**
     * instruction
     *
     * @return string
     */
    public function instruction()
    {
        return $this->instruction;
    }

    /**
     * action
     *
     * @return string
     */
    abstract public function action();

    abstract public function action_wa();
}
