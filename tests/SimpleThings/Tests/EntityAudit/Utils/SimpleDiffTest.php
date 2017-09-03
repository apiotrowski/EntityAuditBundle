<?php
/*
 *
 * (c) 2011 SimpleThings GmbH
 *
 * @package SimpleThings\EntityAudit
 * @author Benjamin Eberlei <eberlei@simplethings.de>
 * @link http://www.simplethings.de
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 */

namespace SimpleThings\EntityAudit\Tests\Utils;

use \SimpleThings\EntityAudit\Utils\SimpleDiff;

class SimpleDiffTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataDiff
     * @param $old
     * @param $new
     * @param $output
     * @return void
     */
    public function testDiff($old, $new, $output)
    {
        $diff = new SimpleDiff();
        $d = $diff->htmlDiff($old, $new);

        $this->assertEquals($output, $d);
    }

    public static function dataDiff()
    {
        return array(
            array('Foo', 'foo', '<del>Foo</del> <ins>foo</ins> '),
            array('Foo Foo', 'Foo', 'Foo <del>Foo</del> '),
            array('Foo', 'Foo Foo', 'Foo <ins>Foo</ins> '),
            array('Foo Bar Baz', 'Foo Foo Foo', 'Foo <del>Bar Baz</del> <ins>Foo Foo</ins> '),
            array('Foo Bar Baz', 'Foo Baz', 'Foo <del>Bar</del> Baz '),
        );
    }
}
