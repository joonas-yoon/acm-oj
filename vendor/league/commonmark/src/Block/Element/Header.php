<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * Original code based on the CommonMark JS reference parser (http://bitly.com/commonmark-js)
 *  - (c) John MacFarlane
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\CommonMark\Block\Element;

use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;

class Header extends AbstractBlock implements InlineContainer
{
    /**
     * @var int
     */
    protected $level;

    /**
     * @param int    $level
     * @param string $contents
     */
    public function __construct($level, $contents)
    {
        parent::__construct();

        $this->level = $level;
        $this->addLine($contents);
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    public function finalize(ContextInterface $context, $endLineNumber)
    {
        parent::finalize($context, $endLineNumber);

        $this->finalStringContents = implode("\n", $this->getStrings());
    }

    /**
     * Returns true if this block can contain the given block as a child node
     *
     * @param AbstractBlock $block
     *
     * @return bool
     */
    public function canContain(AbstractBlock $block)
    {
        return false;
    }

    /**
     * Returns true if block type can accept lines of text
     *
     * @return bool
     */
    public function acceptsLines()
    {
        return true;
    }

    /**
     * Whether this is a code block
     *
     * @return bool
     */
    public function isCode()
    {
        return false;
    }

    public function matchesNextLine(Cursor $cursor)
    {
        return false;
    }

    /**
     * @param ContextInterface $context
     * @param Cursor           $cursor
     */
    public function handleRemainingContents(ContextInterface $context, Cursor $cursor)
    {
        // nothing to do; we already added the contents.
    }
}
