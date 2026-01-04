# Installation Guide – Moodle Block „Competence Visualization“ (block_compviz)

This plugin is a Moodle **[block plugin](https://moodledev.io/docs/4.5/apis/plugintypes/blocks)** and must be installed under the **`/blocks/`** directory.

[TOC]

## Prerequisites

- You already have a running Moodle installation and **administrative access**.
- Moodle version: **Moodle 4.1 or newer** (minimum plugin requirement: `requires = 2022112800`).
- If you install via the web UI (ZIP upload), the web server must have write access to the Moodle directory. If that is not possible, use the manual file-system installation below.
- Recommended: make a backup or snapshot of your Moodle site before installing (this plugin is in alpha maturity at the time of writing).
- See the [Important course specific prerequisite](#important-course-specific-prerequisite) section for course-level requirements so the block can display meaningful data.

---

## Option A — Installation via Moodle UI (ZIP upload)

1. Download the plugin archive from the project releases (see [Github-Repository](https://github.com/sdahlke5083/BIF3-WS2024-INNO1/releases)).
2. Log in to your Moodle site with an administrative account.
3. Go to **Site administration → Plugins → Install plugins**.
   
   ![Image showing how to navigate to install plugins.](ressources/install_en_site-administration.png)
   
4. Choose the ZIP archive and upload it using the UI. Moodle will inspect the archive and show the detected plugin type and the destination path it intends to use. Before continuing, confirm the detected plugin type is **Block** and the destination path ends with `/blocks/compviz`.

   - Note: depending on how the ZIP was created it may contain a top-level folder named `compviz`, `block_compviz`, or `compviz-x.y.z`. Moodle's installer shows the expected destination path during the validation step — check that path before proceeding.

5. If validation succeeds, follow the on-screen prompts and click **Continue** / **Upgrade Moodle database now** when prompted.
6. After the install completes, Moodle typically redirects you to the Notifications page. If not, open **Site administration → General → Notifications** to finish the installation.

Note: If you do not see the **Install plugins** option, your hosting provider may disable plugin installs via the web UI (for example some hosted Moodle services). In that case use [Option B (manual installation)](#option-b--manual-installation-on-the-server-file-system).

---

## Option B — Manual installation on the server (file system)

1. Unzip the plugin archive on your local machine.
2. Copy the unzipped plugin folder to your Moodle server under:

   - `{MOODLE_DIRROOT}/blocks/compviz`

   The plugin directory must be named `compviz`. If your unzipped folder is named `block_compviz` or `compviz-master`, rename it to `compviz` before copying.

3. Ensure the web server user has read access to the new files. On Linux this typically means setting ownership/permissions similar to other folders under `blocks/` (for example using `chown` / `chmod` as appropriate). On Windows, ensure the IIS/Apache service account has read access.

4. Trigger the Moodle installation process by visiting **Site administration → General → Notifications** while logged in as an administrator. Moodle will detect the new plugin and run the upgrade/install steps.

5. If the plugin does not appear after Notifications, verify that the folder structure contains the expected plugin files (for example `block_compviz.php`, `version.php`, `lang/`, `classes/`, `README.md`) and that the folder is placed at `{MOODLE_DIRROOT}/blocks/compviz`.

---

## After installation — quick checks

### 1) Confirm the plugin is installed

- Open **Site administration → Plugins → Plugin overview** and search for "Competence Visualization" or `block_compviz`.

  ![Image showing how to navigate to plugin overveiw](ressources/install_en_site-administration2.png)

- Verify the plugin is listed and shows as installed.

  ![Image showing the plugin as installed.](ressources/install_en_plugin-overview.png)

### 2) Add the block to a course (teacher or manager)

1. Open the desired course as a user with editing permissions.

2. Turn on Edit mode (usually a button near the top-right of the course page).

3. From the Add a block menu, choose **Competence Visualization**.

   ![Image showing how to ad block.](ressources/install_en_add-block.png)

4. While still in edit mode, open the block settings (gear icon). 

   ![Image showing how to open the Block configurations.](ressources/install_en_open-configure-block.png)

5. Then set the **Select Learning Outcome Category** to the grade category set you want the block to visualize.

   ![Image showing how to select grading category.](ressources/install_en_configure-block.png)

Default permissions (according to the plugin capabilities):

- Managers and editing teachers are allowed to add the block.
- Users with the `block/compviz:show_graph` capability may view the block content.

---

## Important course-specific prerequisite

The block derives its structure and data from the course **gradebook**. In brief:

- **LEO Category**: assessment categories that group all learning outcomes.
- **LEOs**: sub-categories that contain the µLEOs.
- **µLEOs**: individual grade items (activities, quizzes, assignments) mapped to an LEO.

If your course does not have grade categories or competencies arranged in this way, the block may show no data.

---

## Activity completion – optional, but recommended

The plugin can use completion states (for example Passed/Failed) from activities such as quizzes. For this to work, activity completion must be enabled and configured for the respective activity in the course.

---

## Uninstall

1. Log in as an administrator and go to **Site administration → Plugins → Plugin overview**.
2. Find `block_compviz` and choose **Uninstall**.
3. Follow the on-screen prompts. If Moodle reports the plugin is in use, resolve those uses before uninstalling.
4. Moodle normally removes the plugin code during uninstall; if it does not, remove the folder `{MOODLE_DIRROOT}/blocks/compviz` manually.

---

## Troubleshooting (typical cases)

- **UI installation fails / no write access:** install manually via Option B.
- **Nothing happens after copying files:** ensure the folder is correctly named and contains the plugin files (see step 5 in Option B), then open **Site administration → General → Notifications** to trigger installation.
- **Block shows no data:** check the gradebook categories/items and ensure the block instance is configured to point to the correct category or competency set.
- **Permission problems when adding:** verify roles and capabilities (manager or editing teacher roles generally can add the block).

