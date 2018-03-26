<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_books
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * HTML View class for the Books Component
 *
 * @since  0.0.1
 */
class BooksViewForm extends JViewLegacy
{

    /**
     * Display the Hello World view
     *
     * @param   string  $tpl  The name of the layout file to parse.
     *
     * @return  void
     */
    public function display($tpl = null)
    {
        // Get the form to display
        $this->form = $this->get('Form');

        // Check for errors.
        if ($errors = $this->get('Errors'))
        {
            JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');

            return false;
        }

        // Call the parent display to display the layout file
        parent::display($tpl);

    }
}