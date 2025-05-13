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

require_once(__DIR__ . '/../../../config.php');
require_once(__DIR__ . '/user_form.php');
require_login();

$context   = context_user::instance($USER->id);

$PAGE->set_context($context);
$PAGE->set_pagelayout('popup');
$PAGE->set_url(new moodle_url('/blocks/compviz/settings/user_settings.php'));
$PAGE->set_title(get_string('usersettings', 'block_compviz'));

$form = new block_compviz_user_form(null, null, 'post', '', null, true, ['id' => 'usersettings']);

$returnurl = optional_param('returnurl', '/', PARAM_LOCALURL);

if ($form->is_cancelled()) {
    //redirect(required_param('returnurl', PARAM_LOCALURL));
    redirect($returnurl, '', 0, \core\output\notification::NOTIFY_INFO);
} else if ($data = $form->get_data()) {
    set_user_preference('block_compviz_enabled', $data->enabled);
    set_user_preference('block_compviz_show_completed', $data->show_completed);
    redirect($returnurl, '', 0, \core\output\notification::NOTIFY_SUCCESS);
} else{
    // If the form is not submitted, we need to set the default values.
    $form->set_data([
        'enabled' => get_user_preferences('block_compviz_enabled', 1),
        'show_completed' => get_user_preferences('block_compviz_show_completed', 1),
    ]);
    $form->display();
}
