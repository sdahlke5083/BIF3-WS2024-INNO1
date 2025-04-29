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

namespace block_compviz\form;
use core_form\dynamic_form;

defined('MOODLE_INTERNAL') || die();

class user_form extends dynamic_form
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
        //$this->add_action_buttons();
    }

    protected function get_context_for_dynamic_submission(): \context
    {
        global $USER;
        return \context_user::instance($USER->id);
    }

    public function check_access_for_dynamic_submission(): void
    {
        // no rights check required
    }

    public function set_data_for_dynamic_submission(): void
    {
        global $USER;
        $data = new \stdClass();
        $data->enabled = get_user_preferences('block_compviz_enabled', 1, $USER->id);
        $data->show_completed = get_user_preferences('block_compviz_show_completed', 1, $USER->id);
        $this->set_data($data);
    }

    public function process_dynamic_submission(): array
    {
        global $USER;
        $data = (object)$this->get_data();
        if ($data) {
            set_user_preference('block_compviz_enabled', $data->enabled ?? 0, $USER->id);
            set_user_preference('block_compviz_show_completed', $data->show_completed ?? 0, $USER->id);
            return ['success' => true, 'message' => get_string('settingssaved', 'block_compviz')];
        } else {
            return ['success' => false, 'message' => get_string('settingsnotsaved', 'block_compviz')];
        }
    }

    protected function get_page_url_for_dynamic_submission(): \moodle_url
    {
        return new \moodle_url('/course');
    }
}