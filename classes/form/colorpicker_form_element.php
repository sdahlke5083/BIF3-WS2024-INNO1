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


    /**
     * Information for previewing the colour
     *
     * @var array|null
     */
    protected $previewconfig = null;

    /** 
     * Constructor for the colorpicker_form_element class.
     * 
     * @param string $name
     * @param string $visiblename
     * @param string $description
     */
    public function __construct($name, $visiblename, $description) {
        if ($name == null) {
            // This is broken quickforms messing with the constructors.
            return;
        }

        parent::__construct($name, $visiblename, $description);
        $this->set_force_ltr(true);
    }
}
