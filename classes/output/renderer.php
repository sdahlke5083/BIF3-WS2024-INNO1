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

namespace block_compviz\output;
/**
 * TODO describe file check_template
 *
 * @package    block_compviz
 * @copyright  2025 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
use core\output\plugin_renderer_base;
use core\output\templatable;
use core\output\mustache_template_finder;

/**
 * Renderer for block_compviz.
 *
 * Provides a method to render the custom colorpicker element using the
 * plugin's mustache template `block_compviz/form/element-colorpicker`.
 */
class renderer extends plugin_renderer_base {

    /**
     * Render a color picker form element using the plugin mustache template.
     * Mirrors the behaviour of core_renderer::mform_element() but targets
     * the plugin template.
     *
     * @param mixed $element The form element instance.
     * @return string|false HTML or false if template not found.
     */
    public function render_colorpicker_element($element) {
        $templatename = 'block_compviz/form/element-bccolorpicker';
        
        try {
            // Ensure the template exists; will throw if missing.
            mustache_template_finder::get_template_filepath($templatename);

            // If element provides export_for_template(), use it.
            if ($element instanceof templatable || method_exists($element, 'export_for_template')) {
                $elementcontext = $element->export_for_template($this);
            } else {
                // Build a minimal element context similar to templatable_form_element.
                $elementcontext = [];
                $standardattributes = ['id', 'name', 'label', 'multiple', 'checked', 'error', 'size', 'value', 'type'];
                foreach ($standardattributes as $attrname) {
                    $value = null;
                    if (is_object($element) && method_exists($element, 'getAttribute')) {
                        $value = $element->getAttribute($attrname);
                    } elseif (is_object($element) && property_exists($element, '_attributes') && isset($element->_attributes[$attrname])) {
                        $value = $element->_attributes[$attrname];
                    }
                    $elementcontext[$attrname] = $value;
                }

                // frozen/hardfrozen best-effort
                $elementcontext['frozen'] = (is_object($element) && isset($element->_flagFrozen)) ? !empty($element->_flagFrozen) : false;
                $elementcontext['hardfrozen'] = (is_object($element) && isset($element->_flagFrozen) && isset($element->_persistantFreeze)) ? (!empty($element->_flagFrozen) && empty($element->_persistantFreeze)) : false;

                // Other attributes
                $otherattributes = [];
                if (is_object($element) && method_exists($element, 'getAttributes')) {
                    foreach ($element->getAttributes() as $attr => $value) {
                        if (!in_array($attr, $standardattributes) && $attr != 'class' && $attr != 'parentclass' && !is_object($value)) {
                            $otherattributes[] = $attr . '="' . s($value) . '"';
                        }
                    }
                } elseif (is_object($element) && property_exists($element, '_attributes')) {
                    foreach ($element->_attributes as $attr => $value) {
                        if (!in_array($attr, $standardattributes) && $attr != 'class' && $attr != 'parentclass' && !is_object($value)) {
                            $otherattributes[] = $attr . '="' . s($value) . '"';
                        }
                    }
                }
                $elementcontext['attributes'] = implode(' ', $otherattributes);

                // iderror
                $id = isset($elementcontext['id']) ? $elementcontext['id'] : '';
                $iderror = preg_replace('/_id_/', '_id_error_', $id);
                $iderror = preg_replace('/^id_/', 'id_error_', $iderror);
                $elementcontext['iderror'] = $iderror;
            }

            // helpbutton, label, text
            $helpbutton = (is_object($element) && method_exists($element, 'getHelpButton')) ? $element->getHelpButton() : '';
            $label = (is_object($element) && method_exists($element, 'getLabel')) ? $element->getLabel() : '';
            $text = '';
            if (is_object($element) && method_exists($element, 'getText')) {
                if (empty($label)) {
                    $label = $element->getText();
                } else {
                    $text = $element->getText();
                }
            }

            // Wrapper id handling similar to core.
            if (is_array($elementcontext) && isset($elementcontext['type']) && $elementcontext['type'] === 'group') {
                $elementcontext['wrapperid'] = isset($elementcontext['id']) ? $elementcontext['id'] : '';
                if (isset($elementcontext['groupname'])) {
                    $elementcontext['name'] = $elementcontext['groupname'];
                }
            } else {
                $elementcontext['wrapperid'] = 'fitem_' . (isset($elementcontext['id']) ? $elementcontext['id'] : '');
            }

            $context = [
                'element' => $elementcontext,
                'label' => $label,
                'text' => $text,
                'required' => false,
                'advanced' => false,
                'helpbutton' => $helpbutton,
                'error' => false,
            ];

            return $this->render_from_template($templatename, $context);
        } catch (\Exception $e) {
            // No template or other error.
            return false;
        }
    }

}
