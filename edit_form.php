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

/**
 * Form for editing compviz block instances.
 *
 * @package     block_compviz
 * @copyright   2024 BIF-INNO-Group10
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->dirroot . '/blocks/compviz/db/display_data.php');
class block_compviz_edit_form extends block_edit_form {

    /**
     * Extends the system(?) wide configuration form for block_compviz.
     *
     * @param MoodleQuickForm $mform The form being built.
     */
    protected function specific_definition($mform) {

        // Section header title.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // demo setting "enable"
        //$mform->addElement('selectyesno', 'config_enable', get_string('enabled', 'block_compviz'));
        //$mform->setDefault('config_enable', true);
        //$mform->setType('config_enable', PARAM_BOOL);


        $options = block_compviz_get_current_course_learning_outcomes_category();
        $default = block_compviz_get_default_leo_category();

        $mform->addElement('select', 'config_select_leo', get_string('select_leo', 'block_compviz'), $options);
        $mform->setType('config_select_leo', PARAM_INT);
        $mform->addHelpButton('config_select_leo', 'select_leo', 'block_compviz');
        $mform->setDefault('config_select_leo', $default);
        
    


        // Please keep in mind that all elements defined here must start with 'config_'.

    }
}
