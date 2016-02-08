<?php
/**
 * @class AddOperator
 * @namespace \Calculator\operators
 */

namespace Calculator\operators;


use Calculator\BaseOperator;

class AddOperator extends BaseOperator{
    /** @inheritDoc */
    protected $priority = 1;
    /** @inheritDoc */
    protected $assoc = self::LEFT_ASSOC;
    /** @inheritDoc */
    protected $argCnt = [1,2];
    /** @inheritDoc */
    protected $literal ='+';

    /**
     * @param array $arguments
     *
     * @return number
     */
    protected function process( array $arguments ) {
        if ( 1 == count($arguments) ) {
            return $arguments[0];
        }

        return $arguments[0] + $arguments[1];
    }
} 