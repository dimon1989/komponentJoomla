<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class BooksControllerBooks extends JControllerAdmin
{
    /**
     * Proxy for getModel.
     *
     * @param   string  $name    The model name. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  object  The model.
     *
     * @since   1.6
     */
    public function getModel($name = 'Book', $prefix = 'BooksModel', $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);

        return $model;
    }

    public function delete()
    {

        // Get items to remove from the request.
        $cid = JFactory::getApplication()->input->get('cid', array(), 'array');

        if (!is_array($cid) || count($cid) < 1)
        {
            JLog::add(JText::_($this->text_prefix . '_NO_ITEM_SELECTED'), JLog::WARNING, 'jerror');
        }
        else
        {
            // Get the model.
            $model = $this->getModel();

            // Make sure the item ids are integers
            jimport('joomla.utilities.arrayhelper');
            JArrayHelper::toInteger($cid);

            // Remove the items.
            if ($model->delete($cid))
            {
                $this->setMessage(JText::plural($this->text_prefix . '_N_ITEMS_DELETED', count($cid)));
            }
            else
            {
                $this->setMessage($model->getError());
            }
        }
        // Invoke the postDelete method to allow for the child class to access the model.
        $this->postDeleteHook($model, $cid);

        $this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list, false));
    }

    public function publish()
    {
        // Get items to publish from the request.
        $cid = JFactory::getApplication()->input->get('cid', array(), 'array');
        $data = array('publish' => 1, 'unpublish' => 0, 'archive' => 2, 'trash' => -2, 'report' => -3);
        $task = $this->getTask();
        $value = JArrayHelper::getValue($data, $task, 0, 'int');

        if (empty($cid))
        {
            JLog::add(JText::_($this->text_prefix . '_NO_ITEM_SELECTED'), JLog::WARNING, 'jerror');
        }
        else
        {
            // Get the model.
            $model = $this->getModel();

            // Make sure the item ids are integers
            JArrayHelper::toInteger($cid);

            // Publish the items.
            try
            {
                $model->publish($cid, $value);

                if ($value == 1)
                {
                    $ntext = $this->text_prefix . '_N_ITEMS_PUBLISHED';
                }
                elseif ($value == 0)
                {
                    $ntext = $this->text_prefix . '_N_ITEMS_UNPUBLISHED';
                }
                elseif ($value == 2)
                {
                    $ntext = $this->text_prefix . '_N_ITEMS_ARCHIVED';
                }
                else
                {
                    $ntext = $this->text_prefix . '_N_ITEMS_TRASHED';
                }
                $this->setMessage(JText::plural($ntext, count($cid)));
            }
            catch (Exception $e)
            {
                $this->setMessage(JText::_('JLIB_DATABASE_ERROR_ANCESTOR_NODES_LOWER_STATE'), 'error');
            }

        }
        $extension = $this->input->get('extension');
        $extensionURL = ($extension) ? '&extension=' . $extension : '';
        $this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list . $extensionURL, false));
    }
}