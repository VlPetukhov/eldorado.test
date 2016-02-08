<?php
/**
 * @class PowOperator
 * @namespace \Calculator\operators
 */

namespace Calculator\operators;


use Calculator\BaseOperator;

class PowOperator extends BaseOperator{
    /** @inheritDoc */
    protected $priority = 3;
    /** @inheritDoc */
    protected $assoc = self::RIGHT_ASSOC;
    /** @inheritDoc */
    protected $argCnt = 2;
    /** @inheritDoc */
    protected $literal ='^';

    /**
     * @param array $arguments
     *
     * @return number
     */
    protected function process( array $arguments ) {

        return pow($arguments[0], $arguments[1]);
    }
} 