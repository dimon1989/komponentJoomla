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
 * Books Model
 *
 * @since  0.0.1
 */
class BooksModelBooks extends JModelItem
{

    public function getBooks()
    {

        $books = null;

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('id', 'title', 'author', 'publisher', 'category','year', 'status', 'createDate', 'rentDate')));
        $query->from($db->quoteName('#__books'));
        $query->where($db->quoteName('published') . ' = 1' );

        $db->setQuery($query);
        $books = $db->loadObjectList();

        return $books;
    }

    public function addBook($book)
    {
        $app = JFactory::getApplication();

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);

        $columns = array('title', 'author', 'publisher', 'category','year');

        $values = array($db->quote($book['title']),
            $db->quote($book['author']),
            $db->quote($book['publisher']),
            $db->quote($book['category']),
            $db->quote($book['year'])
        );

        $query
            ->insert($db->quoteName('#__books'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));

        $db->setQuery($query);
        $result = $db->execute();

        $message = null;
        $messageType = null;

        if ($result == false){
            $message = "Problem z dodaniem do bazy!";
            $messageType = 'error';
        }
        else {
            $message = "Książka dodana do bazy";
            $messageType = 'message';
        }

        $app->redirect(JURI::base().'index.php?option=com_books&view=books', $message, $messageType);
    }

    public function rentBook($bookId, $user_id){

        $app = JFactory::getApplication();
        $object = new stdClass();

        $object->id = $bookId;
        $object->user_id = $user_id;
        $object->rentDate = date('Y-m-d h:i:s', time());;
        $object->status = 'rent';

        $result = JFactory::getDbo()->updateObject('#__books', $object, 'id');

        $message = null;
        $messageType = null;

        if ($result == true){
            $message = "Status książki został zmieniony";
            $messageType = 'message';
        }
        else {
            $message = "Problem z edycją w bazie!";
            $messageType = 'error';
        }

        $app->redirect(JURI::base().'index.php?option=com_books&view=books', $message, $messageType);
    }
}