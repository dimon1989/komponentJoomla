<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
* Form Rule class for the Joomla Framework.
*/
class JFormRuleTitle extends JFormRule
{
/**
* The regular expression.
*
* @access	protected
* @var		string
* @since	2.5
*/
protected $regex = '^[^0-9]+$';
}