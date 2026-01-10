<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Class colorpicker_form_element
 *
 * @package     block_compviz
 * @category    string
 * @copyright   2024 BIF-INNO-Group10
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once($CFG->dirroot . '/blocks/compviz/classes/form/colorpicker.php');
require_once($CFG->libdir . '/form/templatable_form_element.php');

use block_compviz\form\HTML_QuickForm_bccolorpicker;

class MoodleQuickForm_bccolorpicker extends HTML_QuickForm_bccolorpicker implements templatable {
    use templatable_form_element;

    /** @var string html for help button, if empty then no help */
    var $_helpbutton = '';

    /** @var bool if true label will be hidden */
    var $_hiddenLabel = false;

    /** @var bool Whether to force the display of this element to flow LTR. */
    protected $forceltr = false;

    /**
     * constructor
     *
     * @param string $elementName (optional) name of the text field
     * @param string $elementLabel (optional) text field label
     * @param string $attributes (optional) Either a typical HTML attribute string or an associative array
     */
    public function __construct($elementName = null, $elementLabel = null, $attributes = null)
    {
        parent::__construct($elementName, $elementLabel, $attributes);
    }

    /**
     * Old syntax of class constructor. Deprecated in PHP7.
     *
     * @deprecated since Moodle 3.1
     */
    public function MoodleQuickForm_bccolorpicker($elementName = null, $elementLabel = null, $attributes = null)
    {
        debugging('Use of class name as constructor is deprecated', DEBUG_DEVELOPER);
        self::__construct($elementName, $elementLabel, $attributes);
    }

    /**
     * Sets label to be hidden
     *
     * @param bool $hiddenLabel sets if label should be hidden
     */
    function setHiddenLabel($hiddenLabel)
    {
        $this->_hiddenLabel = $hiddenLabel;
    }

    /**
     * Freeze the element so that only its value is returned and set persistantfreeze to false
     *
     * @since     Moodle 2.4
     * @access    public
     * @return    void
     */
    function freeze()
    {
        $this->_flagFrozen = true;
        // No hidden element is needed refer MDL-30845
        $this->setPersistantFreeze(false);
    } //end func freeze

    /**
     * Returns the html to be used when the element is frozen
     *
     * @since     Moodle 2.4
     * @return    string Frozen html
     */
    function getFrozenHtml()
    {
        $attributes = array('readonly' => 'readonly');
        $this->updateAttributes($attributes);
        return $this->_getTabs() . '<input' . $this->_getAttrString($this->_attributes) . ' />' . $this->_getPersistantData();
    } //end func getFrozenHtml

    /**
     * Returns HTML for this form element.
     *
     * @return string
     */
    public function toHtml()
    {
        if ($this->get_force_ltr()) {
            if (!isset($this->_attributes['class'])) {
                $this->_attributes['class'] = 'text-ltr';
            } else {
                $this->_attributes['class'] .= ' text-ltr';
            }
        }

        $this->_generateId();
        if ($this->_flagFrozen) {
            return $this->getFrozenHtml();
        }
        $html = $this->_getTabs() . '<input' . $this->_getAttrString($this->_attributes) . ' />';

        if ($this->_hiddenLabel) {
            return '<label class="accesshide" for="' . $this->getAttribute('id') . '" >' .
                $this->getLabel() . '</label>' . $html;
        } else {
            return $html;
        }
    }

    /**
     * get html for help button
     *
     * @return string html for help button
     */
    function getHelpButton()
    {
        return $this->_helpbutton;
    }

    /**
     * Get force LTR option.
     *
     * @return bool
     */
    public function get_force_ltr()
    {
        return $this->forceltr;
    }

    /**
     * Force the field to flow left-to-right.
     *
     * This is useful for fields such as URLs, passwords, settings, etc...
     *
     * @param bool $value The value to set the option to.
     */
    public function set_force_ltr($value)
    {
        $this->forceltr = (bool) $value;
    }
}
