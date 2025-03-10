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
 * DB queries for the compviz block located here
 *
 * @package     block_compviz
 * @category    access
 * @copyright   2024 BIF-INNO-Group10
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Demo to verify and show how to use Data manipulation API
 */
function block_compviz_get_display_data()
{
    global $DB, $COURSE, $USER;

    // SQL to join grade_items and grade_grades tables and filter by course and user
    $sql = "SELECT gg.id, gg.finalgrade, gg.rawgrade, gg.timemodified, gi.itemname, gi.sortorder, gg.rawgrademax, gg.rawgrademin
        FROM {grade_grades} gg
        JOIN {grade_items} gi ON gg.itemid = gi.id
        WHERE gi.courseid = :courseid
          AND gg.userid = :userid
          AND gi.hidden = 0
          AND gi.itemtype = 'mod'
        ORDER BY gi.sortorder ASC";

    // Parameters for the query
    $params = array('courseid' => $COURSE->id, 'userid' => $USER->id);

    // Execute the query
    $gradings = $DB->get_records_sql($sql, $params);

    // Return first grading if exists
    if (!empty($gradings)) {
        return (array) $gradings;
    }
    return array();
}

// Example function to get Moodle version from the database
function block_compviz_get_moodle_version_from_db() {
    global $DB;
    $version_record = $DB->get_record('config', array('name' => 'version'), '*', MUST_EXIST);
    return $version_record->value;
}