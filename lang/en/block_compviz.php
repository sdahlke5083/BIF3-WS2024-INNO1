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

// strings for the user settings form
$string['usersettings'] = 'Settings';
$string['show_completed'] = 'Show completed skills';
$string['show_completed_help'] = 'Show or Hide completed skills in the skills overview block.';

// strings for the privacy provider
$string['privacy:metadata:block_compviz_enabled'] = 'The user preference for enabling the skills overview block.';
$string['privacy:metadata:block_compviz_show_completed'] = 'The user preference for showing completed skills in the skills overview block.';
$string['privacy:metadata:block_compviz'] = 'The Competence Visualization block stores user preferences for enabling the block and showing completed skills.';