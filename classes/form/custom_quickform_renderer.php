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

namespace block_compviz\form;
/**
 * TODO describe file check_template
 *
 * @package    block_compviz
 * @copyright  2025 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


/**
 * Custom QuickForm renderer for block_compviz forms.
 *
 * Renders bccolorpicker elements using the block renderer/template, and
 * falls back to the default renderer for other elements.
 */
class custom_quickform_renderer extends \MoodleQuickForm_Renderer {

    /**
     * Render a single element. Intercepts colorpicker elements.
     *
     * @param object &$element
     * @param bool $required
     * @param string $error
     */
    public function renderElement(&$element, $required, $error) {
        // Try to identify the element type.
        $type = null;
        if (is_object($element) && method_exists($element, 'getType')) {
            $type = $element->getType();
        }

        $classname = is_object($element) ? get_class($element) : '';

        // If this is our custom colorpicker element, render via block renderer.
        if ($type === 'bccolorpicker' || stripos($classname, 'bccolorpicker') !== false) {
            // Attempt to get the block renderer and render the template.
            global $PAGE;
            try {
                $blockrenderer = $PAGE->get_renderer('block_compviz');
                if ($blockrenderer && method_exists($blockrenderer, 'render_colorpicker_element')) {
                    if (in_array($element->getName(), $this->_stopFieldsetElements) && $this->_fieldsetsOpen > 0) {
                        $this->_html .= $this->_closeFieldsetTemplate;
                        $this->_fieldsetsOpen--;
                    }
                    $this->_html .= $blockrenderer->render_colorpicker_element($element);
                    return;
                }
            } catch (\Throwable $e) {
                // Ignore and fall back to default renderer.
            }
        }

        // Default render for other elements.
        parent::renderElement($element, $required, $error);
    }



}
