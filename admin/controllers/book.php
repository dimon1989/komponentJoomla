<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
* Book Controller
*
* @package     Joomla.Administrator
* @subpackage  com_helloworld
* @since       0.0.9
*/
class BooksControllerBook extends JControllerForm
{
    /**
     * Implement to allowAdd or not
     *
     * Not used at this time (but you can look at how other components use it....)
     * Overwrites: JControllerForm::allowAdd
     *
     * @param array $data
     * @return bool
     */
    protected function allowAdd($data = array())
    {
        return parent::allowAdd($data);
    }
    /**
     * Implement to allow edit or not
     * Overwrites: JControllerForm::allowEdit
     *
     * @param array $data
     * @param string $key
     * @return bool
     */
    protected function allowEdit($data = array(), $key = 'id')
    {
        $id = isset( $data[ $key ] ) ? $data[ $key ] : 0;
        if( !empty( $id ) )
        {
            return JFactory::getUser()->authorise( "core.edit", "com_books.book." . $id );
        }
    }

    public function save($key = null, $urlVar = null)
    {
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $app   = JFactory::getApplication();
        $lang  = JFactory::getLanguage();
        $model = $this->getModel();
        $table = $model->getTable();

        $data  = $this->input->post->get('jform', array(), 'array');
        if ( $data['status'] == 'free' ) {
            $data['user_id'] = '';
            $data['rentDate'] = '';
        }

        else if ( $data['status'] == 'rent' && $data['user_id'] != '0') {
            $data['rentDate'] = date('Y-m-d H:i:s');
        }
        else if( $data['status'] == 'rent' && $data['user_id'] == '0'){

            // Redirect back to the edit screen.
            JFactory::getApplication()->redirect(
                JRoute::_(
                    'index.php?option=' . $this->option . '&view=' . $this->view_item
                    . $this->getRedirectToItemAppend($recordId, $urlVar) . '&id=' . $data['id'], false
                ),$msg='Incorrect User ID',$msgType='error');
        }

        $checkin = property_exists($table, 'checked_out');
        $context = "$this->option.edit.$this->context";
        $task = $this->getTask();

        // Determine the name of the primary key for the data.
        if (empty($key))
        {
            $key = $table->getKeyName();
        }

        // To avoid data collisions the urlVar may be different from the primary key.
        if (empty($urlVar))
        {
            $urlVar = $key;
        }

        $recordId = $this->input->getInt($urlVar);

        // Populate the row id from the session.
        $data[$key] = $recordId;

        // The save2copy task needs to be handled slightly differently.
        if ($task == 'save2copy')
        {
            // Check-in the original row.
            if ($checkin && $model->checkin($data[$key]) === false)
            {
                // Check-in failed. Go back to the item and display a notice.
                $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_CHECKIN_FAILED', $model->getError()));
                $this->setMessage($this->getError(), 'error');

                $this->setRedirect(
                    JRoute::_(
                        'index.php?option=' . $this->option . '&view=' . $this->view_item
                        . $this->getRedirectToItemAppend($recordId, $urlVar), false
                    )
                );

                return false;
            }

            // Reset the ID and then treat the request as for Apply.
            $data[$key] = 0;
            $task = 'apply';
        }

        // Access check.
        if (!$this->allowSave($data, $key))
        {
            $this->setError(JText::_('JLIB_APPLICATION_ERROR_SAVE_NOT_PERMITTED'));
            $this->setMessage($this->getError(), 'error');

            $this->setRedirect(
                JRoute::_(
                    'index.php?option=' . $this->option . '&view=' . $this->view_list
                    . $this->getRedirectToListAppend(), false
                )
            );

            return false;
        }

        // Validate the posted data.
        // Sometimes the form needs some posted data, such as for plugins and modules.
        $form = $model->getForm($data, false);

        if (!$form)
        {
            $app->enqueueMessage($model->getError(), 'error');

            return false;
        }

        // Test whether the data is valid.
        $validData = $model->validate($form, $data);

        // Check for validation errors.
        if ($validData === false)
        {
            // Get the validation messages.
            $errors = $model->getErrors();

            // Push up to three validation messages out to the user.
            for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
            {
                if ($errors[$i] instanceof Exception)
                {
                    $app->enqueueMessage($errors[$i]->getMessage(), 'warning');
                }
                else
                {
                    $app->enqueueMessage($errors[$i], 'warning');
                }
            }

            // Save the data in the session.
            $app->setUserState($context . '.data', $data);

            // Redirect back to the edit screen.
            $this->setRedirect(
                JRoute::_(
                    'index.php?option=' . $this->option . '&view=' . $this->view_item
                    . $this->getRedirectToItemAppend($recordId, $urlVar), false
                )
            );

            return false;
        }

        if (!isset($validData['tags']))
        {
            $validData['tags'] = null;
        }

        // Attempt to save the data.
        if (!$model->save($validData))
        {
            // Save the data in the session.
            $app->setUserState($context . '.data', $validData);

            // Redirect back to the edit screen.
            $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()));
            $this->setMessage($this->getError(), 'error');

            $this->setRedirect(
                JRoute::_(
                    'index.php?option=' . $this->option . '&view=' . $this->view_item
                    . $this->getRedirectToItemAppend($recordId, $urlVar), false
                )
            );

            return false;
        }

        // Save succeeded, so check-in the record.
        if ($checkin && $model->checkin($validData[$key]) === false)
        {
            // Save the data in the session.
            $app->setUserState($context . '.data', $validData);

            // Check-in failed, so go back to the record and display a notice.
            $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_CHECKIN_FAILED', $model->getError()));
            $this->setMessage($this->getError(), 'error');

            $this->setRedirect(
                JRoute::_(
                    'index.php?option=' . $this->option . '&view=' . $this->view_item
                    . $this->getRedirectToItemAppend($recordId, $urlVar), false
                )
            );

            return false;
        }

        $this->setMessage(
            JText::_(
                ($lang->hasKey($this->text_prefix . ($recordId == 0 && $app->isSite() ? '_SUBMIT' : '') . '_SAVE_SUCCESS')
                    ? $this->text_prefix
                    : 'JLIB_APPLICATION') . ($recordId == 0 && $app->isSite() ? '_SUBMIT' : '') . '_SAVE_SUCCESS'
            )
        );

        // Redirect the user and adjust session state based on the chosen task.
        switch ($task)
        {
            case 'apply':
                // Set the record data in the session.
                $recordId = $model->getState($this->context . '.id');
                $this->holdEditId($context, $recordId);
                $app->setUserState($context . '.data', null);
                $model->checkout($recordId);

                // Redirect back to the edit screen.
                $this->setRedirect(
                    JRoute::_(
                        'index.php?option=' . $this->option . '&view=' . $this->view_item
                        . $this->getRedirectToItemAppend($recordId, $urlVar), false
                    )
                );
                break;

            case 'save2new':
                // Clear the record id and data from the session.
                $this->releaseEditId($context, $recordId);
                $app->setUserState($context . '.data', null);

                // Redirect back to the edit screen.
                $this->setRedirect(
                    JRoute::_(
                        'index.php?option=' . $this->option . '&view=' . $this->view_item
                        . $this->getRedirectToItemAppend(null, $urlVar), false
                    )
                );
                break;

            default:
                // Clear the record id and data from the session.
                $this->releaseEditId($context, $recordId);
                $app->setUserState($context . '.data', null);

                // Redirect to the list screen.
                $this->setRedirect(
                    JRoute::_(
                        'index.php?option=' . $this->option . '&view=' . $this->view_list
                        . $this->getRedirectToListAppend(), false
                    )
                );
                break;
        }

        // Invoke the postSave method to allow for the child class to access the model.
        $this->postSaveHook($model, $validData);

        return true;
    }
	
}