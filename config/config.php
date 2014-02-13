<?php

/**
 * importoption Extension for Contao Open Source CMS
 *
 * @copyright  Copyright (c) 2009-2014, terminal42 gmbh
 * @author     terminal42 gmbh <info@terminal42.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 * @link       http://github.com/aschempp/contao-importoption
 */


/**
 * Backend fields
 */
$GLOBALS['BE_FFL']['optionWizard']	= 'ImportOptionWizard';


/**
 * Backend modules
 */
$GLOBALS['BE_MOD']['content']['form']['importOption'] = array('ImportOptionWizard', 'importOption');


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['loadFormField'][] = array('ImportOptionWizard', 'loadCSV');

