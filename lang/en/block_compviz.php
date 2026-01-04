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

// Predefined / Basic required strings
$string['compviz:addinstance'] = 'Add new Competence Visualization block';
$string['compviz:myaddinstance'] = 'Add new CompViz Block to My Moodle page';
$string['compviz:show_graph'] = 'Show Grading Graph';
$string['pluginname'] = 'Competence Visualization';
// Block strings
$string['admin_settings_desc'] = 'Info:';
$string['admin_settings_desc_desc'] = 'Global settings for the Competence Visualization block.';
$string['enabled'] = 'Enable';
$string['enabled_desc'] = 'Enable the skills overview block on the course page.';
$string['enabled_help'] = 'Enable the skills overview block on the course page.';
$string['no_leo'] = 'No Learning Outcome Categories found.';
$string['no_subskills'] = 'No visible sub-skills found for this Learning Outcome Category.';
$string['skills_overview'] = 'Skills Overview';

// Settings form strings
$string['select_leo'] = 'Select Learning Outcome Category';
$string['select_leo_desc'] = 'Select the Learning Outcome Category for the skills overview block.';
$string['select_leo_help'] = 'Select a Grading Category for the skills overview block. This will be used to display the skills in the block.';

// User settings form strings
$string['appearance'] = 'Appearance';
$string['color_settings_desc'] = 'Appearance settings control how progress bars and charts are colored in your view. You can use site theme colors or create a personal palette using the color pickers below.';
$string['settingsnotsaved'] = 'User settings could not be saved.';
$string['settingssaved'] = 'User settings saved.';
$string['show_completed'] = 'Show completed skills';
$string['show_completed_help'] = 'When enabled, completed skills will be visible in your Skills Overview. When disabled, only incomplete or in-progress skills are shown so you can focus on outstanding items.';
$string['theme'] = 'Color theme';
$string['theme_help'] = 'Choose a saved color theme to render progress bars. This option is only active when "Use theme colors" is selected in the Color mode setting.';
$string['usersettings'] = 'CompViz settings';
$string['usersettings_desc'] = 'Configure your personal CompViz preferences. These settings only affect your account and do not change how other users see the block.';

// Privacy provider strings
$string['privacy:metadata:block_compviz'] = 'The Competence Visualization block stores user preferences for enabling the block and showing completed skills.';
$string['privacy:metadata:block_compviz_enabled'] = 'The user preference for enabling the skills overview block.';
$string['privacy:metadata:block_compviz_show_completed'] = 'The user preference for showing completed skills in the skills overview block.';

// Color / appearance strings (colorpicker)
$string['colormode'] = 'Color mode';
$string['colormode_help'] = 'Choose whether the block should use your site theme colors (recommended) or allow you to enter custom hex color values. Changes here affect only your personal view.';
$string['custom_color_1'] = 'Progress Color highest';
$string['custom_color_1_help'] = 'Highest achievement color (at least 80% done). Choose using the color picker.';
$string['custom_color_2'] = 'Progress Color high';
$string['custom_color_2_help'] = 'Second-highest achievement color (at least 60% done). Choose using the color picker.';
$string['custom_color_3'] = 'Progress Color medium';
$string['custom_color_3_help'] = 'Medium achievement color (at least 40% done). Choose using the color picker.';
$string['custom_color_4'] = 'Progress Color low';
$string['custom_color_4_help'] = 'Second-lowest achievement color (at least 20% done). Choose using the color picker.';
$string['custom_color_5'] = 'Progress Color lowest';
$string['custom_color_5_help'] = 'Lowest achievement color (below 20% done). Choose using the color picker.';
$string['custom_color_completed'] = 'Passed color';
$string['custom_color_failed'] = 'Failed color';
$string['custom_color_help'] = 'Primary hex color used when custom colors are enabled.';
$string['usecolorpicker'] = 'Use custom colors';
$string['usecolorpicker_help'] = 'When selected, enter custom hex color values in the fields below to define your personal color palette for progress indicators.';
$string['usetheme'] = 'Use theme colors';
$string['usetheme_help'] = 'When selected, the CompViz block will use the current Moodle theme color palette for graphs and bars. Theme colors are maintained by your site administrator.';

// Completion labels for quiz prefix
$string['completion_completed'] = 'Completed';
$string['completion_failed'] = 'Failed';
$string['completion_notcompleted'] = 'Not completed';
$string['completion_passed'] = 'Passed';
