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

namespace block_compviz\privacy;
use core_privacy\local\metadata\collection;
use core_privacy\local\request\user_preference_provider;
use core_privacy\local\request\writer;

class provider implements user_preference_provider
{
    /**
     * Get the language string identifier for the component.
     *
     * @return string
     */
    public static function get_component_name()
    {
        return 'block_compviz';
    }

    /**
     * Get the language string identifier for the component.
     *
     * @param collection $collection The metadata collection to add to.
     * @return void
     */
    public static function get_metadata(collection $collection){
        $collection->add_user_preference(
            'block_compviz_enabled',
            'privacy:metadata:block_compviz_enabled'
        );
        $collection->add_user_preference(
            'block_compviz_show_completed',
            'privacy:metadata:block_compviz_show_completed'
        );
    }

    /**
     * Get the language string identifier for the component.
     *
     * @param collection $collection The metadata collection to add to.
     * @return void
     */
    public static function export_user_preferences(int $userid)
    {
       $prefs = [
            'block_compviz_enabled',
            'block_compviz_show_completed'
        ];

        foreach ($prefs as $key) {
            $value = get_user_preferences($key, null, $userid);
            if ($value !== null) {
                writer::export_user_preference(
                    '',
                    $key,
                    $value,
                    get_string('privacy:metadata:block_compviz_' . $key, 'block_compviz')
                );
            }
        } 
    }
}
