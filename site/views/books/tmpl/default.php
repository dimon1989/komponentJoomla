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

?>
    <jdoc:include type="message" />
<?php

if (empty($this->books))
{
    echo "<h2>Brak książek</h2>";
}
else
{
    ?>
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Tytuł</th>
            <th scope="col">Autor</th>
            <th scope="col">Wydawca</th>
            <th scope="col">Rok wydania</th>
            <th scope="col">Kategoria</th>
            <th scope="col">Status</th>
            <th scope="col">Data wypożyczenia</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($this->books as $book) {?>
            <tr>
                <th scope="row"><?php echo $book->id; ?></th>
                <td><?php echo $book->title; ?></td>
                <td><?php echo $book->author; ?></td>
                <td><?php echo $book->publisher; ?></td>
                <td><?php echo $book->year; ?></td>
                <td><?php echo $book->category; ?></td>
                <td>
                    <?php if ($book->status == 'free'){
                        echo "dostępna";
                    }
                    else{
                        echo "wypożyczona";
                    }?>
                </td>
                <td>
                    <?php if($book->status === 'free') {?>
                        <form method="post" action="<?php echo JRoute::_('index.php?option=com_books') ?>">
                            <input type="hidden" name="controller" value="books" />
                            <input type="hidden" name="task" value="rent" />
                            <input type="hidden" name="id" value="<?php echo $book->id; ?>" />
                            <button type="submit" class="btn btn-secondary btn-sm active" aria-pressed="true">Wypożycz</button>
                        </form>
                    <?php } else {
                        echo substr($book->rentDate, 0,10); ?>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php
}
?>