# Übergabeprotokol – Moodle Block „Competence Visualization" (block_compviz)

**Projektteam:** BIF-INNO-Group10  
**Version:** 0.1.0 (v0.0.3-alpha.5)  
**Status:** MATURITY_ALPHA  
**Datum:** Januar 2026  

---

## 1. Aufgabe und Ziel des Projekts

### Hauptziel
Entwicklung eines Moodle-Block-Plugins, das Lernenden eine visuelle Übersicht über den Kompetenzfortschritt in einem Kurs bietet. Der Block visualisiert Learning Outcomes (LEOs) und Micro Learning Outcomes (µLEOs) basierend auf der Moodle-Bewertungsstruktur.

### Kernfunktionen
- **Visualisierung von Lernfortschritt**: Darstellung von LEOs (Bewertungskategorien) und µLEOs (einzelne Bewertungselemente) als Fortschrittsbalken
- **Personalisierbare Ansicht**: Benutzer können eigene Farbschemata wählen oder vordefinierte Themes nutzen
- **Flexible Darstellung**: Option zum Anzeigen/Verbergen abgeschlossener Kompetenzen
- **Mehrsprachigkeit**: Unterstützung für Deutsch und Englisch
- **Responsive Design**: Anpassung an verschiedene Bildschirmgrößen

### Zielgruppe
- **Studierende**: Überblick über ihren individuellen Lernfortschritt
- **Lehrende**: Monitoring des Kompetenzaufbaus im Kurs und Konfiguration der Block-Instanz (z.B. LEO-Auswahl)
- **Administratoren**: Globale Plugin-Einstellungen (Enable/Disable)

---

## 2. Was das Plugin bereits leistet

### Implementierte Features

#### 2.1 Grundlegende Block-Funktionalität
- ✅ Block wird im Kurskontext angezeigt
- ✅ Integration in das Moodle-Block-System
- ✅ Admin-Setting zum globalen Aktivieren/Deaktivieren des Blocks
- ✅ Konfigurierbar über `settings.php`
- ✅ **Lehrer-Konfiguration** über `edit_form.php` (Auswahl der Bewertungskategorie/LEO pro Block-Instanz)

#### 2.2 Datenverarbeitung
- ✅ Liest Bewertungskategorien (LEOs) und Bewertungselemente (µLEOs) aus der Moodle-Gradebook-API
- ✅ Berechnet Fortschrittsprozente für jeden Lernenden
- ✅ Berücksichtigt Completion-Status von Aktivitäten (bestanden/nicht bestanden/abgeschlossen)
- ✅ Datenbank-Schema für Farbthemes (`block_compviz_colors`)

#### 2.3 User Interface
- ✅ **Fortschrittsbalken** mit fünf Farbstufen (0-20%, 20-40%, 40-60%, 60-80%, 80-100%)
- ✅ **Collapsible LEO-Bereiche** zum Auf-/Zuklappen einzelner Kompetenzbereiche
- ✅ **User Settings Modal** mit Zahnrad-Icon für persönliche Einstellungen
- ✅ Mustache-Templates für konsistentes Rendering:
  - `block_compviz/overview_template.mustache` – Hauptansicht
  - `block_compviz/form/element-bccolorpicker.mustache` – Custom Colorpicker
- ✅ Custom CSS (`styles.css`) mit CSS-Variablen für dynamische Farbgebung

#### 2.4 Benutzerpersonalisierung
- ✅ **Farbmodus-Auswahl**: Theme-Farben vs. Custom-Farben
- ✅ **5 vordefinierte Farbthemes** (Default, Violet Dream, Vivid Pop, Aqua Rose, Fresh Meadow)
- ✅ **5 Custom Color Picker** für individuelle Farbpaletten
- ✅ **Toggle für abgeschlossene LEOs** (anzeigen/verbergen)
- ✅ User Preferences werden per Moodle User Preferences API gespeichert

#### 2.5 Technische Implementierung
- ✅ Namespaced PHP-Klassen (`block_compviz\...`)
- ✅ Form-API Integration (`user_form.php` als Dynamic Form)
- ✅ Privacy API Integration (GDPR-konform)
- ✅ Upgrade-Skripte (`db/upgrade.php`, `db/install.php`)
- ✅ Unit-Tests (`tests/`) – Basis vorhanden
- ✅ Language Strings in `lang/en/` und `lang/de/`
- ✅ **Moodle Coding Standards konform** (PHPDoc, Code Style, keine Inline-JS)
- ✅ **AMD JavaScript-Module** statt Inline-JavaScript (kompiliert via Grunt)

---

## 3. Grundlegende Erkenntnisse zur Moodle-Plugin-Entwicklung

### 3.1 Moodle-Ordnerstruktur

Ein Moodle-Block-Plugin muss in folgendem Verzeichnis liegen:
```
{MOODLE_DIRROOT}/blocks/{pluginname}/
```

Für unser Plugin:
```
{MOODLE_DIRROOT}/blocks/compviz/
```

### 3.2 Essentielle Dateien für ein Block-Plugin

| Datei | Zweck | Pflicht |
|-------|-------|---------|
| `version.php` | Plugin-Metadaten (Version, Release, Requires, Maturity) | ✅ Ja |
| `block_{pluginname}.php` | Hauptklasse des Blocks, erbt von `block_base` | ✅ Ja |
| `lang/en/{pluginname}.php` | Englische Sprachstrings (Mindestanforderung) | ✅ Ja |
| `db/access.php` | Capabilities/Rechte-Definition | ⚠️ Empfohlen |
| `db/install.xml` | Datenbankschema für Plugin-Tabellen | ⚠️ Bei DB-Nutzung |
| `db/upgrade.php` | Datenbank-Upgrade-Logik | ⚠️ Bei DB-Nutzung |
| `settings.php` | Admin-Einstellungen | ⚠️ Optional |
| `edit_form.php` | Block-Konfiguration für Lehrer (pro Instanz) | ⚠️ Optional |
| `styles.css` | Plugin-spezifische Styles | ⚠️ Optional |
| `README.md` | Dokumentation | ⚠️ Optional |

**Wichtig:** Der Dateiname der Hauptklasse muss exakt `block_{pluginname}.php` heißen und die Klasse muss `block_{pluginname}` heißen.

### 3.3 Wichtige Moodle-APIs, die wir verwendet haben

#### Grades API
```php
$gradereport = grade_get_course_grades($courseid, $userid);
$categoryitems = grade_category::fetch_all(['courseid' => $courseid]);
```
**Verwendung:** Lesen von Bewertungskategorien und -elementen

#### User Preferences API
```php
set_user_preference('block_compviz_theme', $value, $userid);
get_user_preferences('block_compviz_theme', $default, $userid);
```
**Verwendung:** Speichern von benutzerspezifischen Einstellungen (Farbschema, Toggle-Status)

#### Form API (Dynamic Forms)
```php
class user_form extends \core_form\dynamic_form {
    protected function definition() { ... }
    public function process_dynamic_submission(): array { ... }
}
```
**Verwendung:** Benutzereinstellungs-Modal ohne Page-Reload

#### Mustache Templating
```php
$templatecontext = ['data' => $data];
echo $OUTPUT->render_from_template('block_compviz/overview_template', $templatecontext);
```
**Verwendung:** Separation von Logik und Präsentation

#### Privacy API
```php
class provider implements \core_privacy\local\metadata\provider { ... }
```
**Verwendung:** GDPR-Compliance für Benutzer-Präferenzen

### 3.4 Datenbankschema-Management

**Dateien:**
- `db/install.xml` – Initiales Schema (wird von XMLDB Editor generiert)
- `db/install.php` – Post-Install Logik (z.B. Default-Daten einfügen)
- `db/upgrade.php` – Versionsspezifische Upgrades

**Wichtig:**
- Tabellennamen müssen mit `{pluginname}_` beginnen (z.B. `block_compviz_colors`)
- Nach Schema-Änderungen muss die `version` in `version.php` erhöht werden
- XMLDB Editor (`Site administration → Development → XMLDB Editor`) nutzen!

---

## 4. Erweiterte Probleme und Lösungen

### 4.1 Problem: Custom Colorpicker in Moodle-Formularen

#### Ausgangssituation
Moodle hat keinen nativen Colorpicker-Formulartyp. Die einzige Core-Lösung ist `admin_setting_configcolourpicker`, die **nur in Admin-Settings** funktioniert, nicht in regulären Forms.

#### Gescheiterte Ansätze

**Versuch 1: HTML5 Input Type="color"**
```php
$mform->addElement('text', 'custom_color', 'Color', ['type' => 'color']);
```
❌ **Problem:** Funktioniert technisch, aber:
- Keine konsistente Browser-Unterstützung
- Schlechte UX auf mobilen Geräten
- Kein Preview der Farbe im Form
- Schwierig zu validieren

**Versuch 2: JavaScript-basierte Third-Party Colorpicker**
- Versucht: Spectrum.js, jQuery Colorpicker
❌ **Problem:**
- Konflikt mit Moodle's AMD-Modul-System
- Moodle's jQuery läuft im `noConflict`-Modus
- Security-Richtlinien verhindern externe CDN-Einbindung
- Erhöht Maintenance-Aufwand

**Versuch 3: Nutzung von `admin_setting_configcolourpicker` außerhalb von Settings**
```php
$mform->addElement('configcolourpicker', 'custom_color', ...);
```
❌ **Problem:**
- Diese Klasse ist fest an das Admin-Settings-System gekoppelt
- Funktioniert nicht mit `MoodleQuickForm`
- Erfordert `admin_settingpage`-Kontext

#### Die Lösung: Custom Form Element mit QuickForm-Erweiterung

**Implementierung in 3 Schritten:**

**1. Basis-Klasse erstellen** (`classes/form/colorpicker.php`)
```php
namespace block_compviz\form;

class HTML_QuickForm_bccolorpicker extends \HTML_QuickForm_input {
    public function __construct($elementName=null, $elementLabel=null, $attributes=null) {
        parent::__construct($elementName, $elementLabel, $attributes);
        $this->setType('bccolorpicker');
    }
    
    public function toHtml() {
        // Einfacher Text-Input mit type="text"
        return '<input type="text" ' . $this->_getAttrString($this->_attributes) . ' />';
    }
}
```
**Wichtig:** Präfix `bc` (block_compviz), um Namespace-Kollisionen zu vermeiden

**2. Moodle-Form-Element-Wrapper** (`classes/form/colorpicker_form_element.php`)
```php
class MoodleQuickForm_bccolorpicker extends HTML_QuickForm_bccolorpicker implements templatable {
    use templatable_form_element;
    
    public function export_for_template(renderer_base $output) {
        $context = $this->export_for_template_base($output);
        $context['value'] = $this->getValue();
        return $context;
    }
}
```
**Wichtig:** `templatable`-Interface ermöglicht Mustache-Template-Nutzung

**3. Custom Mustache Template** (`templates/form/element-bccolorpicker.mustache`)
```html
<input type="text" 
       id="{{id}}" 
       name="{{name}}" 
       value="{{value}}" 
       class="form-control bccolorpicker {{#error}}is-invalid{{/error}}"
       {{#readonly}}readonly{{/readonly}}
       pattern="^#[0-9A-Fa-f]{6}$"
       placeholder="#RRGGBB"
/>
```
**Features:**
- Client-Side Validierung via `pattern`
- Error-Styling via `is-invalid`-Klasse
- Placeholder für bessere UX

**4. Registrierung in der Form**
```php
MoodleQuickForm::registerElementType(
    'bccolorpicker',
    "{$CFG->dirroot}/blocks/compviz/classes/form/colorpicker_form_element.php",
    'MoodleQuickForm_bccolorpicker'
);

$mform->addElement('bccolorpicker', 'custom_color_1', get_string('custom_color_1', 'block_compviz'));
$mform->setType('custom_color_1', PARAM_RAW_TRIMMED);
```

**5. Custom Renderer für Template-Routing** (`classes/output/renderer.php`)
```php
class renderer extends plugin_renderer_base {
    public function render_colorpicker_element($element) {
        $templatename = 'block_compviz/form/element-bccolorpicker';
        if ($element instanceof templatable) {
            return $this->render_from_template($templatename, $element->export_for_template($this));
        }
        return '';
    }
}
```

#### Warum diese Lösung funktioniert
✅ **Native Integration**: Nutzt Moodle's `HTML_QuickForm`-System  
✅ **Template-Flexibilität**: Mustache ermöglicht volle Kontrolle über HTML/CSS  
✅ **Validation**: Standard Moodle Form Validation + Custom Pattern  
✅ **Wiederverwendbar**: Element kann in beliebigen Forms genutzt werden  
✅ **Keine externen Dependencies**: Nur Moodle Core APIs  
✅ **Theme-kompatibel**: Nutzt Moodle's `form-control`-Klassen  

#### Best Practices für Custom Form Elements
1. **Namespace-Präfix verwenden** (z.B. `bc` für block_compviz)
2. **`templatable`-Interface implementieren** für Template-Support
3. **Standard Form-Klassen nutzen** (`form-control`, `is-invalid`) für Theme-Kompatibilität
4. **Client-Side Validation** via HTML5 Attributes (pattern, required)
5. **Custom Renderer registrieren** für Template-Routing

---

### 4.2 Problem: Dynamic Forms und AJAX-Fehlerbehandlung

#### Ausgangssituation
User Settings sollten ohne Page-Reload speicherbar sein (Modal-Dialog mit AJAX).

#### Lösung: Dynamic Forms API
```php
class user_form extends \core_form\dynamic_form {
    // Kontext für Permission-Checks
    protected function get_context_for_dynamic_submission(): \context {
        global $USER;
        return context_user::instance($USER->id);
    }
    
    // Initialdaten laden
    public function set_data_for_dynamic_submission(): void {
        $data = new \stdClass();
        $data->theme = get_user_preferences('block_compviz_theme', 1);
        $this->set_data($data);
    }
    
    // Verarbeitung nach Submit
    public function process_dynamic_submission(): array {
        $data = $this->get_data();
        set_user_preference('block_compviz_theme', $data->theme);
        return ['result' => true];
    }
}
```

**Wichtig:**
- Form muss von `\core_form\dynamic_form` erben
- `get_page_url_for_dynamic_submission()` muss implementiert sein
- Return von `process_dynamic_submission()` wird als JSON zurückgegeben

---

### 4.3 Problem: CSS Custom Properties und Theme-Kompatibilität

#### Ausgangssituation
Fortschrittsbalken-Farben sollen dynamisch (per User Preference) gesetzt werden, aber auch mit allen Moodle-Themes funktionieren.

#### Lösung: CSS Custom Properties (CSS Variables)
```css
.pb {
    --pb-progress: 60%;
    --pb-fill-color: #22c55e;
    --auto-color: lch(from var(--bg-color) clamp(10, round((100 - l), 100), 95) 0 0);
}
```

**Template-seitige Injection:**
```html
<div class="pb" style="--pb-progress: {{progress}}%; --pb-fill-color: {{color}};">
    {{competence_name}}: {{progress}}%
</div>
```

**Vorteile:**
- Keine Inline-Styles für jedes Element
- Automatische Kontrastberechnung für Text (via `lch(from ...)`)
- Einfache JavaScript-Manipulation wenn nötig
- Theme-Overrides möglich

---

### 4.4 Problem: Gradebook-API Performance bei großen Kursen

#### Ausgangssituation
Bei Kursen mit >100 Studierenden und >50 Grade Items war das Block-Rendering sehr langsam (>5 Sekunden).

#### Analyse
```php
// LANGSAM - pro User einzeln
foreach ($users as $user) {
    $grades = grade_get_course_grades($courseid, $user->id); // N+1 Problem
}
```

#### Lösung: Batch-Loading
```php
// SCHNELLER - alle User auf einmal
$userids = array_keys($users);
$allgrades = grade_get_course_grades($courseid, $userids);
```

**Weitere Optimierungen:**
- Caching von Bewertungskategorien (ändern sich selten)
- `grade_item::fetch_all()` statt einzelne `fetch()`-Calls
- Limit auf sichtbare LEOs (via Block-Konfiguration)

---

### 4.5 Problem: Language String Lokalisierung

#### Best Practices
- **Immer `get_string()` verwenden**, nie hartcodierte Texte
- **Help-Strings mit Suffix `_help`**: `$string['setting_help'] = '...'`
- **Plurale korrekt handhaben**: `get_string('nusers', 'core', $count)`
- **HTML in Language Strings vermeiden** (außer basic formatting wie `<br>`)

**Beispiel aus unserem Plugin:**
```php
// lang/en/block_compviz.php
$string['custom_color_1'] = 'Progress Color highest';
$string['custom_color_1_help'] = 'Color for excellent progress (80-100% complete).';

// Nutzung im Code
$mform->addElement('bccolorpicker', 'custom_color_1', get_string('custom_color_1', 'block_compviz'));
$mform->addHelpButton('custom_color_1', 'custom_color_1', 'block_compviz');
```

---

## 5. Bekannte offene Probleme / TODOs

### 5.1 Funktional
- [ ] **Admin-Interface für Theme-Verwaltung**: Derzeit sind Themes nur via DB editierbar
- [ ] **Farbblindheitsfreundliche Presets**: Zusätzliche vordefinierte Farbthemes für gängige Farbsehschwächen (z.B. Deuteranopie/Protanopie/Tritanopie)
- [ ] **Export-Funktion**: CSV/PDF-Export des Kompetenzüberblicks
- [ ] **Lehrer-Dashboard**: Aggregierte Ansicht für alle Studierenden eines Kurses
- [ ] **Completion-Tracking**: Bessere Integration mit Moodle Activity Completion

### 5.2 Technisch
- [ ] **Unit-Tests erweitern**: Aktuell nur Basic-Tests vorhanden
- [ ] **Behat-Tests**: Keine Acceptance-Tests implementiert
- [ ] **Accessibility**: ARIA-Labels für Screen Reader fehlen teilweise
- [ ] **Mobile Optimization**: Responsive Design funktioniert, aber nicht optimal für Touch

### 5.3 Performance
- [ ] **Caching-Strategie**: Keine Nutzung von Moodle Cache API
- [ ] **Lazy Loading**: LEO-Details könnten on-demand geladen werden
- [ ] **Gradebook-Event Listener**: Block-Invalidierung bei Grade-Updates

### 5.4 Dokumentation
- [ ] **Developer Docs**: Code-Kommentare unvollständig
- [ ] **API-Dokumentation**: Keine öffentliche API-Docs
- [ ] **Video-Tutorials**: Keine Video-Anleitungen für Installation/Nutzung

---

## 6. Architektur-Übersicht

### 6.1 Dateistruktur
```
blocks/compviz/
├── block_compviz.php          # Hauptklasse: get_content(), allowed_formats()
├── version.php                # Plugin-Metadaten
├── settings.php               # Admin-Settings (Global Enable/Disable)
├── edit_form.php              # Block-Instanz-Konfiguration (pro Kurs)
├── styles.css                 # Plugin-Styles
│
├── classes/
│   ├── form/
│   │   ├── colorpicker.php              # QuickForm Basis-Klasse
│   │   ├── colorpicker_form_element.php # Moodle Form Element Wrapper
│   │   └── user_form.php                # Dynamic Form für User Settings
│   ├── output/
│   │   └── renderer.php                 # Custom Renderer für Templates
│   └── privacy/
│       └── provider.php                 # GDPR Privacy Provider
│
├── db/
│   ├── access.php             # Capabilities
│   ├── install.xml            # DB-Schema (XMLDB)
│   ├── install.php            # Post-Install: Default Themes einfügen
│   ├── upgrade.php            # Version-basierte DB-Upgrades
│   └── display_data.php       # Helper-Funktionen für Daten-Aggregation
│
├── lang/
│   ├── en/
│   │   └── block_compviz.php  # Englische Strings
│   └── de/
│       └── block_compviz.php  # Deutsche Strings
│
├── templates/
│   ├── overview_template.mustache                  # Haupt-Block-Ansicht
│   └── form/
│       └── element-bccolorpicker.mustache          # Colorpicker Template
│
├── Docs/
│   ├── Compviz_Install_EN.md              # Installation (English)
│   ├── Compviz_Install_DE.md              # Installation (Deutsch)
│   ├── Compviz_UserGuide_EN.md            # User Guide (English)
│   └── Übergabeprotokol.md                # Diese Datei
│
└── tests/
    └── ...                    # PHPUnit Tests
```

### 6.2 Datenfluss

```
User lädt Kursseite
    ↓
block_compviz->get_content()
    ↓
Prüfung: Block global enabled?
    ↓ Ja
User Preferences laden (Theme, Color Mode, Show Completed)
    ↓
Gradebook API abfragen
    ├─ grade_category::fetch_all() → LEOs
    └─ grade_get_course_grades()   → µLEOs mit Noten
    ↓
Datenaufbereitung (display_data.php)
    ├─ Fortschrittsprozente berechnen
    ├─ Completion-Status auswerten
    └─ Farben aus Theme/Custom Colors zuweisen
    ↓
Template-Context erstellen
    ↓
render_from_template('overview_template', $context)
    ↓
HTML-Output an Block-Region
```

### 6.3 Datenbankschema

**Tabelle: `mdl_block_compviz_colors`**
| Feld    | Typ          | Beschreibung                    |
|---------|--------------|---------------------------------|
| id      | BIGINT(10)   | Auto-Increment PK               |
| name    | VARCHAR(255) | Theme-Name (z.B. "Default")     |
| color1  | VARCHAR(6)   | Hex ohne # (höchster Fortschritt) |
| color2  | VARCHAR(6)   | Hex ohne #                      |
| color3  | VARCHAR(6)   | Hex ohne #                      |
| color4  | VARCHAR(6)   | Hex ohne #                      |
| color5  | VARCHAR(6)   | Hex ohne # (niedrigster Fortschritt) |

**User Preferences (via Moodle Core `user_preferences`)**
- `block_compviz_enabled` (1/0)
- `block_compviz_show_completed` (1/0)
- `block_compviz_theme` (ID aus `block_compviz_colors`)
- `block_compviz_color_mode` ('theme' oder 'custom')
- `block_compviz_custom_color_1` bis `_custom_color_5` (Hex mit #)

---

## 7. Deployment und Testing

### 7.1 Entwicklungsumgebung
- **XAMPP** oder **Docker** (z.B. `moodlebox`)
- **Moodle 4.1+** (getestet bis 4.5)
- **PHP 8.0+** (empfohlen 8.1)
- **MySQL 8.0+** oder **PostgreSQL 13+**

### 7.2 Installation für Entwickler
```bash
cd /path/to/moodle
git clone <repo-url> blocks/compviz
# oder ZIP entpacken nach blocks/compviz

# Moodle-Installer triggern
php admin/cli/upgrade.php

# Oder via Web-UI: Site administration → Notifications
```

### 7.3 Testing
```bash
# Unit Tests
php admin/tool/phpunit/cli/init.php
vendor/bin/phpunit --testsuite block_compviz_testsuite

# Code Style Check
php admin/tool/phpcs/cli/check.php --standard=moodle blocks/compviz/

# Behat (wenn implementiert)
php admin/tool/behat/cli/init.php
vendor/bin/behat --tags=@block_compviz
```

### 7.4 AMD JavaScript und Grunt

#### Was ist AMD?
**AMD (Asynchronous Module Definition)** ist Moodles Standard für JavaScript-Module. Statt Inline-JavaScript in Templates zu schreiben, werden JS-Module in `amd/src/` erstellt und via **Grunt** kompiliert.

#### Warum Grunt?
Grunt kompiliert JavaScript-Dateien:
- Minimiert Code (`.min.js` Dateien)
- Transpiliert moderne JS-Syntax für ältere Browser
- Erstellt Source Maps für Debugging

#### Installation von Grunt (einmalig)

**Voraussetzungen:**
- Node.js und npm installiert (empfohlen: Node 16+)

```bash
cd /path/to/moodle
npm install
```

Dies installiert alle Dependencies aus `package.json`, inklusive Grunt.

#### JavaScript-Entwicklung: Workflow

**1. JavaScript-Modul erstellen**
```bash
blocks/compviz/amd/src/
├── user_settings.js       # Deine Quell-Datei
└── theme_preview.js
```

**2. Grunt ausführen (kompiliert JS)**
```bash
# Im Moodle-Root-Verzeichnis:
npx grunt amd --root=blocks/compviz

# Oder für kontinuierliches Watching (empfohlen während Entwicklung):
npx grunt watch
```

**Ergebnis:**
```bash
blocks/compviz/amd/build/
├── user_settings.min.js       # Minimierte Version
├── user_settings.min.js.map   # Source Map
├── theme_preview.min.js
└── theme_preview.min.js.map
```

**3. Modul in PHP registrieren**
```php
// Im Template oder in der PHP-Datei:
$PAGE->requires->js_call_amd('block_compviz/user_settings', 'init');
```

#### Wichtige Grunt-Commands

```bash
# Alle AMD-Module im gesamten Moodle kompilieren
npx grunt amd

# Nur für ein spezifisches Plugin
npx grunt amd --root=blocks/compviz

# CSS kompilieren (falls SCSS vorhanden)
npx grunt css

# Alles kompilieren (AMD + CSS)
npx grunt

# Watch-Modus (automatisches Kompilieren bei Änderungen)
npx grunt watch
```

#### Wichtig: Version und Cache

**⚠️ KRITISCH:** Änderungen an JavaScript, CSS oder Language Strings erfordern **IMMER**:

1. **Version erhöhen** in `version.php`:
   ```php
   $plugin->version = 2025120607; // Vorher: 2025120606
   ```

2. **Cache purgen** (eine der folgenden Methoden):
   ```bash
   # Via CLI:
   php admin/cli/purge_caches.php
   
   # Oder via Web-UI:
   # Site administration → Development → Purge all caches
   ```

**Warum?**
Moodle cachet kompilierte JavaScript- und CSS-Dateien aggressiv. Ohne Cache-Reset werden alte Versionen ausgeliefert.

**Developer Mode wurde entfernt:**
In älteren Moodle-Versionen (vor 4.0) gab es einen "Developer Mode" (`$CFG->cachejs = false;`), der automatisches Cache-Purging aktivierte. **Dieser Modus wurde in Moodle 4.0 entfernt** ([siehe MDL-71007](https://tracker.moodle.org/browse/MDL-71007)).

**Best Practice:**
- Version nach **jedem Merge in main/master** erhöhen
- `npx grunt watch` während der Entwicklung laufen lassen
- Nach JS/CSS-Änderungen immer Cache purgen und Browser-Cache leeren (Ctrl+Shift+R)

#### Debugging von AMD-Modulen

**Problem:** Fehler in JavaScript-Modulen sind schwer zu debuggen, da Browser die minimierten `.min.js`-Dateien laden.

**Lösung:**
```php
// In config.php während Entwicklung:
$CFG->cachejs = false; // NUR für Moodle < 4.0!

// Für Moodle 4.0+: Nutze Source Maps
// Browser DevTools → Sources → webpack:// → blocks/compviz/amd/src/
```

**Typische Fehler:**
- **Fehler:** `Module not found: block_compviz/my_module`  
  **Lösung:** Vergessen, Grunt auszuführen → `npx grunt amd --root=blocks/compviz`
  
- **Fehler:** Änderungen werden nicht geladen  
  **Lösung:** Cache nicht gepurged → `php admin/cli/purge_caches.php`

- **Fehler:** Syntax Error in Console  
  **Lösung:** Prüfe `amd/src/*.js` auf Fehler, Grunt kompiliert auch fehlerhafte Dateien

---

## 8. GitHub Actions und Release-Management

### 8.1 Automatisierte Release-Erstellung

Das Repository nutzt **GitHub Actions**, um automatisch Release-Artefakte zu erstellen. Dies vereinfacht die Verteilung des Plugins erheblich.

#### Workflow-Funktionalität

**Datei:** `.github/workflows/release.yml`

**Trigger:** Erstellen eines Git-Tags

**Workflow:**
1. Erkennt neuen Tag im Repository
2. Checkout des Codes bei exakt diesem Tag
3. Erstellt ZIP-Archiv im Moodle-Plugin-Format:
   - **Korrekte Ordnerstruktur:** `compviz/` (nicht `block_compviz-v0.0.3/`)
   - **Exkludiert Development-Dateien:** `.git`, `.github`, `node_modules`, `.vscode`
   - **Inkludiert nur Plugin-Dateien:** `*.php`, `lang/`, `templates/`, `db/`, `amd/build/` etc.
4. Erstellt GitHub Release mit:
   - Release-Titel basierend auf Tag
   - Release-Notes (automatisch generiert aus Commits)
   - Angehängtes ZIP-File (`compviz-<version>.zip`)

#### Tag-Namenskonvention

**Format:**
```
v<Major>.<Group>.<Semester>-<Maturity>.<Sprint>
```

**Komponenten:**
- **Major:** Große Breaking Changes (aktuell: `0`)
- **Group:** Anzahl Teams, die bereits am Projekt gearbeitet haben (Start-Team: `0`, zweites Team: `1`, etc.)
- **Semester:** Semester innerhalb der Gruppe (1-3, da 3 Semester pro Gruppe)
- **Maturity:** `alpha`, `rc` (Release Candidate), oder weglassen für Stable
- **Sprint:** Sprint-Nummer innerhalb des Semesters

**Beispiele:**
```bash
# Start-Team (Group 0), Semester 3, Sprint 5, Alpha
v0.0.3-alpha.5

# Zweites Team (Group 1), Semester 1, Sprint 2, Alpha
v0.1.1-alpha.2

# Drittes Team (Group 2), Semester 2, Sprint 3, Release Candidate
v0.2.2-rc.3

# Erstes Stable Release (nach mehreren Teams)
v1.0.0
```

#### Tag-Commit-Message-Konvention

**Format:**
```
<Studienjahr> - <Semester> - <Kurs> - Sprint <Nummer>
```

**Beispiel:**
```bash
2025/26 - Winter - INNO3 - Sprint 5
```

#### Tag erstellen und Release auslösen

**Option 1: Tag auf aktuellen Commit**
```bash
git tag -a v0.0.3-alpha.5 -m "2025/26 - Winter - INNO3 - Sprint 5"
git push origin v0.0.3-alpha.5
```

**Option 2: Tag auf spezifischen Commit (empfohlen für Sprint-Abschluss)**
```bash
# Commit-Hash finden:
git log --oneline

# Tag auf spezifischen Commit erstellen:
git tag -a v0.0.3-alpha.5 -m "2025/26 - Winter - INNO3 - Sprint 5" a071ca0

# Tag pushen (löst GitHub Action aus):
git push origin v0.0.3-alpha.5
```

**Option 3: Via GitHub UI**
1. Gehe zu **Releases** → **Create a new release**
2. Klicke auf **Choose a tag** → Tag-Name eingeben (z.B. `v0.0.3-alpha.5`)
3. Target auswählen (Branch oder Commit)
4. Release-Titel und -Beschreibung eingeben
5. **Publish release** → GitHub Action läuft automatisch und hängt ZIP an

#### Best Practices für Releases

**Wann einen Tag erstellen?**
- ✅ Am Ende jedes Sprints (auch wenn nicht alle Features fertig sind)
- ✅ Vor Übergabe an nächstes Team
- ✅ Bei signifikanten Bugfixes
- ✅ Für Testing/Staging-Deployments

**Pre-Release vs. Stable Release:**
- **Alpha:** Feature-incomplete, experimentell
- **RC (Release Candidate):** Feature-complete, aber noch in Testing
- **Stable (ohne Suffix):** Production-ready (erst nach umfangreichem Testing)

**Release Notes pflegen:**
```bash
# Bei Tag-Erstellung:
git tag -a v0.0.3-alpha.5 -m "2025/26 - Winter - INNO3 - Sprint 5

Neue Features:
- Custom Colorpicker implementiert
- User Settings Modal mit AJAX
- 5 vordefinierte Themes

Bugfixes:
- Performance-Optimierung bei großen Kursen
- CSS-Fix für Mobile View"
```

#### Troubleshooting

**Problem:** GitHub Action schlägt fehl  
**Lösung:** Prüfe `.github/workflows/release.yml` auf Syntax-Fehler, checke Action-Logs

**Problem:** ZIP hat falsche Struktur (z.B. `block_compviz-main/` statt `compviz/`)  
**Lösung:** Workflow muss `base-path` setzen und Root-Folder umbenennen

**Problem:** Tag wurde versehentlich falsch erstellt  
**Lösung:** 
```bash
# Lokal löschen:
git tag -d v0.0.3-alpha.5

# Remote löschen:
git push --delete origin v0.0.3-alpha.5

# Neu erstellen mit korrektem Namen/Commit
```

**Problem:** Release existiert, aber ZIP fehlt  
**Lösung:** GitHub Action manuell erneut triggern oder ZIP manuell hochladen

---

## 9. Hilfreiche Ressourcen

### 9.1 Offizielle Moodle-Dokumentation
- **Plugin Development**: https://moodledev.io/docs/4.5/apis/plugintypes/blocks
- **Form API**: https://moodledev.io/docs/4.5/apis/subsystems/form
- **Privacy API**: https://moodledev.io/docs/4.5/apis/subsystems/privacy
- **Grades API**: https://moodledev.io/docs/4.5/apis/subsystems/grade
- **XMLDB Editor**: https://moodledev.io/general/development/tools/xmldb

### 9.2 Moodle Code-Style
- **Coding Style**: https://moodledev.io/general/development/policies/codingstyle
- **PHPdoc Guidelines**: https://moodledev.io/general/development/policies/phpdoc
- **JavaScript Guidelines**: https://moodledev.io/general/development/policies/javascript
- **Grunt/AMD Documentation**: https://moodledev.io/general/development/tools/nodejs

### 9.3 Community
- **Moodle Forums**: https://moodle.org/course/view.php?id=5
- **Moodle Plugins Directory**: https://moodle.org/plugins/
- **Stack Overflow**: Tag `[moodle]`

---

## 10. Tipps für die Weiterentwicklung

### 10.1 Code-Qualität
- **✅ PFLICHT: PHPDoc-Kommentare** für **alle** Klassen, Methoden, Parameter und Properties
  ```php
  /**
   * Retrieves user preferences for the compviz block.
   *
   * @param int $userid The user ID to fetch preferences for
   * @param int $courseid The course ID context
   * @return array Associative array of preferences
   * @throws moodle_exception If user does not exist
   */
  public function get_user_preferences(int $userid, int $courseid): array { ... }
  ```
- **✅ PFLICHT: Moodle Coding Standards** (nutze `phpcs` vor jedem Commit)
- **Schreibe Tests für neue Features** (PHPUnit + Behat)
- **Nutze Type Hints** (PHP 7.4+: Pflicht für alle neuen Funktionen)
- **Keine Inline-JavaScript** in Templates (nur AMD-Module nutzen)

### 10.2 Performance
- **Verwende Moodle Cache API** für teure DB-Queries
- **Profiling**: `$CFG->perfdebug = 15;` für Performance-Debugging
- **Lazy Loading**: Lade nur Daten, die wirklich angezeigt werden

### 10.3 Security
- **Immer `required_param()`** / `optional_param()` für User-Input
- **SQL-Injections vermeiden**: Nutze `$DB->get_records()` statt raw SQL
- **XSS-Prevention**: `s()` für String-Ausgabe, `format_text()` für User-Content
- **Capabilities prüfen**: `require_capability('block/compviz:view', $context)`

### 10.4 Wartbarkeit
- **Versionierung**: Erhöhe `$plugin->version` bei **jedem** JS/CSS/String-Change (nicht nur DB-Changes!)
- **Upgrade-Pfade**: Teste Upgrades von älteren Versionen
- **Deprecation-Hinweise**: Markiere alte Funktionen mit `@deprecated`
- **Changelog führen**: Dokumentiere alle Änderungen in `README.md` oder `CHANGELOG.md`
- **Git Tags nutzen**: Erstelle Release-Tags nach jedem Sprint (siehe Abschnitt 8: GitHub Actions)

---

## 11. Hinweise für Nachfolge-Teams

### 11.1 Vor dem Start: Hilfreiche Informationen

Bevor ihr mit der Arbeit am Plugin beginnt, lest bitte folgende Abschnitte:

1. **Abschnitt 3**: Grundlegende Erkenntnisse zur Moodle-Plugin-Entwicklung
   - Ordnerstruktur und essentielle Dateien
   - Wichtige Moodle-APIs verstehen
   - Datenbankschema-Management

2. **Abschnitt 4**: Erweiterte Probleme und Lösungen
   - **Besonders wichtig: 4.1 Custom Colorpicker** - Lest dies vollständig, falls ihr ähnliche Custom Form Elements implementieren wollt
   - Versteht, warum bestimmte Ansätze gescheitert sind, bevor ihr ähnliche Probleme angeht

3. **Abschnitt 7.4**: AMD JavaScript und Grunt
   - **WICHTIG:** Versteht den Grunt-Workflow, bevor ihr JavaScript schreibt
   - Keine Inline-JS in Templates!

4. **Abschnitt 8**: GitHub Actions und Release-Management
   - Versteht die Tag-Konvention **vor** eurem ersten Commit

5. **Abschnitt 10**: Tipps für die Weiterentwicklung
   - Moodle Coding Standards (PHPDoc ist Pflicht!)
   - Versionierung bei JS/CSS/String-Änderungen

### 11.2 Genauere Versionierung und Releases Aufschlüsselung für Nachfolge-Teams

#### Maturity Levels

**Wann welcher Status?**
- **Alpha:** Feature-incomplete, experimentell (empfohlen für erste 2-3 Sprints)
- **RC (Release Candidate):** Feature-complete, aber noch in Testing (ab Sprint 4-5)
- **Stable (ohne Suffix):** Production-ready - erst nach umfangreichem Testing und wenn das Team der Meinung ist, das Plugin ist produktionsreif

**Entscheidung liegt beim Team:** Wenn ihr als Team entscheidet, dass das Plugin stabil genug ist, könnt ihr von `alpha` zu `rc` oder direkt zu stable wechseln.

#### Tag-Konvention für Group 1 (nächstes Team)

**Euer erster Tag sollte sein:**
```bash
v0.1.1-alpha.1
```

**Erklärung:**
- `0` = Major Version (noch kein Breaking Release)
- `1` = Group 1 (ihr seid das zweite Team, Group 0 war das Start-Team)
- `1` = Semester 1 (euer erstes Semester am Projekt)
- `alpha` = Maturity Level (ändert zu `rc` wenn Feature-complete)
- `1` = Sprint 1

**Beispiel-Tags für Group 1:**
```bash
# Semester 1
v0.1.1-alpha.1  # Sprint 1
v0.1.1-alpha.2  # Sprint 2
v0.1.1-rc.3     # Sprint 3 (Team entscheidet: jetzt RC)
v0.1.1-rc.4     # Sprint 4
v0.1.1          # Sprint 5 (stable release)

# Semester 2
v0.1.2-alpha.1  # Sprint 1
v0.1.2-alpha.2  # Sprint 2
# ...

# Semester 3
v0.1.3-rc.1     # Sprint 1
v0.1.3          # Sprint 5 (finaler stable release von Group 1)
```

**Tag-Commit-Message für Group 1:**
```bash
git tag -a v0.1.1-alpha.1 -m "2026/27 - Winter - INNO1 - Sprint 1" <commit-hash>
```

#### Group 2 und darüber hinaus

**Group 2 startet mit:**
```bash
v0.2.1-alpha.1  # Group 2, Semester 1, Sprint 1
```

**Generelles Pattern:**
```
v<Major>.<Group>.<Semester>-<Maturity>.<Sprint>
```

### 11.3 Kritische Punkte: Häufige Fehler vermeiden

#### ⚠️ Versionierung
**IMMER `$plugin->version` erhöhen bei:**
- ✅ JavaScript-Änderungen (auch kleine Fixes!)
- ✅ CSS-Änderungen
- ✅ Language String-Änderungen
- ✅ Datenbankschema-Änderungen
- ✅ Template-Änderungen (Mustache)

**Nach Version-Bump:**
```bash
php admin/cli/purge_caches.php
# Oder: Site administration → Development → Purge all caches
```

#### ⚠️ Grunt Workflow
```bash
# VOR jedem Commit mit JS-Änderungen:
npx grunt amd --root=blocks/compviz

# ODER: Watch-Modus während Entwicklung:
npx grunt watch
```

**Vergessenes Grunt-Kompilieren**

#### ⚠️ PHPDoc
**Jede neue Funktion/Klasse braucht:**
```php
/**
 * Brief description.
 *
 * Longer description if needed.
 *
 * @param int $param Description
 * @return string Description
 * @throws moodle_exception When something fails
 */
```

**Coding Standards prüfen:**
```bash
php admin/tool/phpcs/cli/check.php --standard=moodle blocks/compviz/
```

### 11.4 Ideen als erste Schritte

**Sprint 1 (Woche 1-2):**
1. Repository klonen und lokales Moodle aufsetzen
2. Plugin installieren und alle Features testen
3. Diese Dokumentation **vollständig** lesen
4. Bestehenden Code reviewen (besonders `block_compviz.php`, `user_form.php`)
5. Grunt-Workflow verstehen und testen

### 11.5 Fragen und Support

**Bei Fragen zur Codebase:**
1. ✅ **Prüfe zuerst diese Dokumentation** (insbesondere Abschnitt 4: Erweiterte Probleme)
2. ✅ **Checke GitHub Issues und Releases** für bekannte Probleme und Lösungen
3. ✅ **Checke das Project Diary** das in zusammenhang mit dem Projet entstanden ist.
4. ✅ **Lese die Git-Commit-History** für Kontext zu spezifischen Features
   ```bash
   git log --oneline --graph --all
   git log --author="Dahlke" --grep="colorpicker"
   ```
5. ✅ **Kontaktiert das Start-Team** via GitHub Discussions oder Issues

**Dokumentiert eure eigenen Learnings:**
- Fügt einen neuen Abschnitt "11.6 Learnings von Group 1" hinzu
- Dokumentiert neue Probleme und Lösungen ähnlich wie Abschnitt 4
- Aktualisiert TODOs in Abschnitt 5

---

## 12. Kontakt und Übergabe

### 12.1 Start-Team (Group 0)
- **Team:** BIF-INNO-Group10
- **Autoren:**
  - Sebastian Dahlke <if23b234@technikum-wien.at>
  - Mateo Rašo <if23b100@technikum-wien.at>
  - Sophie Hauser <if23b285@technikum-wien.at>
  - Sophie Wiesner <if23b290@technikum-wien.at>
  - Andor István Kurucz <if23b110@technikum-wien.at>
- **Institution:** Technikum Wien
- **Zeitraum:** WS2024 - SS2026 (INNO1, INNO2, INNO3)
- **Finale Version:** v0.0.3-alpha.7 (Sprint 7, INNO3)

### 12.2 Repository
- **GitHub:** https://github.com/sdahlke5083/BIF3-WS2024-INNO1
- **Releases:** https://github.com/sdahlke5083/BIF3-WS2024-INNO1/releases
- **Latest Release:** v0.0.3-alpha.5 (automatisch via GitHub Actions erstellt)

### 12.3 Lizenz
- **Lizenz:** GNU GPL v3 or later
- **Copyright:** 2024-2026 BIF-INNO-Group10

---

## 13. Schlusswort

Dieses Plugin ist ein solides Foundation für einen Competence Visualization Block. Die Kern-Features funktionieren, aber es gibt viel Raum für Erweiterungen (siehe Abschnitt 5: Offene TODOs).

**Wichtigste Learnings:**
- **Moodle Coding Standards sind Pflicht**: PHPDoc, Code Style, keine Inline-JS
- **Versionierung ist kritisch**: JS/CSS/String-Änderungen **immer** mit Version-Bump und Cache-Reset
- **Moodle's Form API** ist mächtig, aber erfordert Deep Dive in QuickForm
- **Custom Form Elements** brauchen 3 Komponenten: Base-Klasse, Moodle-Wrapper, Template
- **Gradebook API** ist komplex – investiert Zeit in API-Dokumentation
- **User Preferences** sind einfacher als Custom DB-Tables für User-Settings
- **CSS Custom Properties** sind der Schlüssel zu dynamischen Themes
- **Grunt/AMD Workflow** muss verstanden sein (siehe Abschnitt 7.4)
- **GitHub Actions** automatisiert Release-Erstellung (siehe Abschnitt 8)

**An alle Nachfolge-Teams:** Lest bitte **Abschnitt 11 (Hinweise für Nachfolge-Teams)** vollständig, bevor ihr startet!

**Viel Erfolg bei der Weiterentwicklung!** 🚀

---

**Letzte Aktualisierung:** Januar 2026  
**Plugin-Version:** v0.0.3-alpha.5 (Group 0, Semester 3, Sprint 5)  
**Moodle-Kompatibilität:** 4.1+ (Requires: 2022112800)  
**Start-Team:** BIF-INNO-Group10 (Sebastian Dahlke, Mateo Rašo)
