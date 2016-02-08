<?php
/**
 * @class MulOperator
 * @namespace \Calculator\operators
 */

namespace Calculator\operators;


use Calculator\BaseOperator;

class MulOperator extends BaseOperator{
    /** @inheritDoc */
    protected $priority = 2;
    /** @inheritDoc */
    protected $assoc = self::LEFT_ASSOC;
    /** @inheritDoc */
    protected $argCnt = 2;
    /** @inheritDoc */
    protected $literal ='*';

    /**
     * @param array $arguments
     *
     * @return number
     */
    protected function process( array $arguments ) {

        return $arguments[0] * $arguments[1];
    }
} 