<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Andreas Schempp 2009-2012
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['select'] = str_replace(',options;', ',options,loadCSV;', $GLOBALS['TL_DCA']['tl_form_field']['palettes']['select']);
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['radio'] = str_replace(',options;', ',options,loadCSV;', $GLOBALS['TL_DCA']['tl_form_field']['palettes']['radio']);
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['checkbox'] = str_replace(',options;', ',options,loadCSV;', $GLOBALS['TL_DCA']['tl_form_field']['palettes']['checkbox']);

$GLOBALS['TL_DCA']['tl_form_field']['palettes']['__selector__'][] = 'loadCSV';
$GLOBALS['TL_DCA']['tl_form_field']['subpalettes']['loadCSV'] = 'source,csvSeparator,csvCache';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_form_field']['fields']['loadCSV'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_form_field']['loadCSV'],
	'inputType'			=> 'checkbox',
	'exclude'			=> true,
	'eval'				=> array('submitOnChange'=>true),
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['source'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_form_field']['source'],
	'inputType'			=> 'fileTree',
	'exclude'			=> true,
	'eval'				=> array('mandatory'=>true, 'fieldType'=>'checkbox', 'files'=>true, 'filesOnly'=>true, 'extensions'=>'csv')
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['csvSeparator'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['MSC']['separator'],
	'inputType'			=> 'select',
	'exclude'			=> true,
	'options'			=> array('comma', 'semicolon', 'tabulator'),
	'reference'			=> &$GLOBALS['TL_LANG']['MSC'],
	'eval'				=> array('tl_class'=>'w50'),
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['csvCache'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_form_field']['csvCache'],
	'inputType'			=> 'checkbox',
	'exclude'			=> true,
	'default'			=> '1',
	'eval'				=> array('tl_class'=>'w50 m12'),
);

