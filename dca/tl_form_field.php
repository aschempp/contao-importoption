<?php

/**
 * importoption Extension for Contao Open Source CMS
 *
 * @copyright  Copyright (c) 2014, terminal42 gmbh
 * @author     terminal42 gmbh <info@terminal42.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 * @link       http://github.com/aschempp/contao-importoption
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
    'label'             => &$GLOBALS['TL_LANG']['tl_form_field']['loadCSV'],
    'inputType'         => 'checkbox',
    'exclude'           => true,
    'eval'              => array('submitOnChange'=>true),
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['source']         = array
(
    'label'             => &$GLOBALS['TL_LANG']['tl_form_field']['source'],
    'inputType'         => 'fileTree',
    'exclude'           => true,
    'eval'              => array('mandatory'=>true, 'fieldType'=>'checkbox', 'files'=>true, 'filesOnly'=>true, 'extensions'=>'csv')
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['csvSeparator']   = array
(
    'label'             => &$GLOBALS['TL_LANG']['MSC']['separator'],
    'inputType'         => 'select',
    'exclude'           => true,
    'options'           => array('comma', 'semicolon', 'tabulator'),
    'reference'         => &$GLOBALS['TL_LANG']['MSC'],
    'eval'              => array('tl_class'=>'w50'),
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['csvCache'] = array
(
    'label'             => &$GLOBALS['TL_LANG']['tl_form_field']['csvCache'],
    'inputType'         => 'checkbox',
    'exclude'           => true,
    'default'           => '1',
    'eval'              => array('tl_class'=>'w50 m12'),
);

