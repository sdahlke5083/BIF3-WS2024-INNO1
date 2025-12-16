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
 * check if the template for colorpicker element exists
 *
 * @package    block_compviz
 * @copyright  2025 Sebastian Dahlke <if23b234@technikum-wien.at>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define('CLI_SCRIPT', true);
use core\output\mustache_template_finder;

require_once(__DIR__ . '/../../../config.php');
try {
    // First, check the file directly in the plugin folder as a quick sanity check.
    $direct = $CFG->dirroot . '/blocks/compviz/templates/form/element-bccolorpicker.mustache';
    if (is_readable($direct)) {
        echo 'Direct file found: ' . $direct . PHP_EOL;
    } else {
        echo 'Direct file NOT found at: ' . $direct . PHP_EOL;
    }

    // Use the namespaced class constant for clearer code.
    if (class_exists(mustache_template_finder::class)) {
        try {
            $tpl = mustache_template_finder::get_template_filepath('block_compviz/form/element-bccolorpicker');
            echo "Finder found: {$tpl}" . PHP_EOL;
        } catch (\Exception $e) {
            echo 'Finder threw: ' . $e->getMessage() . PHP_EOL;
        }
    } else {
        echo mustache_template_finder::class . ' not available in this CLI environment.' . PHP_EOL;
    }
} catch (Exception $e) {
    echo 'Exception: ' . $e->getMessage() . PHP_EOL;
}