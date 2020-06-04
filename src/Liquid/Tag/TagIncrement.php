<?php

/**
 * This file is part of the Liquid package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package Liquid
 */

namespace Liquid\Tag;

use Liquid\AbstractTag;
use Liquid\Context;
use Liquid\LiquidCompiler;
use Liquid\LiquidException;
use Liquid\Regexp;
use Liquid\Tokens\TagToken;

/**
 * Used to increment a counter into a template
 *
 * Example:
 *
 *     {% increment value %}
 *
 * @author Viorel Dram
 */
class TagIncrement extends AbstractTag
{
    /**
     * Name of the variable to increment
     *
     * @var string
     */
    private $toIncrement;

    /**
     * Constructor
     *
     * @param string $markup
     *
     * @param array|null $tokens
     * @param TagToken $token
     * @param LiquidCompiler|null $compiler
     * @throws LiquidException
     */
    public function __construct($markup, array &$tokens, $token, LiquidCompiler $compiler = null)
    {
        $syntax = new Regexp('/(' . $compiler::VARIABLE_NAME . ')/');

        if ($syntax->match($markup)) {
            $this->toIncrement = $syntax->matches[0];
        } else {
            throw new LiquidException("Syntax Error in 'increment' - Valid syntax: increment [var]");
        }

        parent::__construct(null, $tokens, $token, $compiler);
    }

    /**
     * Renders the tag
     *
     * @param Context $context
     *
     * @return string|void
     * @throws LiquidException
     */
    public function render(Context $context)
    {
        // If the value is not set in the environment check to see if it
        // exists in the context, and if not set it to -1
        if (!isset($context->environments[0][$this->toIncrement])) {
            // check for a context value
            $from_context = $context->get($this->toIncrement);

            // we already have a value in the context
            $context->environments[0][$this->toIncrement] = (null !== $from_context) ? $from_context : -1;
        }

        // Increment the value
        $context->environments[0][$this->toIncrement]++;
    }
}
