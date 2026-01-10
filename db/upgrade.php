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
 * Plugin upgrade steps are defined here.
 *
 * @package     block_compviz
 * @category    upgrade
 * @copyright   2024 BIF-INNO-Group10
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Execute block_compviz upgrade from the given old version.
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_block_compviz_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    // For further information please read {@link https://docs.moodle.org/dev/Upgrade_API}.
    //
    // You will also have to create the db/install.xml file by using the XMLDB Editor.
    // Documentation for the XMLDB Editor can be found at {@link https://docs.moodle.org/dev/XMLDB_editor}.

    if ($oldversion < 2025052002) {

        // Define table block_compviz_colors to be created.
        $table = new xmldb_table('block_compviz_colors');

        // Adding fields to table block_compviz_colors.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '50', null, XMLDB_NOTNULL, null, null);
        $table->add_field('description', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('color1', XMLDB_TYPE_CHAR, '6', null, XMLDB_NOTNULL, null, null);
        $table->add_field('color2', XMLDB_TYPE_CHAR, '6', null, XMLDB_NOTNULL, null, null);
        $table->add_field('color3', XMLDB_TYPE_CHAR, '6', null, XMLDB_NOTNULL, null, null);
        $table->add_field('color4', XMLDB_TYPE_CHAR, '6', null, XMLDB_NOTNULL, null, null);
        $table->add_field('color5', XMLDB_TYPE_CHAR, '6', null, XMLDB_NOTNULL, null, null);
        $table->add_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table block_compviz_colors.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('usermodified', XMLDB_KEY_FOREIGN, ['usermodified'], 'user', ['id']);

        // Conditionally launch create table for block_compviz_colors.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Insert default values into the 'block_compviz_colors' table.
        $defaultcolorthemes = [
            ['id' => 1, 'name' => 'Default', 'color1' => '40916C', 'color2' => '52b788', 'color3' => '74c69d', 'color4' => 'b7e4c7', 'color5' => 'D8F3DC'],
            ['id' => 2, 'name' => 'Violet Dream', 'color1' => '6470F5', 'color2' => '9598F5', 'color3' => 'C16BF5', 'color4' => 'E19DF5', 'color5' => 'E7C1F4'],
            ['id' => 3, 'name' => 'Vivid Pop', 'color1' => '648FFF', 'color2' => '785EF0', 'color3' => 'DC267F', 'color4' => 'FE6100', 'color5' => 'FFB000'],
            ['id' => 4, 'name' => 'Aqua Rose', 'color1' => '507D87', 'color2' => '31A1AE', 'color3' => 'FFA6B0', 'color4' => 'FF5C61', 'color5' => 'D73E41'],
            ['id' => 5, 'name' => 'Fresh Meadow', 'color1' => '78AD00', 'color2' => 'A5D722', 'color3' => 'BEED53', 'color4' => 'D6FA8C', 'color5' => 'EEFFBA'],
        ];

        foreach ($defaultcolorthemes as $color) {
            $record = new stdClass();
            $record->id = $color['id'];
            $record->name = $color['name'];
            $record->color1 = $color['color1'];
            $record->color2 = $color['color2'];
            $record->color3 = $color['color3'];
            $record->color4 = $color['color4'];
            $record->color5 = $color['color5'];
            $DB->insert_record('block_compviz_colors', $record, false);
        }

        // Block compviz savepoint reached.
        upgrade_block_savepoint(true, 2025052002, 'compviz');
    }

    return true;
}

