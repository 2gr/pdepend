<?php
/**
 * This file is part of PDepend.
 *
 * PHP Version 5
 *
 * Copyright (c) 2008-2015, Manuel Pichler <mapi@pdepend.org>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @copyright 2008-2015 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

namespace PDepend\Source\AST;

/**
 * Test case for the {@link \PDepend\Source\AST\ASTForUpdate} class.
 *
 * @copyright 2008-2015 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 *
 * @covers \PDepend\Source\Language\PHP\AbstractPHPParser
 * @covers \PDepend\Source\AST\ASTForUpdate
 * @group unittest
 */
class ASTForUpdateTest extends \PDepend\Source\AST\ASTNodeTest
{
    /**
     * testForUpdateHasExpectedStartLine
     *
     * @return void
     */
    public function testForUpdateHasExpectedStartLine()
    {
        $init = $this->_getFirstForUpdateInFunction(__METHOD__);
        $this->assertEquals(4, $init->getStartLine());
    }

    /**
     * testForUpdateHasExpectedStartColumn
     *
     * @return void
     */
    public function testForUpdateHasExpectedStartColumn()
    {
        $init = $this->_getFirstForUpdateInFunction(__METHOD__);
        $this->assertEquals(36, $init->getStartColumn());
    }

    /**
     * testForUpdateHasExpectedEndLine
     *
     * @return void
     */
    public function testForUpdateHasExpectedEndLine()
    {
        $init = $this->_getFirstForUpdateInFunction(__METHOD__);
        $this->assertEquals(4, $init->getEndLine());
    }

    /**
     * testForUpdateHasExpectedEndColumn
     *
     * @return void
     */
    public function testForUpdateHasExpectedEndColumn()
    {
        $init = $this->_getFirstForUpdateInFunction(__METHOD__);
        $this->assertEquals(45, $init->getEndColumn());
    }

    /**
     * Returns a node instance for the currently executed test case.
     *
     * @param string $testCase Name of the calling test case.
     *
     * @return \PDepend\Source\AST\ASTForUpdate
     */
    private function _getFirstForUpdateInFunction($testCase)
    {
        return $this->getFirstNodeOfTypeInFunction(
            $testCase, 'PDepend\\Source\\AST\\ASTForUpdate'
        );
    }
}
