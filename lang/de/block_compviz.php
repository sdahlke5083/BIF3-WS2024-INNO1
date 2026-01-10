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
 * Strings for component 'block_compviz', language 'de'
 *
 * @package    block_compviz
 * @category   string
 * @copyright  2025 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Predefined / Basic required strings
$string['compviz:addinstance'] = 'Neuen CompViz-Block hinzufügen';
$string['compviz:myaddinstance'] = 'Neuen CompViz-Block zu "Meine Startseite" hinzufügen';
$string['compviz:show_graph'] = 'Bewertungsdiagramm anzeigen';
$string['pluginname'] = 'Kompetenz-Visualisierung';

// Block strings
$string['admin_settings_desc'] = 'Info:';
$string['admin_settings_desc_desc'] = 'Globale Einstellungen für den CompViz-Block.';
$string['enabled'] = 'Aktivieren';
$string['enabled_desc'] = 'Den Skills-Overview-Block auf der Kursseite aktivieren.';
$string['enabled_help'] = 'Den Skills-Overview-Block auf der Kursseite aktivieren.';
$string['no_leo'] = 'Keine Kategorien für Lernziele gefunden.';
$string['no_subskills'] = 'Keine sichtbaren Unterfähigkeiten für diese Kategorie gefunden.';
$string['skills_overview'] = 'Fähigkeitenübersicht';

// Settings form strings
$string['select_leo'] = 'Lernzielkategorie auswählen';
$string['select_leo_desc'] = 'Wählen Sie die Lernzielkategorie für den Skills-Overview-Block aus.';
$string['select_leo_help'] = 'Wählen Sie eine Bewertungs- bzw. Lernzielkategorie für den Skills-Overview-Block. Diese wird zur Anzeige der Fähigkeiten verwendet.';

// User settings form strings
$string['appearance'] = 'Darstellung';
$string['color_settings_desc'] = 'Darstellungseinstellungen bestimmen, wie Fortschrittsbalken und Diagramme in Ihrer Ansicht eingefärbt werden. Theme-Farben passen sich automatisch an das Design Ihrer Moodle-Site an (empfohlen für Konsistenz). Benutzerdefinierte Farben ermöglichen eine persönliche Palette - nützlich für Barrierefreiheit, Farbenblindheits-Anpassungen oder persönliche Vorlieben.';
$string['color_settings_note'] = 'Hinweis: Die Farbwahl kann die Lesbarkeit erheblich beeinflussen. Berücksichtigen Sie Kontrast und Barrierefreiheit bei der Auswahl benutzerdefinierter Farben.';
$string['settingsnotsaved'] = 'Benutzereinstellungen konnten nicht gespeichert werden.';
$string['settingssaved'] = 'Benutzereinstellungen gespeichert.';
$string['show_completed'] = 'Abgeschlossene LEOs anzeigen';
$string['show_completed_help'] = 'Lernzielkategorien (LEOs) repräsentieren größere Kompetenzgruppen in Ihrem Kurs. Wenn aktiviert, bleiben vollständig abgeschlossene LEOs in Ihrer Übersicht sichtbar. Wenn deaktiviert, werden abgeschlossene LEOs automatisch ausgeblendet, sodass Sie sich nur auf Fähigkeiten konzentrieren können, die noch Arbeit erfordern. Hinweis: Einzelne Aktivitäten (µLEOs) innerhalb eines LEOs werden unabhängig von dieser Einstellung immer angezeigt.';
$string['theme'] = 'Farbthema';
$string['theme_help'] = 'Wählen Sie aus vordefinierten Farbschemata, die verschiedene Fortschrittsstufen zeigen. Jedes Theme verwendet 5 Farben, die vom niedrigsten (0-20%) bis zum höchsten (80-100%) Leistungsstand reichen. Die Vorschau zeigt, wie jedes Theme in Ihren Fortschrittsbalken aussehen wird.';
$string['usersettings'] = 'CompViz-Einstellungen';
$string['usersettings_desc'] = 'Konfigurieren Sie Ihre persönlichen CompViz-Einstellungen. Diese Einstellungen betreffen nur Ihr Konto und ändern nicht, wie andere Benutzer den Block sehen. Verwenden Sie diese Optionen, um anzupassen, welche Fähigkeiten angezeigt werden und wie Fortschrittsbalken eingefärbt sind.';

// Privacy provider strings
$string['privacy:metadata:block_compviz'] = 'Der CompViz-Block speichert Benutzereinstellungen zum Aktivieren des Blocks und zum Anzeigen abgeschlossener Fähigkeiten.';
$string['privacy:metadata:block_compviz_enabled'] = 'Benutzereinstellung zum Aktivieren des Skills-Overview-Blocks.';
$string['privacy:metadata:block_compviz_show_completed'] = 'Benutzereinstellung zum Anzeigen abgeschlossener Fähigkeiten im Skills-Overview-Block.';

// Color / appearance strings (colorpicker)
$string['colormode'] = 'Farbmodus';
$string['colormode_help'] = 'Wählen Sie, ob der Block die Theme-Farben Ihrer Seite verwenden soll (empfohlen) oder ob Sie eigene Farbwerte verwenden möchten. Änderungen wirken nur in Ihrer persönlichen Ansicht.';
$string['custom_color_1'] = 'Fortschrittsfarbe (höchste)';
$string['custom_color_1_help'] = 'Farbe für ausgezeichneten Fortschritt (80-100% abgeschlossen). Diese Farbe repräsentiert Beinahe-Vollendung oder Meisterschaft. Typischerweise funktionieren grüne oder helle positive Farben gut.';
$string['custom_color_2'] = 'Fortschrittsfarbe (hoch)';
$string['custom_color_2_help'] = 'Farbe für guten Fortschritt (60-79% abgeschlossen). Zeigt starke Fortschritte. Oft hellgrün, blau oder positive Mitteltöne.';
$string['custom_color_3'] = 'Fortschrittsfarbe (mittel)';
$string['custom_color_3_help'] = 'Farbe für moderaten Fortschritt (40-59% abgeschlossen). Zeigt an, dass Sie auf halbem Weg sind. Neutrale Farben wie Gelb oder Orange funktionieren gut.';
$string['custom_color_4'] = 'Fortschrittsfarbe (niedrig)';
$string['custom_color_4_help'] = 'Farbe für frühen Fortschritt (20-39% abgeschlossen). Zeigt erste unternommene Schritte. Oft bernsteinfarben, hellorange oder warme Neutraltöne.';
$string['custom_color_5'] = 'Fortschrittsfarbe (sehr niedrig)';
$string['custom_color_5_help'] = 'Farbe für minimalen Fortschritt (0-19% abgeschlossen). Zeigt gerade erst begonnen oder noch nicht versucht. Typischerweise rot, grau oder kühle Töne, um benötigte Arbeit zu zeigen.';
$string['custom_color_completed'] = 'Farbe für bestanden';
$string['custom_color_failed'] = 'Farbe für nicht bestanden';
$string['custom_color_help'] = 'Primäre Farbe, verwendet wenn benutzerdefinierte Farben aktiviert sind.';
$string['usecolorpicker'] = 'Benutzerdefinierte Farben verwenden';
$string['usecolorpicker_help'] = 'Wenn ausgewählt, erstellen Sie eine persönliche Farbpalette mit den Farbwählern unten.';
$string['usetheme'] = 'Theme-Farben verwenden';
$string['usetheme_help'] = 'Wenn ausgewählt, verwendet der CompViz-Block die Farbpalette Ihres Moodle-Themes für Diagramme und Balken. Theme-Farben werden von Ihrem Administrator verwaltet.';

// Completion labels for quiz prefix
$string['completion_completed'] = 'Abgeschlossen';
$string['completion_failed'] = 'Nicht bestanden';
$string['completion_notcompleted'] = 'Nicht abgeschlossen';
$string['completion_passed'] = 'Bestanden';