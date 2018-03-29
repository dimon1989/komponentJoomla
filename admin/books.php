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

// Access check: is this user allowed to access the backend of this component?
if (!JFactory::getUser()->authorise('core.manage', 'com_books'))
{
    throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Require helper file
JLoader::register('BooksHelper', JPATH_COMPONENT . '/helpers/books.php');

$controller = JControllerLegacy::getInstance('Books');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();