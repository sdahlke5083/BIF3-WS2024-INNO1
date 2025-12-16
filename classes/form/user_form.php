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
use MoodleQuickForm;
use core\context\user as context_user;

defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once "{$CFG->dirroot}/blocks/compviz/db/display_data.php";

class user_form extends dynamic_form
{

    /**
     * Display the form using a custom QuickForm renderer so we can intercept
     * colorpicker elements and render them with the plugin template.
     */
    public function display() {
        global $CFG;
        require_once($CFG->dirroot . '/blocks/compviz/classes/form/custom_quickform_renderer.php');

        $renderer = new \block_compviz\form\custom_quickform_renderer();

        // The QuickForm object is stored in $this->_form by dynamic_form.
        if (isset($this->_form) && is_object($this->_form)) {
            $this->_form->accept($renderer);
            echo $renderer->toHtml();
            return;
        }

        // Fallback: use parent display if something unexpected occurs.
        parent::display();
    }

    public function definition()
    {
        global $CFG;
        $mform = $this->_form;

        // Add a color picker for custom color selection (hex code).
        // register the custom color picker element type.
        MoodleQuickForm::registerElementType(
            // This is the element name used in the `addElement()` function.
            'bccolorpicker',
            // The path to the class file.
            "{$CFG->dirroot}/blocks/compviz/classes/form/colorpicker_form_element.php",
            // The class name that implements the element.
            'MoodleQuickForm_bccolorpicker'
        );


        // Add a header.
        $mform->addElement('header', 'user_settings', get_string('pluginname', 'block_compviz'));

        // Add a checkbox for showing completed skills.
        $mform->addElement('checkbox', 'show_completed', get_string('show_completed', 'block_compviz'));
        $mform->setDefault('show_completed', 1);
        $mform->addHelpButton('show_completed', 'show_completed', 'block_compviz');


        // Add a radio group to choose between theme or custom color.
        $radioarray = [];
        $radioarray[] = $mform->createElement('radio', 'color_mode', '', get_string('usetheme', 'block_compviz'), 'theme');
        $radioarray[] = $mform->createElement('radio', 'color_mode', '', get_string('usecolorpicker', 'block_compviz'), 'custom');
        $mform->addGroup($radioarray, 'color_mode_group', get_string('colormode', 'block_compviz'), [' '], false);
        $mform->setDefault('color_mode', 'theme');
        $mform->addHelpButton('color_mode_group', 'colormode', 'block_compviz');

        // Add dropdown to select what Color theme to use
        $options = block_compviz_get_color_themes();
        $options = $this->convert_to_choicelist($options);
        $mform->addElement('choicedropdown', 'theme', get_string('theme', 'block_compviz'), $options );
        $mform->setType('theme', PARAM_INT);
        $mform->setDefault('theme', 1);
        #$mform->addHelpButton('theme', 'theme', 'block_compviz');
        $mform->hideIf('theme', 'color_mode', 'neq', 'theme');
        
        // add 5 custom color options as text fields for custom color selection and group them.
        for ($i = 1; $i <= 5; $i++) {
            $mform->addElement('bccolorpicker', "custom_color_$i", get_string("custom_color_$i", 'block_compviz'));
            $mform->setType("custom_color_$i", PARAM_RAW_TRIMMED);
            $colorindex = $i - 1;
            $mform->setDefault("custom_color_$i", "#{$colorindex}0ff{$colorindex}0");
            $mform->addHelpButton("custom_color_$i", "custom_color_$i", 'block_compviz');
            $mform->hideIf("custom_color_$i", 'color_mode', 'neq', 'custom');
        }

        // Add a button to save the settings.
        /* $this->add_action_buttons(); */

    }

    protected function get_context_for_dynamic_submission(): \context
    {
        global $USER;
        return context_user::instance($USER->id);
    }

    public function check_access_for_dynamic_submission(): void
    {
        // no rights check required
    }

    public function set_data_for_dynamic_submission(): void
    {
        global $USER;
        $data = new \stdClass();
        $data->show_completed = get_user_preferences('block_compviz_show_completed', 1, $USER->id);
        $data->theme = get_user_preferences('block_compviz_theme', 1, $USER->id);
        $data->color_mode = get_user_preferences('block_compviz_color_mode', 'theme', $USER->id);
        $data->custom_color_1 = get_user_preferences('block_compviz_custom_color_1', '#ff0000', $USER->id);
        $data->custom_color_2 = get_user_preferences('block_compviz_custom_color_2', '#00ff00', $USER->id);
        $data->custom_color_3 = get_user_preferences('block_compviz_custom_color_3', '#0000ff', $USER->id);
        $data->custom_color_4 = get_user_preferences('block_compviz_custom_color_4', '#ffff00', $USER->id);
        $data->custom_color_5 = get_user_preferences('block_compviz_custom_color_5', '#ff00ff', $USER->id);
        $this->set_data($data);
    }

    public function process_dynamic_submission(): array
    {
        global $USER;
        $data = (object)$this->get_data();
        if ($data) {
            set_user_preference('block_compviz_show_completed', $data->show_completed ?? 0, $USER->id);
            set_user_preference('block_compviz_theme', $data->theme ?? 1, $USER->id);
            set_user_preference('block_compviz_color_mode', $data->color_mode ?? 'theme', $USER->id);
            // save custom colors
            set_user_preference('block_compviz_custom_color_1', $data->custom_color_1 ?? '#ff0000', $USER->id);
            set_user_preference('block_compviz_custom_color_2', $data->custom_color_2 ?? '#00ff00', $USER->id);
            set_user_preference('block_compviz_custom_color_3', $data->custom_color_3 ?? '#0000ff', $USER->id);
            set_user_preference('block_compviz_custom_color_4', $data->custom_color_4 ?? '#ffff00', $USER->id);
            set_user_preference('block_compviz_custom_color_5', $data->custom_color_5 ?? '#ff00ff', $USER->id);
            return ['success' => true, 'message' => get_string('settingssaved', 'block_compviz')];
        } else {
            return ['success' => false, 'message' => get_string('settingsnotsaved', 'block_compviz')];
        }
    }

    protected function get_page_url_for_dynamic_submission(): \moodle_url
    {
        return new \moodle_url('/course');
    }

    private function convert_to_choicelist($array)
    {

        // Define the options for the dropdown list.
        $choicelist = new \core\output\choicelist();
        
        foreach ($array as $key => $item) {
            $choicelist->add_option(
                $key,
                $item['name'],
                [
                    'description' => '0%'.
                                     '<span class="color-preview-box" style="--bg-color:#' . $item['color5'] . ';">20%</span>' .
                                     '<span class="color-preview-box" style="--bg-color:#' . $item['color4'] . ';">40%</span>' .
                                     '<span class="color-preview-box" style="--bg-color:#' . $item['color3'] . ';">60%</span>' .
                                     '<span class="color-preview-box" style="--bg-color:#' . $item['color2'] . ';">80%</span>' .
                                     '<span class="color-preview-box" style="--bg-color:#' . $item['color1'] . ';">100%</span>',
                ]
            );
        }
        return $choicelist;
    }
}
