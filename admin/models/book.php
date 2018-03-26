<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
* Book Model
*
* @since  0.0.1
*/
class BooksModelBook extends JModelAdmin
{
        /**
        * Method to get a table object, load it if necessary.
        *
        * @param   string  $type    The table name. Optional.
        * @param   string  $prefix  The class prefix. Optional.
        * @param   array   $config  Configuration array for model. Optional.
        *
        * @return  JTable  A JTable object
        *
        * @since   1.6
        */
        public function getTable($type = 'Books', $prefix = 'BooksTable', $config = array())
        {
             return JTable::getInstance($type, $prefix, $config);
        }

        /**
        * Method to get the record form.
        *
        * @param   array    $data      Data for the form.
        * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
        *
        * @return  mixed    A JForm object on success, false on failure
        *
        * @since   1.6
        */
        public function getForm($data = array(), $loadData = true)
        {
            // Get the form.
        
            $form = $this->loadForm(
            'com_books.book',
            'book',
            array(
            'control' => 'jform',
            'load_data' => $loadData
            )
            );

            if (empty($form))
            {
            return false;
            }

            return $form;
        }

    /**
     * Method to get the script that have to be included on the form
     *
     * @return string	Script files
     */
    public function getScript()
    {
        return 'administrator/components/com_books/models/forms/helloworld.js';
    }
    /**


        /**
        * Method to get the data that should be injected in the form.
        *
        * @return  mixed  The data for the form.
        *
        * @since   1.6
        */
        protected function loadFormData()
        {
            // Check the session for previously entered form data.
            $data = JFactory::getApplication()->getUserState(
            'com_books.edit.book.data',
            array()
            );

            if (empty($data))
            {
            $data = $this->getItem();
            }

            return $data;
        }
}