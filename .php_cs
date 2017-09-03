<?php

$header = <<<EOF

(c) 2011 SimpleThings GmbH

@package SimpleThings\EntityAudit
@author Benjamin Eberlei <eberlei@simplethings.de>
@link http://www.simplethings.de

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public
License along with this library; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

EOF;

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        'header_comment' => [
            'commentType' => 'comment',
            'header' => $header,
            'location' => 'after_open',
            'separate' => 'bottom'
        ],
        'blank_line_after_opening_tag' => true,
        'array_syntax' => [
            'syntax' => 'long'
        ],
    ])
    ->setFinder($finder)
;