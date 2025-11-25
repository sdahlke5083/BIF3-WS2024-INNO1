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
 * Block compviz is defined here.
 *
 * @package     block_compviz
 * @copyright   2024 BIF-INNO-Group10
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// import display_data.php
require_once($CFG->dirroot . '/blocks/compviz/db/display_data.php');

// Add completion constants (COMPLETION_*).
require_once($CFG->libdir . '/completionlib.php');

class block_compviz extends block_base
{

    //Initialisiert den Block & setzt Titel
    public function init()
    {
        //ruft Namen des Plugins ab
        $this->title = get_string('pluginname', 'block_compviz');
    }

    //Erstellt Inhalt des Blocks
    public function get_content()
    {
        // Wenn Block global deaktiviert ist, dann nichts zurückgeben
        if (get_config('block_compviz', 'enabled') == 0) {
            $this->content = '';
            return $this->content;
        }

        //Existiert Inhalt vom Block schon?
        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        $this->content = new stdClass();
        // Diagramm mit flexibler Platzierung (da eigene Aufteilung) rendern
        $this->content->text = $this->block_compviz_render_skills_overview();
        $this->content->footer = '';

        return $this->content;
    }

    // Generiert Diagramm mit Moustache Template
    private function block_compviz_render_skills_overview()
    {
        global $OUTPUT, $USER;

        try {
            $skills = $this->block_compviz_get_skills_data();
        } catch (Exception $e) {
            return "No data available";
        }
        $totalprogress = $this->block_compviz_get_total_progress($skills);
        $passingvalue = 75;
        $options = new stdClass();
        $options->showCompleted = $this->get_user_settings_as_bool('show_completed', $USER->id);

        global $CFG; // für completionlib path
        require_once($CFG->libdir . '/completionlib.php'); // definiert COMPLETION_* Konstanten

        $quizcmids = [];
        foreach ($skills as $s) {
            if (empty($s->grade_items)) {
                continue;
            }
            foreach ($s->grade_items as $gi) {
                if (!empty($gi->cmid) && !empty($gi->itemmodule) && $gi->itemmodule === 'quiz') {
                    $quizcmids[] = (int)$gi->cmid;
                }
            }
        }
        $quizcmids = array_values(array_unique($quizcmids));

        // cmid -> completionstate aus {course_modules_completion} via unser DB-Helper.
        $completionmap = block_compviz_get_cm_completion_states_for_user($quizcmids, $USER->id);

        foreach ($skills as $skill) {
            //Begrenzung der LOs namen
            $maxLength = 30; 
            $skill->name = trim(preg_replace('/^\p{So}+\s*/u', '', $skill->name));
            if (strlen($skill->name) > $maxLength) {
                $skill->name = substr($skill->name, 0, $maxLength) . '...';
            }

            $progress = $this->block_compviz_get_progress($skill->finalgrade, $skill->grademax);
            $skill->progress = $progress;
            $skill->color = $this->get_progress_color($progress, $USER->id);
            
            foreach ($skill->grade_items as $key => $subSkill) {
                $progress = $this->block_compviz_get_progress($subSkill->finalgrade, $subSkill->grademax);
                if ($options->showCompleted == false && $progress >= 100) {
                    // Skill ist abgeschlossen, also nicht anzeigen
                    unset($skill->grade_items[$key]);
                }
                else{
                    $subSkill->progress = $progress;
                    $subSkill->color = $this->get_progress_color($progress, $USER->id);
                    //Begrenzung des Lo namen
                    $subSkill->name = trim(preg_replace('/^\p{So}+\s*/u', '', $subSkill->name));
                    if (strlen($subSkill->name) > $maxLength) {
                        $subSkill->name = substr($subSkill->name, 0, $maxLength) . '...';
                    }
                }
                if (!empty($subSkill->cmid) && !empty($subSkill->itemmodule) && $subSkill->itemmodule === 'quiz') {
                    $state = $completionmap[$subSkill->cmid] ?? COMPLETION_INCOMPLETE;

                    // State -> Label (nutzt die Sprachstrings aus lang/*/block_compviz.php)
                    switch ((int)$state) {
                        case COMPLETION_COMPLETE_PASS:
                            $label = get_string('completion_passed', 'block_compviz'); break;
                        case COMPLETION_COMPLETE_FAIL:
                            $label = get_string('completion_failed', 'block_compviz'); break;
                        case COMPLETION_COMPLETE:
                            $label = get_string('completion_completed', 'block_compviz'); break;
                        case COMPLETION_INCOMPLETE:
                        default:
                            $label = get_string('completion_notcompleted', 'block_compviz'); break;
                    }

                    // Farbe anhand des Completion-States überschreiben.
                    $subSkill->color = $this->get_progress_color($progress, $USER->id, $state);

                    // Prefix vor den vorhandenen Namen setzen
                    //$subSkill->name = '[' . $label . '] ' . $subSkill->name;
                }
                if (!empty($subSkill->cmid) && !empty($subSkill->itemmodule)) {
                    $subSkill->url = new moodle_url(
                        '/mod/' . $subSkill->itemmodule . '/view.php',
                        ['id' => $subSkill->cmid]
                    );
                } else {
                    $subSkill->url = null;
                }
            }
        }

        //var_dump($skills);
        $data = [
            'title' => $this->title,
            'header' => get_string('skills_overview', 'block_compviz'),
            'totalProgress' => $totalprogress,
            'totalColor' => $this->get_progress_color($totalprogress, $USER->id),
            'passingValue' => $passingvalue,
            'skills' => $skills
        ];

        return $OUTPUT->render_from_template('block_compviz/skills_overview', $data);
    }


    // Holt Daten der Skills
    private function block_compviz_get_skills_data()
    {
        global $CFG, $COURSE;
        require_once($CFG->libdir.'/gradelib.php');
        grade_regrade_final_grades($COURSE->id);

        $leo_category_id = $this->config->select_leo ?? block_compviz_get_default_leo_category();
        
        $leos = block_compviz_get_current_user_grade_items_by_category(leos_categorie_id: $leo_category_id); 

        // in verwertbare Form bringen
        $data = array_values($leos);

        return $data;
    }


    private function block_compviz_get_progress($grade, $maxgrade)
    {
        if ($maxgrade == 0) {
            return 0; // Avoid division by zero
        }
        return $grade / $maxgrade * 100;
    }

    // Berechnet Gesamtfortschritt
    private function block_compviz_get_total_progress($skills)
    {
        $totalprogress = 0;
        $count = 0;

        foreach ($skills as $skill) {
            $totalprogress += $skill->finalgrade;
            $count++;  
         
        }

        if ($count == 0) {
            return 0; // Avoid division by zero
        }

        $result = $totalprogress / $count;

        return round($result, 2);
    }

    private function get_progress_color($progress, $userid, $completionstate = null)
    {
        $mode = get_user_preferences('block_compviz_color_mode', 'theme', $userid);
        if ($mode == 'custom') {
            $colors = [
                'color1' => get_user_preferences('block_compviz_custom_color_1', '#ff0000', $userid),
                'color2' => get_user_preferences('block_compviz_custom_color_2', '#00ff00', $userid),
                'color3' => get_user_preferences('block_compviz_custom_color_3', '#0000ff', $userid),
                'color4' => get_user_preferences('block_compviz_custom_color_4', '#ffff00', $userid),
                'color5' => get_user_preferences('block_compviz_custom_color_5', '#ff00ff', $userid)
            ];
        } else {
            $settings_value = get_user_preferences('block_compviz_theme', 1, $userid);
            $colors = block_compviz_get_colors($settings_value);
            // Ensure each color value starts with a '#'
            foreach ($colors as $key => $color) {
                if (strpos($color, '#') !== 0) {
                    $colors[$key] = "#{$color}";
                }
            }
        }

        // Wenn ein Completion-State übergeben wurde, ggf. Spezialfarben verwenden.
        if ($completionstate !== null) {
            switch ((int)$completionstate) {
                case COMPLETION_COMPLETE:
                case COMPLETION_COMPLETE_PASS:
                    // Grün für "abgeschlossen / bestanden".
                    return '#28a745';
                case COMPLETION_COMPLETE_FAIL:
                    // Rot für "nicht bestanden".
                    return '#dc3545';
                case COMPLETION_INCOMPLETE:
                default:
                    // Für "incomplete" oder unbekannte States weiter unten die Standardlogik verwenden.
                    break;
            }
        }

        // Standard Farblogik abhängig vom Fortschritt.
        if ($progress < 20) {
            return $colors['color5'];
        } elseif ($progress < 40) {
            return $colors['color4'];
        } elseif ($progress < 60) {
            return $colors['color3'];
        } elseif ($progress < 80) {
            return $colors['color2'];
        } else {
            return $colors['color1'];
        }
    }


    private function get_user_settings_as_bool($setting, $userid){
        $value = get_user_preferences('block_compviz_' . $setting, 'not set', $userid);
        if ($value != 'not set') {
            return $value == 1 ? true : false;
        } else {
            return true;
        }
    }

    // Adds a settings link to the block's breadcrumb navigation
    public function get_content_for_output($output)
    {
        $bc = parent::get_content_for_output($output);

        if ($bc && isloggedin() && !isguestuser()) {
            
            $link = new action_menu_link_primary(
                new moodle_url('#', null),
                new pix_icon(
                    'i/settings',
                    get_string('usersettings', 'block_compviz')
                ),
                get_string('usersettings', 'block_compviz'),
                [
                    'class' => 'editing_usersettings',
                    'data-title' => get_string('usersettings', 'block_compviz'),
                    ]
            );

            array_unshift($bc->controls, $link);          // gleich vorne anzeigen
        }
        return $bc;
    }

    public function get_required_javascript()
    {
        parent::get_required_javascript();
        $this->page->requires->js_call_amd('block_compviz/skills_overview', 'init');
        $this->page->requires->js_call_amd('block_compviz/user_settings', 'init', ['.editing_usersettings']);
    }

    public function has_config()
    {
        // enables the sitewide settings page for this block
        return true;
    }

    public function instance_allow_config()
    {
        // allows the block to be configured on a per-instance basis
        return true;
    }

    public function applicable_formats()
    {
        return [
            'course-view' => true,
            'site-index' => false,
            '*' => false,
            'my' => false
        ];
    }
}
