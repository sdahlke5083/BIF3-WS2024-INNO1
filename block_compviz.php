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
        global $PAGE;

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
        $PAGE->requires->js_call_amd("block_compviz/skills_overview", "init");

        return $this->content;
    }

    // Generiert Diagramm mit Moustache Template
    private function block_compviz_render_skills_overview()
    {
        global $OUTPUT;


        $skills = $this->block_compviz_get_skills_data();
        $totalprogress = $this->block_compviz_get_total_progress($skills);
        $passingvalue = 75;


        foreach ($skills as $skill) {
            $progress = $this->block_compviz_get_progress($skill->finalgrade, $skill->grademax);
            $skill->progress = $progress;
            $skill->color = $this->get_progress_color($progress);

            foreach ($skill->grade_items as $subSkill) {
                $progress = $this->block_compviz_get_progress($subSkill->finalgrade, $subSkill->grademax);
                $subSkill->progress = $progress;
                $subSkill->color = $this->get_progress_color($progress);
            }
        }

        $data = [
            'title' => $this->title,
            'header' => get_string('skills_overview', 'block_compviz'),
            'totalProgress' => $totalprogress,
            'totalColor' => $this->get_progress_color($totalprogress),
            'passingValue' => $passingvalue,
            'skills' => $skills
        ];

        return $OUTPUT->render_from_template('block_compviz/skills_overview', $data);
    }


    // Holt Daten der Skills
    private function block_compviz_get_skills_data()
    {

        // 4 = ID der Kategorie "LEO's" - später in Konfiguration anpassbar machen
        $leos = block_compviz_get_current_user_grade_items_by_category(4);

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

        return $totalprogress / $count;
    }

    private function get_progress_color($progress)
    {
        if ($progress < 20) {
            return '#D8F3DC';
        } elseif ($progress < 40) {
            return '#b7e4c7';
        } elseif ($progress < 60) {
            return '#74c69d';
        } elseif ($progress < 80) {
            return '#52b788';
        } else {
            return '#40916C';
        }
    }


    public function get_content_for_output($output)
    {
        $bc = parent::get_content_for_output($output);

        if ($bc && isloggedin() && !isguestuser()) {
            $url = new moodle_url('/blocks/compviz/usersettings/user.php', [
                'returnurl' => $this->page->url->out_as_local_url(false),
                'sesskey'   => sesskey()
            ]);

            $link = new action_menu_link_primary(
                $url,
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
        ];
    }
}
