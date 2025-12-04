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

use MoodleQuickForm_text;

require_once $CFG->libdir . '/form/text.php';

/**
 * Class for a color picker form element.
 *
 * This class extends MoodleQuickForm_text to create a color picker input field
 * with validation and preview capabilities.
 *
 * @package     block_compviz
 * @copyright   2024 BIF-INNO-Group10
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class colorpicker_form_element extends MoodleQuickForm_text
{


    private $name = null;
    private $visiblename;
    private $description;

    // $previewconfig Array('selector'=>'.some .css .selector','style'=>'backgroundColor');
    private $previewconfig = null;

    /** 
     * Constructor for the colorpicker_form_element class.
     * 
     * @param string $name
     * @param string $visiblename
     * @param string $description
     */
    public function __construct($name = null, $visiblename = null, $description = null) {
        debugging('constructor', DEBUG_ALL);
        if ($name == null) {
            // This is broken quickforms messing with the constructors.
            return;
        }

        parent::__construct($name, $visiblename, $description);
        $this->set_force_ltr(true);
    }

    /**
     * Returns HTML for this form element.
     *
     * @return string
     */
    public function toHtml()
    {
        debugging('Debug toHtml called', DEBUG_ALL);
        global $PAGE, $OUTPUT;

        // Add the class at the last minute.
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

        $icon = new pix_icon('i/loading', get_string('loading', 'admin'), 'moodle', ['class' => 'loadingicon']);
        $context = (object) [
            'id' => $this->getAttribute('id'),
            'name' => $this->visiblename,
            'value' => '',
            'icon' => $icon->export_for_template($OUTPUT),
            'haspreviewconfig' => !empty($this->previewconfig),
            'forceltr' => $this->get_force_ltr()
        ];

        $element = $OUTPUT->render_from_template('core_admin/setting_configcolourpicker', $context);
        $PAGE->requires->js_init_call('M.util.init_colour_picker', array($this->getAttribute('id'), $this->previewconfig));


        $html = $element; //$this->_getTabs() . '<input' . $this->_getAttrString($this->_attributes) . ' />';

        if ($this->_hiddenLabel) {
            return '<label class="accesshide" for="' . $this->getAttribute('id') . '" >' .
                $this->getLabel() . '</label>' . $html;
        } else {
            return $html;
        }
    }


    /**
     * Accepts a renderer
     *
     * @param HTML_QuickForm_Renderer $renderer the renderer for the element.
     * @param boolean $required not used.
     * @param string $error not used.
     * @return void
     */
    public function accept(&$renderer, $required = false, $error = null)
    {
        $renderer->renderElement($this, false, '');
    }

    /**
     * Validates the colour that was entered by the user
     *
     * @param string $data
     * @return string|false
     */
    protected function validate($data)
    {
        /**
         * List of valid HTML colour names
         *
         * @var array
         */
        $colornames = array(
            'aliceblue',
            'antiquewhite',
            'aqua',
            'aquamarine',
            'azure',
            'beige',
            'bisque',
            'black',
            'blanchedalmond',
            'blue',
            'blueviolet',
            'brown',
            'burlywood',
            'cadetblue',
            'chartreuse',
            'chocolate',
            'coral',
            'cornflowerblue',
            'cornsilk',
            'crimson',
            'cyan',
            'darkblue',
            'darkcyan',
            'darkgoldenrod',
            'darkgray',
            'darkgrey',
            'darkgreen',
            'darkkhaki',
            'darkmagenta',
            'darkolivegreen',
            'darkorange',
            'darkorchid',
            'darkred',
            'darksalmon',
            'darkseagreen',
            'darkslateblue',
            'darkslategray',
            'darkslategrey',
            'darkturquoise',
            'darkviolet',
            'deeppink',
            'deepskyblue',
            'dimgray',
            'dimgrey',
            'dodgerblue',
            'firebrick',
            'floralwhite',
            'forestgreen',
            'fuchsia',
            'gainsboro',
            'ghostwhite',
            'gold',
            'goldenrod',
            'gray',
            'grey',
            'green',
            'greenyellow',
            'honeydew',
            'hotpink',
            'indianred',
            'indigo',
            'ivory',
            'khaki',
            'lavender',
            'lavenderblush',
            'lawngreen',
            'lemonchiffon',
            'lightblue',
            'lightcoral',
            'lightcyan',
            'lightgoldenrodyellow',
            'lightgray',
            'lightgrey',
            'lightgreen',
            'lightpink',
            'lightsalmon',
            'lightseagreen',
            'lightskyblue',
            'lightslategray',
            'lightslategrey',
            'lightsteelblue',
            'lightyellow',
            'lime',
            'limegreen',
            'linen',
            'magenta',
            'maroon',
            'mediumaquamarine',
            'mediumblue',
            'mediumorchid',
            'mediumpurple',
            'mediumseagreen',
            'mediumslateblue',
            'mediumspringgreen',
            'mediumturquoise',
            'mediumvioletred',
            'midnightblue',
            'mintcream',
            'mistyrose',
            'moccasin',
            'navajowhite',
            'navy',
            'oldlace',
            'olive',
            'olivedrab',
            'orange',
            'orangered',
            'orchid',
            'palegoldenrod',
            'palegreen',
            'paleturquoise',
            'palevioletred',
            'papayawhip',
            'peachpuff',
            'peru',
            'pink',
            'plum',
            'powderblue',
            'purple',
            'red',
            'rosybrown',
            'royalblue',
            'saddlebrown',
            'salmon',
            'sandybrown',
            'seagreen',
            'seashell',
            'sienna',
            'silver',
            'skyblue',
            'slateblue',
            'slategray',
            'slategrey',
            'snow',
            'springgreen',
            'steelblue',
            'tan',
            'teal',
            'thistle',
            'tomato',
            'turquoise',
            'violet',
            'wheat',
            'white',
            'whitesmoke',
            'yellow',
            'yellowgreen'
        );

        if (preg_match('/^#?([[:xdigit:]]{3}){1,2}$/', $data)) {
            if (strpos($data, '#') !== 0) {
                $data = '#' . $data;
            }
            return $data;
        } else if (in_array(strtolower($data), $colornames)) {
            return $data;
        } else if (preg_match('/rgb\(\d{0,3}%?\, ?\d{0,3}%?, ?\d{0,3}%?\)/i', $data)) {
            return $data;
        } else if (preg_match('/rgba\(\d{0,3}%?\, ?\d{0,3}%?, ?\d{0,3}%?\, ?\d(\.\d)?\)/i', $data)) {
            return $data;
        } else if (preg_match('/hsl\(\d{0,3}\, ?\d{0,3}%, ?\d{0,3}%\)/i', $data)) {
            return $data;
        } else if (preg_match('/hsla\(\d{0,3}\, ?\d{0,3}%,\d{0,3}%\, ?\d(\.\d)?\)/i', $data)) {
            return $data;
        } else if (($data == 'transparent') || ($data == 'currentColor') || ($data == 'inherit')) {
            return $data;
        } else {
            return false;
        }
    }
}
