# Admin-Installationsanleitung – Moodle Block „Competence Visualization“ (block_compviz)

Dieses Plugin ist ein **Block-Plugin** und muss daher im Moodle-Codebaum unter **`/blocks/`** installiert werden.

## Voraussetzungen

- Du hast bereits eine laufende Moodle-Installation und **Admin-Zugang**.
- Moodle-Version: **Moodle 4.1 oder neuer** (Plugin-Mindestanforderung: `requires = 2022112800`).
- Wenn du per Web-Upload installierst: Der Webserver muss **Schreibrechte** im Moodle-Verzeichnis haben (sonst manuelle Installation). 
- Empfohlen: Backup/Snapshot vor Installation (v. a. da „alpha“-Reifegrad).

---

## Option A: Installation über Moodle-UI (ZIP Upload)

1. Als Admin einloggen.
2. Navigiere zu: **Site-Administration → Plugins → Install plugins**. 
3. **ZIP-Datei hochladen** (die ZIP muss den Plugin-Ordner `compviz` enthalten).
4. Moodle zeigt einen **Validierungsbericht**:
   - Prüfe Plugin-Typ (Block) und Zielpfad.
   - Klicke auf **Installation fortsetzen**.
1. Danach (falls nicht automatisch): **Website-Administration → Mitteilungen (Notifications)** aufrufen und das Upgrade/Installationsscreen abschließen.

**Hinweis:** Wenn du den Menüpunkt „Plugins installieren“ nicht siehst, kann dein Hosting (z. B. MoodleCloud) Plugin-Installationen über die UI blockieren. 

---

## Option B: Manuelle Installation am Server (Dateisystem)

1. ZIP lokal entpacken.
2. Den entpackten Ordner **`compviz`** nach folgendem Ziel kopieren:

   - **`{MOODLE_DIRROOT}/blocks/compviz`**

   (Wichtig: Ordnername muss **`compviz`** heißen.)

3. Dateirechte/Owner so setzen, dass Moodle die Dateien lesen kann (typisch: gleiche Rechte wie bei anderen Ordnern in `/blocks`).
4. Installation abschließen über:
   - Web: **Website-Administration → Mitteilungen (Notifications)** 

---

## Nach der Installation: Funktion prüfen

### 1) Plugin in der Plugin-Übersicht finden
- **Site-Administration → Plugins → Plugin-Übersicht**
- Suche nach: **Competence Visualization** / **block_compviz**
- Prüfe, ob es **installiert/aktiviert** ist.

### 2) Block in einem Kurs hinzufügen (für Lehrende/Manager)
1. Kurs öffnen
2. **Bearbeiten einschalten**
3. **Block hinzufügen** → „Competence Visualization“
4. Block konfigurieren (Instanz-Einstellungen):
   - **“Select Learning Outcome Category”** auswählen (Gradebook-Kategorie für LEOs)

**Standardrechte (laut Plugin-Capabilities):**
- *Manager* und *Editing teacher* dürfen den Block hinzufügen.
- Nutzer dürfen den Graph/Blockinhalt sehen (Capability: `block/compviz:show_graph`).

---

## Wichtige fachliche Voraussetzung (damit der Block sinnvoll etwas anzeigt)

Der Block bezieht seine Struktur aus dem **Notenbuch**:

- **LEOs** = (Unter-) **Bewertungskategorien**
- **µLEOs** = **Einzelne Bewertungs-Items** (z. B. aus Aktivitäten/Quizzes), die in den LEO-Kategorien liegen

Wenn im Kurs keine passenden (Unter-)Kategorien existieren, kann der Block leer wirken.

---

## Aktivitätsabschluss (Completion) – optional, aber empfohlen

Der Block kann bei **Quiz-Aktivitäten** Completion-Status (z. B. „Passed/Failed“) berücksichtigen.  
Damit das funktioniert, muss Completion in Moodle/Kurs entsprechend aktiviert und für die Aktivität konfiguriert sein.

---

## Deinstallation

1. **Site-Administration → Plugins → Plugin-Übersicht**  
2. Beim Plugin auf **Deinstallieren** klicken.
3. Danach den Plugin-Ordner **`{MOODLE_DIRROOT}/blocks/compviz`** manuell löschen, sonst wird das Plugin beim nächsten Admin-Aufruf wieder erkannt.

---

## Troubleshooting (typische Fälle)

- **UI-Installation klappt nicht / kein Schreibzugriff:** Manuell installieren (Option B).
- **Nach Kopieren passiert nichts:** Sicherstellen, dass der Ordner wirklich `blocks/compviz` ist und dann **Notifications** aufrufen.
- **Block zeigt nichts an:** Notenbuch-Kategorien/Items prüfen und im Block die richtige LEO-Kategorie auswählen.
- **Rechteproblem beim Hinzufügen:** Rollen/Capabilities prüfen (Manager/Editing teacher).
