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


class block_compviz extends block_base {

    //Initialisiert den Block & setzt Titel
    public function init() {
        $this->title = get_string('pluginname', 'block_compviz');
        //ruft Namen des Plugins ab
    }

    //Erstellt Inhalt des Blocks
    public function get_content() {

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
        $this->content->text = $this->render_skills_chart();

        global $PAGE;
        $PAGE->requires->js_call_amd('block_compviz/testfile', 'init'); 
        return $this->content;
    }

    //Generiert Diagramm mit den Skills
    private function render_skills_chart() {
        global $OUTPUT;

        //statische Daten
        $skills = [
            'Alle Skills' => 75,
        'Skill - Git' => [
            'Fortschritt' => 50,
            'Sub-Skills' => [
                'Initialisierung' => 100,
                'Branch' => [
                    'Fortschritt' => 25,
                    'Sub-Skills' => [
                        'Erstellen' => 80,
                        'Mergen' => [
                            'Fortschritt' => 60,
                            'Sub-Skills' => [
                                'Fast-Forward' => 90,
                                '3-Way Merge' => 50
                            ]
                        ]
                    ]
                ]
            ]
        ],
            'Skill - Conflict Handling' => [
                'Fortschritt' => 100,
                'Sub-Skills' => [
                    'Merge Conflict' => 100,
                    'Rebasing' => 100
                ]
            ],
            'Skill - yolo' => [
                'Fortschritt' => 70,
                'Sub-Skills' => [
                    'Initialisierung' => 100,
                    'Branching' => 25
                ]
            ],
            'Skill - swag' => [
                'Fortschritt' => 100,
                'Sub-Skills' => [
                    'Merge Conflict' => 100,
                    'Rebasing' => 100,
                    'Money Boy' => 80,
                    'Money' => 100
                ]
            ]
        ];
        $html = '<div style="margin-bottom: 10px; font-size: 14px; font-weight: bold; text-align: center;">Skills</div>';
        $html .= '<div style="display: flex; align-items: flex-start; gap: 20px;">';
        $html .= $this->render_vertical_bar('', $skills['Alle Skills']);
        // .= Kombinationsoperator
        
        $html .= '<div style="flex: 1;">';
        foreach ($skills as $skill => $data) {
            if ($skill === 'Alle Skills') {
                continue;
            }
            $html .= $this->render_collapsible_skill($skill, $data['Fortschritt'], $data['Sub-Skills']);
        }

        $html .= '</div>'; // Skills-Container
        $html .= '</div>'; // Hauptcontainer

        return $html;
    }

    //Aufklappbare Skills/Sub-Skills
    private function render_collapsible_skill($label, $progress, $subskills) {
        // Fortschrittsbalken mit dem Marker (Pfeil) innerhalb der Progressbar
        $html = '<details>';
        $html .= '<summary style="margin: 0; padding: 0; list-style: none;">' . $this->render_horizontal_bar($label, $progress, true) . '</summary>';
        if (!empty($subskills)) {
            $html .= '<div style="margin-left: 20px;">';
            foreach ($subskills as $subskill => $subprogress) {
                if(is_array($subprogress) && !empty($subprogress))
                {
                    $html .= $this->render_collapsible_skill($subskill, $subprogress['Fortschritt'], $subprogress['Sub-Skills']);
                }
                else
                {
                    $html .= $this->render_horizontal_bar($subskill, $subprogress, false);
                }
            }
            $html .= '</div>';
        }
        $html .= '</details>';
    
        return $html;
    }
    
    //Horizontaler Fortschrittsbalken
    private function render_horizontal_bar($label, $progress, $is_main_skill = false) {
        //Fortschrittswert horizontal
        $bar_width = $progress . '%';
        $background_color = $this->get_progress_color($progress);
    
        // Fortschrittsbalken-Inhalt: Label und Pfeil (bei Hauptskills)
        $content = '<div style="display: flex; justify-content: center; align-items: center; width: 100%; height: 100%; position: relative;">
                        <span style="font-size: 12px;">' . $label . '</span>'; // Text mittig in Box
        //Dropdown-Pfeil nur bei den Hauptskills (später auch für die subskills)
        if ($is_main_skill) {
            $content .= '<span style="position: absolute; right: 10px; font-size: 12px; cursor: pointer;">▼</span>'; // Dropdown-Pfeil rechts
        }
        $content .= '</div>';
    
        return '<div style="margin-bottom: 10px; display: flex; align-items: center; border: 1px solid #ccc; border-radius: 5px; background: #f4f4f4; width: 100%; height: 35px; position: relative;">
                    <div style="width: ' . $bar_width . '; height: 100%; background-color: ' . $background_color . '; position: absolute; top: 0; left: 0; z-index: 0;"></div>
                    <div style="position: relative; z-index: 1; display: flex; align-items: center; justify-content: center; width: 100%; color: #333; font-weight: normal; font-size: 12px;">
                        ' . $content . '
                    </div>
                </div>';
    }
    
    //vertikale Fortschrittsanzeige
    private function render_vertical_bar($label, $progress) {
        //Fortschrittswert vertikal
        $bar_height = $progress . '%';
        $background_color = $this->get_progress_color($progress);

        //Text steht über Leiste
        return '<div style="text-align: center;">
            <div style="font-size: 12px; color: #333; margin-bottom: 10px">' . $label . '</div>
            <div style="width: 40px; height: 200px; border: 1px solid #ccc; border-radius: 5px; background: #f4f4f4; position: relative;">
                <div style="height: ' . $bar_height . '; width: 100%; background-color: ' . $background_color . '; position: absolute; bottom: 0; display: flex; align-items: flex-end; justify-content: center; color: #333; font-weight: normal; font-size: 12px; padding-bottom: 8px;">
                    ' . $progress . '%
                </div>
            </div>
        </div>';
    }

    private function get_progress_color($progress) {
        if ($progress < 50) {
            return '#dc3545'; // Rot
        } elseif ($progress < 75) {
            return '#ffc107'; // Gelb
        } else {
            return '#28a745'; // Grün
        }
    }

    public function has_config() {
        return true;
    }

    public function applicable_formats() {
        return [
            'course-view' => true,
            'site-index' => false,
        ];
    }
}
