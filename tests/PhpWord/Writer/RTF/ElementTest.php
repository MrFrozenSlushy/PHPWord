<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @see         https://github.com/PHPOffice/PHPWord
 * @copyright   2010-2018 PHPWord contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpWord\Writer\RTF;

use PhpOffice\PhpWord\Writer\RTF;

/**
 * Test class for PhpOffice\PhpWord\Writer\RTF\Element subnamespace
 */
class ElementTest extends \PHPUnit\Framework\TestCase
{
    public function removeCr($field)
    {
        return str_replace("\r\n", "\n", $field->write());
    }

    /**
     * Test unmatched elements
     */
    public function testUnmatchedElements()
    {
        $elements = array('Container', 'Text', 'Title', 'Link', 'Image', 'Table', 'Field');
        foreach ($elements as $element) {
            $objectClass = 'PhpOffice\\PhpWord\\Writer\\RTF\\Element\\' . $element;
            $parentWriter = new RTF();
            $newElement = new \PhpOffice\PhpWord\Element\PageBreak();
            $object = new $objectClass($parentWriter, $newElement);

            $this->assertEquals('', $object->write());
        }
    }

    public function testPageField()
    {
        $parentWriter = new RTF();
        $element = new \PhpOffice\PhpWord\Element\Field('PAGE');
        $field = new \PhpOffice\PhpWord\Writer\RTF\Element\Field($parentWriter, $element);

        $this->assertEquals("{\\field{\\*\\fldinst PAGE}{\\fldrslt}}\\par\n", $this->removeCr($field));
    }

    public function testNumpageField()
    {
        $parentWriter = new RTF();
        $element = new \PhpOffice\PhpWord\Element\Field('NUMPAGES');
        $field = new \PhpOffice\PhpWord\Writer\RTF\Element\Field($parentWriter, $element);

        $this->assertEquals("{\\field{\\*\\fldinst NUMPAGES}{\\fldrslt}}\\par\n", $this->removeCr($field));
    }

    public function testDateField()
    {
        $parentWriter = new RTF();
        $element = new \PhpOffice\PhpWord\Element\Field('DATE', array('dateformat' => 'd MM yyyy H:mm:ss'));
        $field = new \PhpOffice\PhpWord\Writer\RTF\Element\Field($parentWriter, $element);

        $this->assertEquals("{\\field{\\*\\fldinst DATE \\\\@ \"d MM yyyy H:mm:ss\"}{\\fldrslt}}\\par\n", $this->removeCr($field));
    }

    public function testIndexField()
    {
        $parentWriter = new RTF();
        $element = new \PhpOffice\PhpWord\Element\Field('INDEX');
        $field = new \PhpOffice\PhpWord\Writer\RTF\Element\Field($parentWriter, $element);

        $this->assertEquals("{}\\par\n", $this->removeCr($field));
    }
}
