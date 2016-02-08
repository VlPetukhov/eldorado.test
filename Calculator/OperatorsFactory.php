<?php
/**
 * @class OperatorFactory
 * @namespace \Calculator
 */

namespace Calculator;


class OperatorsFactory {

    /**
     * Allowed operators list
     * @var array
     */
    private static $allowedOperators = [
        '+' => 'AddOperator',
        '-' => 'SubOperator',
        '*' => 'MulOperator',
        '/' => 'DivOperator',
        '^' => 'PowOperator',
    ];

    /**
     * @return array
     */
    public static function getTokens() {
        return array_keys(static::$allowedOperators);
    }

    public static function getOperator( $token ) {
        if ( !in_array( $token, static::getTokens())) {
            throw new \Exception('OperatorFactory error. Unknown token "' . $token . '".');
        }

        $className = '\\Calculator\\operators\\' . static::$allowedOperators[$token];

        if ( !class_exists( $className )) {
            throw new \Exception('OperatorFactory error. Operator "' . $className . '" not found.');
        }

        $operator = new $className();

        if ( ! $operator instanceof \Calculator\BaseOperator) {
            throw new \Exception('OperatorFactory error. Operator "' . $className . '" should be inherited from "BaseOperator" class.');
        }

        return $operator;
    }

} 