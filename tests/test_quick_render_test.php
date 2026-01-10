<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Quick render test for the user form in block_compviz.
 *
 * @package    block_compviz
 * @copyright  2025 Sebastian Dahlke <if23b234@technikum-wien.at>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/blocks/compviz/classes/form/user_form.php');

use block_compviz\form\user_form;

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/blocks/compviz/tests/quickrender.php'));
$PAGE->set_title('Compviz quick render demo');
$PAGE->set_heading('Compviz quick render demo');

// Show header.
echo $OUTPUT->header();

// Instantiate and display the form for testing.
$mform = new user_form();
$mform->display();

// Footer.
echo $OUTPUT->footer();
