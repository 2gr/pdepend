<?php
/**
 * This file is part of PHP_Depend.
 *
 * PHP Version 5
 *
 * Copyright (c) 2008-2011, Manuel Pichler <mapi@pdepend.org>.
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
 * @category   PHP
 * @package    PHP_Depend
 * @subpackage Code
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2011 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://www.pdepend.org/
 */

require_once dirname(__FILE__) . '/ASTNodeTest.php';

/**
 * Test case for the {@link PHP_Depend_Code_ASTStaticReference} class.
 *
 * @category   PHP
 * @package    PHP_Depend
 * @subpackage Code
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2011 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 * @link       http://www.pdepend.org/
 *
 * @covers PHP_Depend_Parser
 * @covers PHP_Depend_Code_ASTNode
 * @covers PHP_Depend_Code_ASTStaticReference
 * @group pdepend
 * @group pdepend::ast
 * @group unittest
 */
class PHP_Depend_Code_ASTStaticReferenceTest extends PHP_Depend_Code_ASTNodeTest
{
    /**
     * testGetTypeReturnsInjectedConstructorTargetArgument
     *
     * @return void
     */
    public function testGetTypeReturnsInjectedConstructorTargetArgument()
    {
        $target  = $this->getMockForAbstractClass('PHP_Depend_Code_AbstractClassOrInterface', array(__CLASS__));
        $context = $this->getMock('PHP_Depend_Builder_Context');

        $reference = new PHP_Depend_Code_ASTStaticReference($context, $target);
        self::assertSame($target, $reference->getType());
    }

    /**
     * testGetTypeInvokesBuilderContextWhenTypeInstanceIsNull
     *
     * @return void
     */
    public function testGetTypeInvokesBuilderContextWhenTypeInstanceIsNull()
    {
        $target = $this->getMockForAbstractClass('PHP_Depend_Code_AbstractClassOrInterface', array(__CLASS__));

        $builder = $this->getMock('PHP_Depend_BuilderI');
        $builder->expects($this->once())
            ->method('getClassOrInterface');

        $context = new PHP_Depend_Builder_Context_GlobalStatic($builder);

        $reference = new PHP_Depend_Code_ASTStaticReference($context, $target);
        $reference = unserialize(serialize($reference));
        $reference->getType();
    }

    /**
     * testAcceptInvokesVisitOnGivenVisitor
     *
     * @return void
     */
    public function testAcceptInvokesVisitOnGivenVisitor()
    {
        $visitor = $this->getMock('PHP_Depend_Code_ASTVisitorI');
        $visitor->expects($this->once())
            ->method('__call')
            ->with($this->equalTo('visitStaticReference'));

        $node = $this->createNodeInstance();
        $node->accept($visitor);
    }

    /**
     * testAcceptReturnsReturnValueOfVisitMethod
     *
     * @return void
     */
    public function testAcceptReturnsReturnValueOfVisitMethod()
    {
        $visitor = $this->getMock('PHP_Depend_Code_ASTVisitorI');
        $visitor->expects($this->once())
            ->method('__call')
            ->with($this->equalTo('visitStaticReference'))
            ->will($this->returnValue(42));

        $node = $this->createNodeInstance();
        self::assertEquals(42, $node->accept($visitor));
    }

    /**
     * Tests that an invalid static results in the expected exception.
     *
     * @return void
     */
    public function testStaticReferenceAllocationOutsideOfClassScopeThrowsExpectedException()
    {
        $this->setExpectedException(
            'PHP_Depend_Parser_InvalidStateException',
            'The keyword "static" was used outside of a class/method scope.'
        );

        $packages = self::parseCodeResourceForTest();
    }

    /**
     * Tests that an invalid static results in the expected exception.
     *
     * @return void
     */
    public function testStaticReferenceMemberPrimaryPrefixOutsideOfClassScopeThrowsExpectedException()
    {
        $this->setExpectedException(
            'PHP_Depend_Parser_InvalidStateException',
            'The keyword "static" was used outside of a class/method scope.'
        );

        self::parseCodeResourceForTest();
    }

    /**
     * testMagicSelfReturnsExpectedSetOfPropertyNames
     *
     * @return void
     */
    public function testMagicSelfReturnsExpectedSetOfPropertyNames()
    {
        $reference = $this->createNodeInstance();
        self::assertEquals(
            array(
                'qualifiedName',
                'context',
                'comment',
                'metadata',
                'nodes'
            ),
            $reference->__sleep()
        );
    }

    /**
     * testStaticReferenceHasExpectedStartLine
     *
     * @return void
     */
    public function testStaticReferenceHasExpectedStartLine()
    {
        $ref = $this->_getFirstStaticReferenceInClass(__METHOD__);
        $this->assertEquals(5, $ref->getStartLine());
    }

    /**
     * testStaticReferenceHasExpectedStartColumn
     *
     * @return void
     */
    public function testStaticReferenceHasExpectedStartColumn()
    {
        $ref = $this->_getFirstStaticReferenceInClass(__METHOD__);
        $this->assertEquals(13, $ref->getStartColumn());
    }

    /**
     * testStaticReferenceHasExpectedEndLine
     *
     * @return void
     */
    public function testStaticReferenceHasExpectedEndLine()
    {
        $ref = $this->_getFirstStaticReferenceInClass(__METHOD__);
        $this->assertEquals(5, $ref->getEndLine());
    }

    /**
     * testStaticReferenceHasExpectedEndColumn
     *
     * @return void
     */
    public function testStaticReferenceHasExpectedEndColumn()
    {
        $ref = $this->_getFirstStaticReferenceInClass(__METHOD__);
        $this->assertEquals(18, $ref->getEndColumn());
    }

    /**
     * Creates a concrete node implementation.
     *
     * @return PHP_Depend_Code_ASTStaticReference
     */
    protected function createNodeInstance()
    {
        return new PHP_Depend_Code_ASTStaticReference(
            $this->getMock('PHP_Depend_Builder_Context'),
            $this->getMockForAbstractClass(
                'PHP_Depend_Code_AbstractClassOrInterface',
                array(__CLASS__)
            )
        );
    }

    /**
     * Returns a node instance for the currently executed test case.
     *
     * @param string $testCase Name of the calling test case.
     *
     * @return PHP_Depend_Code_ASTStaticReference
     */
    private function _getFirstStaticReferenceInClass($testCase)
    {
        return $this->getFirstNodeOfTypeInClass(
            $testCase, PHP_Depend_Code_ASTStaticReference::CLAZZ
        );
    }
}
