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
 * Code to be executed after the plugin's database scheme has been installed is defined here.
 *
 * @package     block_compviz
 * @category    upgrade
 * @copyright   2024 BIF-INNO-Group10
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @link        https://moodledev.io/docs/4.5/guides/upgrade
 */

/**
 * Custom code to be run on installing the plugin.
 */
function xmldb_block_compviz_install() {

    global $DB;
    
    // Insert default values into the 'block_compviz_colors' table.
    $defaultcolorthemes = [
        ['name' => 'Default', 'color1' => '40916C', 'color2' => '52b788', 'color3' => '74c69d', 'color4' => 'b7e4c7', 'color5' => 'D8F3DC'],
        ['name' => 'Violet Dream', 'color1' => '6470F5', 'color2' => '9598F5', 'color3' => 'C16BF5', 'color4' => 'E19DF5', 'color5' => 'E7C1F4'],
        ['name' => 'Vivid Pop', 'color1' => '648FFF', 'color2' => '785EF0', 'color3' => 'DC267F', 'color4' => 'FE6100', 'color5' => 'FFB000'],
        ['name' => 'Aqua Rose', 'color1' => '507D87', 'color2' => '31A1AE', 'color3' => 'FFA6B0', 'color4' => 'FF5C61', 'color5' => 'D73E41'],
        ['name' => 'Fresh Meadow', 'color1' => '78AD00', 'color2' => 'A5D722', 'color3' => 'BEED53', 'color4' => 'D6FA8C', 'color5' => 'EEFFBA'],
    ];

    foreach ($defaultcolorthemes as $color) {
        $record = new stdClass();
        $record->name = $color['name'];
        $record->color1 = $color['color1'];
        $record->color2 = $color['color2'];
        $record->color3 = $color['color3'];
        $record->color4 = $color['color4'];
        $record->color5 = $color['color5'];
        $DB->insert_record('block_compviz_colors', $record, false);
    }

    return true;
}
