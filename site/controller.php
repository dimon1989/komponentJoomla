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
 * Books Component Controller
 *
 * @since  0.0.1
 */
class BooksController extends JControllerLegacy
{
    public function store() {

        $jinput = JFactory::getApplication()->input;

        // Get the form data
        $formValues = $jinput->getArray(array(
            'title' => 'title',
            'author' => 'author',
            'publisher' => 'publisher',
            'year' => 'year',
            'category' => 'category'
        ));

        $model = JModelLegacy::getInstance('Books', 'BooksModel', array('ignore_request' => true));
        $model->addBook($formValues);

    }

    public function rent() {

        $jinput = JFactory::getApplication()->input;
        $bookId = $jinput->post->get('id', null);


        $model = JModelLegacy::getInstance('Books', 'BooksModel', array('ignore_request' => true));
        $model->rentBook($bookId);

    }
}