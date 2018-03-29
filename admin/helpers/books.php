<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');


abstract class BooksHelper extends JHelperContent
{
/**
* Configure the Linkbar.
*
* @return Bool
*/

    public static function addSubmenu($submenu)
    {
        JHtmlSidebar::addEntry(
        JText::_('COM_BOOKS_SUBMENU_MESSAGES'),
        'index.php?option=com_books',
        $submenu == 'books'
        );
    }
}