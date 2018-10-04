<?php namespace Pckg\Htmlbuilder\Element\Pckg;

use Pckg\Htmlbuilder\Element\Select;

class PckgSelect extends Select
{

    protected $tag = 'pckg-select';

    public function __construct()
    {
        parent::__construct();

        $this->a(':initial-multiple', 'false');
        $this->a(':with-empty', 'false');
    }

    public function addOptions($options = [])
    {
        $this->a(':initial-options', json_encode($options));

        return $this;
    }

}