<?php
/**
 * @class MulOperator
 * @namespace \Calculator\operators
 */

namespace Calculator\operators;


use Calculator\BaseOperator;

class DivOperator extends BaseOperator{
    /** @inheritDoc */
    protected $priority = 2;
    /** @inheritDoc */
    protected $assoc = self::LEFT_ASSOC;
    /** @inheritDoc */
    protected $argCnt = 2;
    /** @inheritDoc */
    protected $literal ='/';

    /**
     * @param array $arguments
     *
     * @throws \Exception
     * @return number
     */
    protected function process( array $arguments ) {
        if (0 == $arguments[1]) {
            throw new \Calculator\CalcException('Zero division!');
        }

        return $arguments[0] / $arguments[1];
    }
} 