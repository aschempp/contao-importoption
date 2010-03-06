<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Andreas Schempp 2009
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


class ImportOptionWizard extends OptionWizard
{
	
	public function __get($strKey)
	{
		switch( $strKey )
		{
			case 'xlabel':
				return ' <a href="' . $this->addToUrl('key=importOption&table='.$this->strTable.'&field='.$this->strName) . '" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['importOption'][1]) . '" onclick="Backend.getScrollOffset();">' . $this->generateImage('tablewizard.gif', $GLOBALS['TL_LANG']['MSC']['importOption'][0], 'style="vertical-align:text-bottom;"') . '</a>';
				break;
				
			default:
				return parent::__get($strKey);
		}
	}
	
	
	
	/**
	 * Return a form to choose a CSV file and import it
	 * @param object
	 * @return string
	 */
	public function importOption()
	{
		if ($this->Input->get('key') != 'importOption')
		{
			return '';
		}

		// Import CSS
		if ($this->Input->post('FORM_SUBMIT') == 'tl_option_import')
		{
			if (!$this->Input->post('source') || !is_array($this->Input->post('source')))
			{
				$_SESSION['TL_ERROR'][] = $GLOBALS['TL_LANG']['ERR']['all_fields'];
				$this->reload();
			}

			$arrOptions = $this->readCSV($this->Input->post('source'), $this->Input->post('separator'));
			
			$strData = serialize($arrOptions);
			if (strlen($strData) > 65000)
			{
				$_SESSION['TL_ERROR'][] = $GLOBALS['TL_LANG']['ERR']['csvSize'];
				$this->reload();
			}
			
			$this->import('Database');
			$this->createNewVersion($this->Input->get('table'), $this->Input->get('id'));
			$this->Database->prepare("UPDATE " . $this->Input->get('table') . " SET " . $this->Input->get('field') . "=? WHERE id=?")
						   ->execute($strData, $this->Input->get('id'));

			setcookie('BE_PAGE_OFFSET', 0, 0, '/');
			$this->redirect(str_replace(array('&key=importOption', '&field='.$this->Input->get('field')), '', $this->Environment->request));
		}

		$objTree = new FileTree($this->prepareForWidget($GLOBALS['TL_DCA']['tl_form_field']['fields']['source'], 'source', null, 'source', 'tl_form_field'));

		// Return form
		return '
<div id="tl_buttons">
<a href="'.ampersand(str_replace(array('&key=importOption', '&field='.$this->Input->get('field')), '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
</div>

<h2 class="sub_headline">'.$GLOBALS['TL_LANG']['MSC']['importOption'][1].'</h2>'.$this->getMessages().'

<form action="'.ampersand($this->Environment->request, true).'" id="tl_option_import" class="tl_form" method="post">
<div class="tl_formbody_edit">
<input type="hidden" name="FORM_SUBMIT" value="tl_option_import" />

<div class="tl_tbox block">
  <h3><label for="separator">'.$GLOBALS['TL_LANG']['MSC']['separator'][0].'</label></h3>
  <select name="separator" id="separator" class="tl_select" onfocus="Backend.getScrollOffset();">
    <option value="comma">'.$GLOBALS['TL_LANG']['MSC']['comma'].'</option>
    <option value="semicolon">'.$GLOBALS['TL_LANG']['MSC']['semicolon'].'</option>
    <option value="tabulator">'.$GLOBALS['TL_LANG']['MSC']['tabulator'].'</option>
  </select>'.(strlen($GLOBALS['TL_LANG']['MSC']['separator'][1]) ? '
  <p class="tl_help">'.$GLOBALS['TL_LANG']['MSC']['separator'][1].'</p>' : '').'
  <h3><label for="source">'.$GLOBALS['TL_LANG']['tl_form_field']['source'][0].'</label> <a href="typolight/files.php" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['fileManager']) . '" onclick="Backend.getScrollOffset(); this.blur(); Backend.openWindow(this, 750, 500); return false;">' . $this->generateImage('filemanager.gif', $GLOBALS['TL_LANG']['MSC']['fileManager'], 'style="vertical-align:text-bottom;"') . '</a></h3>
'.$objTree->generate().(strlen($GLOBALS['TL_LANG']['tl_form_field']['source'][1]) ? '
  <p class="tl_help">'.$GLOBALS['TL_LANG']['tl_form_field']['source'][1].'</p>' : '').'
</div>

</div>

<div class="tl_formbody_submit">

<div class="tl_submit_container">
<input type="submit" name="save" id="save" class="tl_submit" alt="import options" accesskey="s" value="'.specialchars($GLOBALS['TL_LANG']['MSC']['importOption'][0]).'" />
</div>

</div>
</form>';
	}
	
	
	public function loadCSV(Widget $objWidget, $intForm)
	{
		if ($objWidget->loadCSV)
		{
			$strChecksum = md5($objWidget->source);
			if ($objWidget->csvCache)
			{
				if (file_exists(TL_ROOT . '/system/tmp/' . $strChecksum))
				{
					$objFile = new File('system/tmp/' . $strChecksum);
	
					if ($objFile->mtime > time() - 86400)
					{
						$arrOptions = deserialize($objFile->getContent());
					}
					else
					{
						$objFile->delete();
					}
				}
			}

			// Cache result
			if (is_null($arrOptions))
			{
				$arrFiles = deserialize($objWidget->source);
				if (is_array($arrFiles) && count($arrFiles))
				{
					$arrOptions = $this->readCSV($arrFiles, $objWidget->csvSeparator);
					
					// Cache
					if ($objWidget->csvCache)
					{
						$objFile = new File('system/tmp/' . $strChecksum);
						$objFile->write(serialize($arrOptions));
						$objFile->close();
					}
				}
			}
			
			$objWidget->options = $arrOptions;
		}
		
	    return $objWidget;
	}
	
	
	protected function readCSV($arrFiles, $strSeparator)
	{
		$arrOptions = array();
		
		// Get separator
		switch ($strSeparator)
		{
			case 'semicolon':
				$strSeparator = ';';
				break;

			case 'tabulator':
				$strSeparator = '\t';
				break;

			default:
				$strSeparator = ',';
				break;
		}
		
		foreach ($arrFiles as $strCsvFile)
		{
			$objFile = new File($strCsvFile);

			if ($objFile->extension != 'csv')
			{
				$_SESSION['TL_ERROR'][] = sprintf($GLOBALS['TL_LANG']['ERR']['filetype'], $objFile->extension);
				continue;
			}

			$strFile = $objFile->getContent();
			$arrRows = trimsplit('\n', $strFile);

			foreach ($arrRows as $k=>$v)
			{
				$arrRows[$k] = trimsplit($strSeparator, $v);
			}

			$arrOptions = array_merge($arrOptions, $arrRows);
		}
		
		foreach( $arrOptions as $k => $option )
		{
			$arrOptions[$k] = array
			(
				'value'		=> $option[0],
				'label'		=> $option[1],
				'default'	=> $option[2],
				'group'		=> $option[3],
			);
		}
		
		return $arrOptions;
	}
	
}

