<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
JHtml::_('formbehavior.chosen', 'select');

$listOrder     = $this->escape($this->filter_order);
$listDirn      = $this->escape($this->filter_order_Dir);
?>
<form action="index.php?option=com_books&view=books" method="post" id="adminForm" name="adminForm">
    <div id="j-sidebar-container" class="span2">
        <?php echo JHtmlSidebar::render(); ?>
    </div>
    <div id="j-main-container" class="span10">
    <div class="row-fluid">
        <div class="span6">
            <?php echo JText::_('COM_BOOKS_BOOKS_FILTER'); ?>
            <?php
                echo JLayoutHelper::render(
                    'joomla.searchtools.default',
                    array('view' => $this)
                );
            ?>
        </div>
    </div>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th width="1%"><?php echo JText::_('COM_BOOKS_NUM'); ?></th>
            <th width="2%">
                <?php echo JHtml::_('grid.checkall'); ?>
            </th>
            <th width="22%">
                <?php echo JHtml::_('grid.sort', 'COM_BOOKS_BOOKS_TITLE', 'title', $listDirn, $listOrder); ?>
            </th>
            <th width="14%">
                <?php echo JText::_('COM_BOOKS_BOOKS_AUTHOR');  ?>
            </th>
            <th width="14%">
                <?php echo JText::_('COM_BOOKS_BOOKS_PUBLISHER'); ?>
            </th>
            <th width="10%">
                <?php echo JText::_('COM_BOOKS_BOOKS_YEAR'); ?>
            </th>
            <th width="14%">
                <?php echo JText::_('COM_BOOKS_BOOKS_CAT'); ?>
            </th>
            <th width="10%">
                <?php echo JText::_('COM_BOOKS_BOOKS_STATUS'); ?>
            </th>
            <th width="8%">
                <?php echo JText::_('COM_BOOKS_BOOKS_USER_ID'); ?>
            </th>
            <th width="10%">
                <?php echo JHtml::_('grid.sort', 'COM_BOOKS_PUBLISHED', 'published', $listDirn, $listOrder); ?>
            </th>
            <th width="5%">
                <?php echo JHtml::_('grid.sort', 'COM_BOOKS_ID', 'id', $listDirn, $listOrder); ?>
            </th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="5">
                <?php echo $this->pagination->getListFooter(); ?>
            </td>
        </tr>
        </tfoot>
        <tbody>
        <?php if (!empty($this->items)) : ?>
            <?php foreach ($this->items as $i => $row) :
                $link = JRoute::_('index.php?option=com_books&task=book.edit&id=' . $row->id);
                ?>

                <tr>
                    <td>
                        <?php echo $this->pagination->getRowOffset($i); ?>
                    </td>
                    <td>
                        <?php echo JHtml::_('grid.id', $i, $row->id); ?>
                    </td>
                    <td>
                        <a href="<?php echo $link; ?>" title="<?php echo JText::_('COM_BOOKS_EDIT_BOOKS'); ?>">
                        <?php echo $row->title; ?>
                        </a>
                        <div class="small">
                            <?php echo 'Status: '.$this->escape($row->status); ?>
                        </div>
                    </td>
                    <td align="center">
                        <?php echo $row->author; ?>
                    </td>
                    <td align="center">
                        <?php echo $row->publisher; ?>
                    </td>
                    <td align="center">
                        <?php echo $row->year; ?>
                    </td>
                    <td align="center">
                        <?php echo $row->category; ?>
                    </td>
                    <td align="center">
                        <?php echo $row->status; ?>
                    </td>
                    <td align="center">
                        <?php echo $row->user_id; ?>
                    </td>
                    <td align="center">
                        <?php echo JHtml::_('jgrid.published', $row->published, $i, 'books.', true, 'cb'); ?>
                    </td>
                    <td align="center">
                        <?php echo $row->id; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="0"/>
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"
    <?php echo JHtml::_('form.token'); ?>
    </div>
</form>