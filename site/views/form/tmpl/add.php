<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

$document = JFactory::getDocument();

$urlCSS = Juri::base() . 'components/com_books/assets/css/style.css';
$document->addStyleSheet($urlCSS);



?>
    <form id="formBook" method="post" action="<?php echo JRoute::_('index.php?option=com_books&task') ?>">
        <div class="form-group">
            <label for="title">Tytuł książki:</label>
            <input type="text" id="title" name="title" />
        </div>
        <div class="form-group">
            <label for="author">Autor:</label>
            <input type="text" id="author" name="author" />
        </div>
        <div class="form-group">
            <label for="publisher">Wydawca:</label>
            <input type="text" id="publisher" name="publisher" />
        </div>
        <div class="form-group">
            <label for="year">Rok wydania:</label>
            <input type="number" id="year" min="1900" max="2050" name="year" />
        </div>
        <div class="form-group">
            <label for="category">Kategoria:</label>
            <input type="text" id="category" name="category" />
        </div>
        <div class="form-group">
            <input class="btn btn-secondary" type="submit" id="submit" name="submit" />
            <a class="btn btn-light" href="<?php echo $_SERVER['HTTP_REFERER']; ?>/"  />Powrót</a>
        </div>
        <input type="hidden" name="controller" value="books" />
        <input type="hidden" name="task" value="store" />
    </form>

<script src="http://localhost/joomla/components/com_books/assets/js/validation.js"></script>