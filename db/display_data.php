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

// Example function to get Moodle version from the database to check functionality
function block_compviz_get_moodle_version_from_db()
{
    global $DB;
    $version_record = $DB->get_record('config', array('name' => 'version'), '*', MUST_EXIST);
    return $version_record->value;
}

/**
 * Get all categories for the current course that have subcategories
 * This is used to find the category that contains the learning outcomes
 *
 * @return array An array of categories with their details or an empty array if none found
 * @throws dml_exception
 */
function block_compviz_get_current_course_learning_outcomes_category()
{
    global $DB, $COURSE;

    // Using subquery to find categories with subcategories
    $sql = "SELECT gc.id, 
            CASE 
                WHEN gc.parent IS NULL
                    THEN (SELECT c.fullname FROM {course} c WHERE c.id = gc.courseid)
                ELSE gc.fullname
            END AS fullname
        FROM {grade_categories} gc
        WHERE gc.courseid = :courseid
          AND (SELECT COUNT(*) FROM {grade_categories} gc_sub WHERE gc_sub.parent = gc.id) > 0
        ORDER BY gc.id ASC";

    // Parameters for the query
    $params = [
        'courseid' => $COURSE->id
    ];

    // Execute the query
    $leos = $DB->get_records_sql($sql, $params);

    // convert to key => value array
    $array = [];
    foreach ($leos as $leo) {
        $array[$leo->id] = $leo->fullname;
    }

    // if this returns an empty array, this course can't be used for LEO's & µLEO's -> see Readme
    if (!empty($leos)) {
        return (array) $array;
    }
    return [];
}

function block_compviz_get_current_course_category()
{
    global $DB, $COURSE;

    // SQL to get the course as category
    $sql = "SELECT gc.id, gc.fullname as name
        FROM {grade_categories} gc
        WHERE gc.courseid = :courseid
          AND gc.parent IS NULL
        ORDER BY gc.id ASC";

    // Parameters for the query
    $params = [
        'courseid' => $COURSE->id
    ];

    // Execute the query
    $course_category = $DB->get_record_sql($sql, $params);

    // Return first grading if exists
    if (!empty($course_category)) {
        return $course_category;
    }
    throw new dml_read_exception('No categorie for course found!', $sql, $params);
}

// Try to get default LEO category from the database
function block_compviz_get_default_leo_category()
{
    $possible_leos = block_compviz_get_current_course_learning_outcomes_category();
    $leo_category = null;
    if (!empty($possible_leos)) {
        // search for a category with the name "LEO" or "Learning Outcomes"
        foreach ($possible_leos as $leo=>$leo_name) {
            $leo_name_lower = strtolower($leo_name);
            if (stripos($leo_name_lower, 'leo') !== false || stripos($leo_name_lower, 'learning outcomes') !== false) {
                $leo_category = $leo;
                break;
            }
        }

    }
    if ($leo_category == null) {
        // if no category was found, choose the course category as default
        $leo_category = block_compviz_get_current_course_category()->id;
    }

    return $leo_category;
}

// Get LEO's (which will be grading_categories) from the database
function block_compviz_get_current_user_leos(int|null $parent_category_id = null)
{
    global $DB, $COURSE, $USER;

    //
    if($parent_category_id == null) {
        $parent_category_id = block_compviz_get_current_course_category()->id;
    }

    // SQL to join grade_items and grade_categories tables and filter by course
    $sql = "SELECT gc.id, gc.fullname as name, gi.grademax, gi.grademin,
        CASE
            WHEN gg.finalgrade IS NOT NULL 
                THEN gg.finalgrade
        END AS finalgrade
        FROM {grade_categories} gc
        JOIN {grade_items} gi 
        ON gi.iteminstance = gc.id
            AND gi.itemtype = 'category'
            AND gi.hidden = 0
        LEFT JOIN {grade_grades} gg
        ON gg.itemid = gi.id
            AND gg.userid = :userid
            AND gg.hidden = 0
        WHERE gc.parent = :parentcategoryid
            AND gc.courseid = :courseid
            AND gc.hidden = 0
        ORDER BY gi.sortorder ASC;";

    // Parameters for the query
    $params = [
        'courseid' => $COURSE->id,
        'userid' => $USER->id,
        'parentcategoryid' => $parent_category_id
    ];

    // Execute the query
    $leos = $DB->get_records_sql($sql, $params);

    // Return first grading if exists
    if (!empty($leos)) {
        return (array) $leos;
    }
    return [];
}

/** Get all grade_items for the current course and user
 * @param int|null $parent_categorie_id The ID of the parent category (=Learning Outcome) to filter by, or null for all categories
 * @return array An array of grade items with their details or an empty array if none found
 * @throws dml_exception
 */
function block_compviz_get_current_user_grade_items(int|null $parent_categorie_id = null)
{
    global $DB, $COURSE, $USER;

    // SQL to join grade_items -> modules -> course_modules, and filter by course and user
    $sql = "SELECT 
               gi.id,
               gi.categoryid,
               gi.itemname     AS name,
               COALESCE(gg.finalgrade, gi.grademin) AS finalgrade,
               gi.grademax,
               gi.grademin,
               gg.timemodified,
               gi.itemmodule,
               gi.iteminstance,
               cm.id          AS cmid
            FROM {grade_items} gi
            LEFT JOIN {grade_grades} gg 
              ON gg.itemid = gi.id 
             AND gg.userid = :userid
            LEFT JOIN {modules} m 
              ON m.name = gi.itemmodule
            LEFT JOIN {course_modules} cm 
              ON cm.module   = m.id 
             AND cm.instance = gi.iteminstance 
             AND cm.course   = gi.courseid
            WHERE gi.courseid = :courseid
              " . ($parent_categorie_id !== null 
                    ? "AND gi.categoryid = :parentcategoryid" 
                    : "") . "
              AND gi.hidden   = 0
              AND gi.itemtype = 'mod'
            ORDER BY gi.sortorder ASC";

    // Parameters for the query
    $params = [
        'courseid' => $COURSE->id,
        'userid' => $USER->id,
        'parentcategoryid' => $parent_categorie_id
    ];

    // Execute the query
    $gradings = $DB->get_records_sql($sql, $params);

    // Return result array
    return !empty($gradings) ? (array) $gradings : [];
}

/** Get all grade_items for the current course and user
 * @param int|null $leos_categorie_id The ID of the parent category (=Learning Outcome) to filter by, or null for all categories
 * @return array An array of grade items with their details or an empty array if none found
 * @throws dml_exception
 */
function block_compviz_get_current_user_grade_items_by_category(int $leos_categorie_id)
{
    // Get all LEOs aka categories
    $leos = block_compviz_get_current_user_leos($leos_categorie_id);

    $leos = array_values($leos);

    // Get all grade_items for each LEO and add them to the LEO object
    if (!empty($leos)) {
        foreach ($leos as $leo) {
            $items = block_compviz_get_current_user_grade_items($leo->id);
            $leo->grade_items = array_values($items);
        }
    }
    
    if (empty($leos)) {
        return [];
    }
    return $leos;

}

/**
 * Get all color themes from the database
 *
 * @return array An array of color themes with their details or an empty array if none found
 * @throws dml_exception
 */
function block_compviz_get_color_themes()
{
    global $DB;

    // SQL to get all color themes
    $sql = "SELECT id, name
            FROM {block_compviz_colors}
            ORDER BY id ASC";

    // Execute the query
    $color_themes = array_values($DB->get_records_sql($sql));

    $result = [];
    foreach($color_themes as $ct){
        $result[$ct->id] = $ct->name;
    }

    // Return result array
    return !empty($color_themes) ? (array) $result : [];
}

function block_compviz_get_colors($theme)
{
    global $DB;

    $sql = "SELECT color1, color2, color3, color4, color5
            FROM {block_compviz_colors}
            WHERE id = :themename
            LIMIT 1";
    
    $params = [
        'themename' => $theme
    ];

    $colors = array_values($DB->get_records_sql($sql, $params));

    return !empty($colors) ? (array) $colors[0] : [];
}


/**
 * Returns completion states for the given course module IDs (cmids) and user.
 * Key = cmid (int), Value = completionstate (int: 0..3)
 *
 * Table: course_modules_completion
 *  - completionstate:
 *      0 = incomplete
 *      1 = complete
 *      2 = complete-pass
 *      3 = complete-fail
 *
 * @param array $cmids
 * @param int $userid
 * @return array<int,int>
 */
function block_compviz_get_cm_completion_states_for_user(array $cmids, int $userid): array {
    global $DB;

    // Säubere die Liste der cmids.
    $cmids = array_values(array_filter(array_map('intval', $cmids)));
    if (empty($cmids)) {
        return [];
    }

    list($insql, $params) = $DB->get_in_or_equal($cmids, SQL_PARAMS_NAMED, 'cmid');
    $params['userid'] = $userid;

    $sql = "SELECT cmc.coursemoduleid AS cmid, cmc.completionstate AS state
              FROM {course_modules_completion} cmc
             WHERE cmc.userid = :userid
               AND cmc.coursemoduleid $insql";

    $records = $DB->get_records_sql($sql, $params);

    $map = [];
    foreach ($records as $rec) {
        $map[(int)$rec->cmid] = (int)$rec->state;
    }
    return $map;
}
