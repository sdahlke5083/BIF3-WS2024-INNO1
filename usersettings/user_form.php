<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.
//
// More information: https://docs.moodle.org/dev/String_API/

/**
 * Plugin strings are defined here.
 *
 * @package     block_compviz
 * @category    string
 * @copyright   2024 BIF-INNO-Group10
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/formslib.php');

class block_compviz_user_form extends moodleform
{
    public function definition()
    {
        $mform = $this->_form;

        // Add a header.
        $mform->addElement('header', 'user_settings', get_string('pluginname', 'block_compviz'));

        // Add a checkbox for enabling the skills overview block.
        $mform->addElement('checkbox', 'enabled', get_string('enabled', 'block_compviz'));
        $mform->setDefault('enabled', 1);
        $mform->addHelpButton('enabled', 'enabled', 'block_compviz');

        // Add a checkbox for showing completed skills.
        $mform->addElement('checkbox', 'show_completed', get_string('show_completed', 'block_compviz'));
        $mform->setDefault('show_completed', 1);
        $mform->addHelpButton('show_completed', 'show_completed', 'block_compviz');
        
        // Add a button to save the settings.
        $this->add_action_buttons();
    }
}