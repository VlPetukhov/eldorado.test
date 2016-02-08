<?php
/**
 * @class BaseOperator
 * @namespace \Calculator
 */

namespace Calculator;


abstract class BaseOperator {
    //Associativity constants
    const LEFT_ASSOC = 'leftAssoc';
    const RIGHT_ASSOC = 'rightAssoc';

    /** @var  integer Operation priority 0 - lowest */
    protected $priority;
    /** @var  string Operation associativity */
    protected $assoc;
    /** @var  integer|array Count of operands */
    protected $argCnt;
    /** @var  string Regular expression for literal searching */
    protected $literal;

    public function __construct() {
        if ( !(is_integer( $this->argCnt ) && 0 <= $this->argCnt ) && !is_array( $this->argCnt ) ) {
            throw new \Exception('Class ' . get_called_class() . ' configuration error. Wrong operation argument count.');
        }

        if ( static::LEFT_ASSOC != $this->assoc && static::RIGHT_ASSOC != $this->assoc) {
            throw new \Exception('Class ' . get_called_class() . ' configuration error. Wrong operation association.');
        }

        if ( !is_integer( $this->priority ) || 0 > $this->priority) {
            throw new \Exception('Class ' . get_called_class() . ' configuration error. Wrong operation priority.');
        }

        if ( !is_string( $this->literal) ) {
            throw new \Exception('Class ' . get_called_class() . ' configuration error. Wrong operation literal.');
        }
    }

    /**
     * Function that perform operation
     * @return mixed
     */
    abstract protected function process( array $arguments );

    /**
     * @param array $arguments
     *
     * @throws \Exception
     * @return mixed
     */
    public function doOperation( array $arguments ) {
        $cnt = count($arguments);

        if ( is_integer( $this->argCnt ) && ($cnt != $this->argCnt) ||
             is_array( $this->argCnt ) && !in_array( $cnt, $this->argCnt)
        ) {
            throw new CalcException('Operator "' . $this->literal . '" error. Wrong operand quantity.');
        }

        return $this->process( $arguments );
    }

    /**
     * @return string
     */
    public function getAssoc() {
        return $this->assoc;
    }

    /**
     * @return integer
     */
    public function getArgCnt() {
        return $this->argCnt;
    }

    /**
     * @return integer
     */
    public function getLiteral() {
        return $this->literal;
    }

    /**
     * @return integer
     */
    public function getPriority() {
        return $this->priority;
    }
} 