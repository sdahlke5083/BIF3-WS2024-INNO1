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

//defined('MOODLE_INTERNAL') || die();

// predefined and basic required strings
$string['pluginname'] = 'Competence Visualization';
$string['compviz:show_graph'] = 'Show Grading Graph';
$string['compviz:addinstance'] = 'Add new Competence Visualization block';
$string['compviz:myaddinstance'] = 'Add new CompViz Block to My Moodle page';
// strings for the block
$string['skills_overview'] = 'Skills Overview';
$string['enabled'] = 'Enable';
$string['enabled_desc'] = 'Enable the skills overview block on the course page.';
$string['enabled_help'] = 'Enable the skills overview block on the course page.';
$string['admin_settings_desc'] = 'Info:';
$string['admin_settings_desc_desc'] = 'PoC for the global settings for the Competence Visualization block. Has currently no effect on the block itself.';

// strings for the settings form
$string['select_leo'] = 'Select Learning Outcome Category';
$string['select_leo_desc'] = 'Select the Learning Outcome Category for the skills overview block.';
$string['select_leo_help'] = 'Select a Grading Category for the skills overview block. This will be used to display the skills in the block.';

// strings for the user settings form
$string['usersettings'] = 'Settings';
$string['show_completed'] = 'Show completed skills';
$string['show_completed_help'] = 'Show or Hide completed skills in the skills overview block.';
$string['theme'] = 'Color Theme';
$string['theme_help'] = 'Select a color theme of your liking for the progress bars.s';
$string['settingssaved'] = 'User settings saved.';
$string['settingsnotsaved'] = 'User settings could not be saved.';

// strings for the privacy provider
$string['privacy:metadata:block_compviz_enabled'] = 'The user preference for enabling the skills overview block.';
$string['privacy:metadata:block_compviz_show_completed'] = 'The user preference for showing completed skills in the skills overview block.';
$string['privacy:metadata:block_compviz'] = 'The Competence Visualization block stores user preferences for enabling the block and showing completed skills.';

// strings for the colorpicker
$string['pluginname']        = 'Competence Visualization';
$string['enabled']           = 'Enable';
$string['show_completed']    = 'Show completed skills';
$string['colormode']         = 'Color mode';
$string['usetheme']          = 'Use theme colors';
$string['usecolorpicker']    = 'Use custom colors';
$string['theme']             = 'Color theme';
$string['custom_color_1']    = 'Color 1';
$string['custom_color_2']    = 'Color 2';
$string['custom_color_3']    = 'Color 3';
$string['custom_color_4']    = 'Color 4';
$string['custom_color_5']    = 'Color 5';
$string['custom_color']      = 'Primary color';
$string['settingssaved']     = 'Settings saved';
$string['settingsnotsaved']  = 'Settings could not be saved';
$string['colormode_help']         = 'Choose between using your site’s theme colors or custom colors.';
$string['usetheme_help']          = 'When selected, the block will use the current Moodle theme colors.';
$string['usecolorpicker_help']    = 'When selected, you can enter your own custom hex-colors below.';
$string['theme_help']             = 'Select one of the predefined color palettes for the visualization.';
$string['custom_color_1_help']    = 'Perfect';
$string['custom_color_2_help']    = 'Almost Perfect';
$string['custom_color_3_help']    = 'Passed';
$string['custom_color_4_help']    = 'Almost Passed';
$string['custom_color_5_help']    = 'Failed';
$string['custom_color_help']      = 'Primary hex color used when custom colors are enabled.';
