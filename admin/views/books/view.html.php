<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Books View
 *
 * @since  0.0.1
 */
class BooksViewBooks extends JViewLegacy
{
    /**
     * Display the Books view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    function display($tpl = null)
    {
        $app = JFactory::getApplication();
        $context = "books.list.admin.books";
        // Get data from the model
        $this->items		= $this->get('Items');
        $this->pagination	= $this->get('Pagination');
        $this->state            = $this->get('State');
        $this->filter_order     = $app->getUserStateFromRequest($context.'filter_order', 'filter_order', 'title', 'cmd');
        $this->filter_order_Dir = $app->getUserStateFromRequest($context.'filter_order_Dir', 'filter_order_Dir', 'asc', 'cmd');
        $this->filterForm       = $this->get('FilterForm');
        $this->activeFilters    = $this->get('ActiveFilters');

        // What Access Permissions does this user have? What can (s)he do?
        $this->canDo = JHelperContent::getActions('com_books');

        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            throw new Exception(implode("\n", $errors), 500);
        }

        // Set the submenu
		BooksHelper::addSubmenu('books');

        // Set the toolbar
        $this->addToolBar();

        // Display the template
        parent::display($tpl);

        // Set the document
        $this->setDocument();
    }

    protected function addToolBar()
    {
        $title = JText::_('COM_BOOKS_MANAGER_BOOKS');

        if ($this->pagination->total)
        {
            $title .= "<span style='font-size: 0.5em; vertical-align: middle;'>(" . $this->pagination->total . ")</span>";
        }

        JToolbarHelper::title($title, 'books');
        if ($this->canDo->get('core.create'))
        {
            JToolbarHelper::addNew('book.add');
        }
        if ($this->canDo->get('core.edit'))
        {
            JToolbarHelper::editList('book.edit');
        }
        if ($this->canDo->get('core.delete'))
        {
            JToolbarHelper::deleteList('Are you sure you want to delete items?', 'books.delete');
        }
        if ($this->canDo->get('core.admin'))
        {
            JToolBarHelper::divider();
            JToolBarHelper::preferences('com_books');
        }
    }

        /**
     * Method to set up the document properties
     *
     * @return void
     */
    protected function setDocument() 
    {
        $document = JFactory::getDocument();
        $document->setTitle(JText::_('COM_BOOKS_ADMINISTRATION'));
    }
}