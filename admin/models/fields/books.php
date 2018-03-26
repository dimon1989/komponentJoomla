<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

/**
* Books Form Field class for the books component
*
* @since  0.0.1
*/
class JFormFieldBooks extends JFormFieldList
{
/**
* The field type.
*
* @var         string
*/
    protected $type = 'Books';

/**
* Method to get a list of options for a list input.
*
* @return  array  An array of JHtml options.
*/
    protected function getOptions()
    {
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('id,title,published');
        $query->from('#__books');
        $db->setQuery((string) $query);
        $messages = $db->loadObjectList();
        $options  = array();

        if ($messages)
        {
        foreach ($messages as $message)
        {
        $options[] = JHtml::_('select.option', $message->id, $message->greeting);
        }
        }

        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }
}