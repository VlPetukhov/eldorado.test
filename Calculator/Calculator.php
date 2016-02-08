<?php
/**
 * Created by PhpStorm.
 * User: Vladimir
 * Date: 06.02.2016
 * Time: 22:00
 */

namespace Calculator;


class Calculator {

    /**
     * @param $str
     *
     * @throws \Exception
     * @return string
     */
    public function solve( $str ) {
        $numberExpr = '([\d]+[.]?[\d]*)';
        $bracketsExpr = '(\()|(\))';

        $operators = array_map('preg_quote', OperatorsFactory::getTokens());
        $operatorsExpr = '(' . implode(')|(', $operators) . ')';

        $searchExpr = '#' . $numberExpr . '|' . $bracketsExpr . '|' . $operatorsExpr . '#';

        //check input string for unknown tokens
        $tmpStr = $str;
        $tmpStr = trim(preg_replace( $searchExpr, '', $tmpStr));

        try {
            if ( !empty($tmpStr) ) {
                throw new CalcException('Wrong expression.');
            }

            $tokens = [];
            preg_match_all($searchExpr, $str, $tokens);
            $operators = $this->fillWithOperators( $tokens[0] );
            $operators = $this->doReversePolishNotation( $operators );

            return $this->solveRPN($operators);

        } catch(CalcException $ce) {

            return $ce->getMessage();

        } catch ( \Exception $e) {

            return 'Internal error. Try later.';
        }
    }

    /**
     * Replaces tokens in input array for Operators
     * @param array $tokens
     *
     * @return array
     * @throws \Exception
     */
    protected function fillWithOperators( array $tokens) {
        $results = [];

        foreach($tokens as $token) {
            if ( !in_array($token, OperatorsFactory::getTokens()) ) {
                $results[] = $token;
                continue;
            }

            $results[] = OperatorsFactory::getOperator( $token );
        }

        return $results;
    }

    /**
     * Change input infix array to Reverse Polish Notation(postfix)
     *
     * @param array $elements
     *
     * @throws CalcException
     * @return array
     */
    protected function doReversePolishNotation( array $elements ) {
        $result = [];
        $stack = [];

        foreach ($elements as $element) {
            if (is_numeric($element)) {
                $result[] = $element;
                continue;
            }

            if ($element == '(') {
                array_push($stack, $element);
                continue;
            }

            if ($element == ')') {
                $tmp = '';
                while ($tmp <> '(') {

                    if (count($stack) == 0) {
                        throw new CalcException('Expression error.');
                    }

                    $tmp = array_pop($stack);

                    if ($tmp != '(') {
                        $result[] = $tmp;
                    }
                }
                continue;
            }


            if ($element instanceof BaseOperator){
                /** @var BaseOperator $topElement */
                while ( 0 < count($stack) && (($topElement = $stack[count($stack)-1]) instanceof BaseOperator) ) {

                    if ( ($element->getPriority() > $topElement->getPriority()) &&
                          $topElement->getAssoc() == BaseOperator::LEFT_ASSOC
                    ){
                        break;
                    }

                    if ($element->getPriority() >= $topElement->getPriority() &&
                        $topElement->getAssoc() == BaseOperator::RIGHT_ASSOC){
                        break;
                    }

                    $result[] = array_pop($stack);
                }
                array_push($stack, $element);
            }
        }


        foreach (array_reverse($stack) as $element){
            if (!($element instanceof BaseOperator)){
                throw new CalcException('Expression error.');
            }
            $result[] = $element;
        }

        return $result;
    }

    /**
     * @param array $rpn
     *
     * @throws \Exception
     * @return int
     */
    protected function solveRPN( array $rpn ) {
        $stack = [];

        foreach ( $rpn as $operator ) {
            if (is_numeric($operator)) {
                array_push($stack, $operator);
                continue;
            }

            if ( $operator instanceof BaseOperator) {
                $operandsNum = $operator->getArgCnt();

                $operands = [];

                if ( is_integer($operandsNum) ) {
                    for ( $cnt = 1; $cnt <= $operandsNum; $cnt++ ) {

                        $value = array_pop($stack);

                        if ( is_numeric($value) ) {
                            $operands[] = $value;
                        } else {
                            throw new CalcException('Operator "' . $operator->getLiteral() . '" has wrong operands count.');
                        }
                    }
                }

                if (is_array($operandsNum) ) {

                    sort($operandsNum, SORT_NUMERIC);

                    $gotOperands = [];
                    foreach ($operandsNum as $currentNum) {

                        if ($currentNum < count($gotOperands)) {
                            continue;
                        }

                        $value = array_pop($stack);

                        if ( is_numeric($value) ) {
                            $gotOperands[] = $value;
                            continue;
                        }

                        break;
                    }

                    if ( !in_array( count($gotOperands), $operandsNum) ) {
                        throw new CalcException('Operator "' . $operator->getLiteral() . '" has wrong operands count.');
                    }

                    $operands = $gotOperands;
                }

                $operands = array_reverse($operands);

                $result = $operator->doOperation( $operands );

                if ( is_numeric($result) ) {
                    array_push($stack, $result);
                }

                continue;
            }

            throw new \Exception('Unrecognized operator type');
        }

        return $stack[0];
    }
} 