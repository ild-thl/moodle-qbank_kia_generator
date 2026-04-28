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

namespace qbank_kia_generator;

use stdClass;
//use core_courseformat\output\local\content\cm\cmname;
//use core_courseformat\base as course_format;

/**
 * Class for providing helper functions
 *
 * @package     qbank_kia_generator
 * @author      Jan Rieger, ISy, TH Lübeck
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

class helper {
    
    public function get_mods_with_content($courseid) {
        global $DB, $OUTPUT, $PAGE;

        $mods = array();

        // mod label
        if ($labels = $DB->get_records('label', array('course' => $courseid))) {
            $icon = $OUTPUT->pix_icon('icon', '', 'mod_label');
            foreach ($labels as $label) {
                $title = \html_writer::div($icon . ' ' . $label->name);

                $mod = new stdClass();
                $mod->name = 'mod_label';
                $mod->id = $label->id;
                $mod->title = $title;

                $mods[] = $mod;
            }
        }

        // mod page
        if ($pages = $DB->get_records('page', array('course' => $courseid))) {
            $icon = $OUTPUT->pix_icon('icon', '', 'mod_page');
            foreach ($pages as $page) {
                $title = \html_writer::div($icon . ' ' . $page->name);

                $mod = new stdClass();
                $mod->name = 'mod_page';
                $mod->id = $page->id;
                $mod->title = $title;

                $mods[] = $mod;
            }
        }

        // mod resource
        if ($resources = $DB->get_records('resource', array('course' => $courseid))) {
            $icon = $OUTPUT->pix_icon('icon', '', 'mod_resource');
            foreach ($resources as $resource) {
                // check if resource has a file with allowed mimetype
                if ($this->check_resource_files($resource) === false) {
                    continue;
                }
                $title = \html_writer::div($icon . ' ' . $resource->name);

                $mod = new stdClass();
                $mod->name = 'mod_resource';
                $mod->id = $resource->id;
                $mod->title = $title;

                $mods[] = $mod;
            }
        }

        // mod folder
        if ($folders = $DB->get_records('folder', array('course' => $courseid))) {
            $icon = $OUTPUT->pix_icon('icon', '', 'mod_folder');
            foreach ($folders as $folder) {
                if ($cm = get_coursemodule_from_instance('folder', $folder->id, 0, false, MUST_EXIST)) {
                    $context = \context_module::instance($cm->id);
                    $fs = get_file_storage();
                    $files = $fs->get_area_files(
                        $context->id, 
                        'mod_folder', 
                        'content', 
                        0, 
                        'sortorder', 
                        false);
                    foreach ($files as $file) {
                        if ($this->is_allowed_text_mimetype($file->get_mimetype()) === false) {
                            continue;
                        }
                        $title = \html_writer::div($icon . ' ' . $file->get_filename());
                        $mod = new stdClass();
                        $mod->name = 'mod_folder';
                        $mod->id = $file->get_id();
                        $mod->title = $title;
                        $mods[] = $mod;
                    }
                }
            }
        }

        return $mods;
    }

    public function get_sourcetexts($mods) {
        global $DB;
        $sourcetexts = array();
        if (!empty($mods['mod_label'])) {
            foreach ($mods['mod_label'] as $labelid) {
                if ($label = $DB->get_record('label', array('id' => $labelid))) {
                    $sourcetexts[] = $label->intro;
                }
            }
        }
        if (!empty($mods['mod_page'])) {
            foreach ($mods['mod_page'] as $pageid) {
                if ($page = $DB->get_record('page', array('id' => $pageid))) {
                    $sourcetexts[] = $page->content;
                }
            }
        }
        if (!empty($mods['mod_folder'])) {
            foreach ($mods['mod_folder'] as $fileid) {
                if ($content = $this->get_text_from_file($fileid)) {
                    $sourcetexts[] = $content;
                }
            }
        }
        if (!empty($mods['mod_resource'])) {
            foreach ($mods['mod_resource'] as $resourceid) {
                if ($files = $this->get_resource_files($resourceid)) {
                    foreach ($files as $file) {
                        if ($sourcetext = $this->get_text_from_file($file->get_id())) {
                            $sourcetexts[] = $sourcetext;
                        }
                    }
                }
            }
        }
        return $sourcetexts;
    }

    /**
     * Helper method that returns all files of a resource
     * @param object $resourceid: The resource ID to get the files from
     * @return array: An array of file objects or false if no files found
     */
    public function get_resource_files($resourceid) {
        if ($cm = get_coursemodule_from_instance('resource', $resourceid, 0, false, MUST_EXIST)) {
            $context = \context_module::instance($cm->id);
            $fs = get_file_storage();
            $files = $fs->get_area_files(
                $context->id, 
                'mod_resource', 
                'content', 
                0, 
                'sortorder', 
                false);
            return $files;
        }
        return false;
    }

    /**
     * Helper method that checks if a resource contains at least one file with an allowed mimetype
     * @param object $resource: The resource to check
     * @return bool: True if the resource contains at least one file with an allowed mimetype, false otherwise
     */
    public function check_resource_files($resource) {
        if ($files = $this->get_resource_files($resource->id)) {
            foreach ($files as $file) {
                if ($this->is_allowed_text_mimetype($file->get_mimetype())) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Helper method that checks if a mimetype is an allowed text mimetype
     * @param string $mimetype: The mimetype to check
     * @return bool: True if the mimetype is allowed, false otherwise
     */
    public function is_allowed_text_mimetype($mimetype) {
        $allowedmimetypes = [
            'text/plain',
            //'text/html',
            //'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            //'application/vnd.ms-powerpoint',
            //'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            //'application/vnd.oasis.opendocument.text',
            'application/pdf',
            //'application/rtf',
            //'text/markdown'
        ];
        return in_array($mimetype, $allowedmimetypes, true);
    }

    /**
     * Helper method for getting text from a file
     * @param int $fileid: The file ID to get the text from
     * @return string: The text from the file
     */
    public function get_text_from_file($fileid) {
        global $DB;
        if ($filerecord = $DB->get_record('files', array('id' => $fileid))) {
            
            // get single file
            $fs = get_file_storage();
            $file = $fs->get_file_by_id($filerecord->id);
            if (!$file) {
                return false;
            }
            $mimetype = $file->get_mimetype();
            if ($this->is_allowed_text_mimetype($mimetype) === false) {
                return false;
            }
            if ($mimetype === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                return $this->get_text_from_word_document($file);
            }
            if ($mimetype === 'application/pdf') {
                return $this->get_text_from_pdf_document($file);
            }
            if ($mimetype === 'text/plain') {
                return $this->get_text_from_text_file($file);
            }
        }   
        return false;
    }

    /**
     * Helper method for getting text from a text file
     * @param object $file: The file object to get the text from
     * @return string: The text from the text file or false on failure
     */
    public function get_text_from_text_file($file) {
        if ($file->get_mimetype() !== 'text/plain') {
            return false;
        }

        $content = $file->get_content();

        $encoding = mb_detect_encoding($content, [
            'UTF-8', 'ISO-8859-1', 'ISO-8859-15', 'Windows-1252', 'ASCII'
        ], true);

        if ($encoding && $encoding !== 'UTF-8') {
            $content = mb_convert_encoding($content, 'UTF-8', $encoding);
        }

        // Entferne nicht konvertierbare Zeichen
        $content = iconv('UTF-8', 'UTF-8//IGNORE', $content);
        // Entferne nicht druckbare Zeichen (außer Zeilenumbrüche und Tabs)
        $content = preg_replace('/[^\PC\s]/u', '', $content);
        $content = preg_replace('/\s+/', ' ', $content);
        $content = trim($content);

        return $content;
    }

    /**
     * Helper method for getting text from a PDF document.
     * Converts PDF pages to base64 images and extracts text via MyAI extract_pdf action.
     *
     * @param object $file: The file object to get the text from
     * @return string: The text from the PDF document or false on failure
     */
    public function get_text_from_pdf_document($file) {
        if ($file->get_mimetype() !== 'application/pdf') {
            return false;
        }

        $pdftoppm = get_config('qbank_kia_generator', 'pathtopdftoppm');
        if (empty($pdftoppm)) {
            $pdftoppm = '/usr/bin/pdftoppm';
        }
        $pdftoppm = str_replace('\\', '/', $pdftoppm);
        $pdftoppmcheck = shell_exec(escapeshellarg($pdftoppm).' -v 2>&1');
        if ($pdftoppmcheck === null || stripos($pdftoppmcheck, 'pdftoppm version') === false) {
            throw new \moodle_exception(
                'errorprocessingpdf',
                'qbank_kia_generator',
                '',
                'PDF page rendering failed: pdftoppm is not installed or not executable at "'.$pdftoppm.'".'
            );
        }

        $tempbase = make_temp_directory('qbank_kia_generator/pdf_render_'.uniqid());
        $tempbase = str_replace('\\', '/', $tempbase);
        $pdffile = $tempbase.'/source.pdf';
        $imageprefix = $tempbase.'/page';

        file_put_contents($pdffile, $file->get_content());

        $cmd = escapeshellarg($pdftoppm).' -png '.escapeshellarg($pdffile).' '.escapeshellarg($imageprefix).' 2>&1';
        $output = [];
        $returnvar = 0;
        exec($cmd, $output, $returnvar);
        if ($returnvar !== 0) {
            $this->cleanup_temp_directory($tempbase);
            throw new \moodle_exception(
                'errorprocessingpdf',
                'qbank_kia_generator',
                '',
                'pdftoppm failed: '.implode("\n", $output)
            );
        }

        $generatedfiles = glob($imageprefix.'-*.png');
        if (empty($generatedfiles)) {
            $this->cleanup_temp_directory($tempbase);
            return false;
        }
        natsort($generatedfiles);

        $pdfcontent = '';
        $processedpages = 0;
        $errors = [];
        foreach ($generatedfiles as $generatedfile) {
            $binary = file_get_contents($generatedfile);
            if ($binary === false) {
                continue;
            }

            $imagebase64 = 'data:image/png;base64,'.base64_encode($binary);
            // OCR each rendered page independently to avoid losing content on large PDFs.
            $result = $this->extract_pdf_image_text($imagebase64);
            if (!empty($result['success'])) {
                $processedpages++;
                $pagecontent = trim((string)($result['generatedcontent'] ?? ''));
                if ($pagecontent !== '') {
                    $pdfcontent .= 'Page '.$processedpages.":\n".$pagecontent."\n\n";
                }
            } else {
                $errors[] = (string)($result['error'] ?? 'Unknown OCR error.');
            }
        }

        $this->cleanup_temp_directory($tempbase);
        $pdfcontent = trim((string)$pdfcontent);
        if ($pdfcontent === '' && !empty($errors)) {
            throw new \moodle_exception('errorprocessingpdf', 'qbank_kia_generator', '', $errors[0]);
        }
        return $pdfcontent !== '' ? $pdfcontent : false;
    }

    /**
     * Extract text from one PDF page image using MyAI.
     *
     * @param string $imagebase64
     * @return array
     */
    private function extract_pdf_image_text(string $imagebase64): array {
        global $USER;

        $action = new \aiprovider_myai\aiactions\extract_pdf(
            userid: $USER->id,
            imagebase64: $imagebase64,
            prompttext: '',
            contextid: \context_system::instance()->id,
        );
        $manager = \core\di::get(\core_ai\manager::class);
        $response = $manager->process_action($action);
        $errorcode = (int)$response->get_errorcode();
        $errormessage = trim((string)$response->get_errormessage());
        $responsemessage = $errormessage;
        if ($responsemessage !== '') {
            $decoded = json_decode($responsemessage, true);
            if (is_array($decoded)) {
                if (!empty($decoded['detail']) && is_string($decoded['detail'])) {
                    $responsemessage = $decoded['detail'];
                } else if (!empty($decoded['message']) && is_string($decoded['message'])) {
                    $responsemessage = $decoded['message'];
                }
            }
        }
        if ($responsemessage === '') {
            $responsemessage = 'Unknown OCR error.';
        }

        return [
            'success' => $response->get_success(),
            'generatedcontent' => $response->get_response_data()['generatedcontent'] ?? '',
            'errorcode' => $errorcode,
            'errormessage' => $errormessage,
            'error' => 'PDF OCR failed ('.$errorcode.'): '.$responsemessage,
        ];
    }

    /**
     * Recursively remove a temporary directory.
     *
     * @param string $directory
     * @return void
     */
    private function cleanup_temp_directory(string $directory): void {
        if (!is_dir($directory)) {
            return;
        }

        $items = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($items as $item) {
            if ($item->isDir()) {
                @rmdir($item->getPathname());
            } else {
                @unlink($item->getPathname());
            }
        }
        @rmdir($directory);
    }

    /**
     * Helper method for getting text from a Word document
     * @param object $file: The file object to get the text from
     * @return string: The text from the Word document or false on failure
     */
    public function get_text_from_word_document($file) {
        $tempfile = $file->copy_content_to_temp();

        $zip = new \ZipArchive;
        if ($zip->open($tempfile) === true) {
            $xmlContent = $zip->getFromName('word/document.xml');
            $zip->close();

            // XML-Header entfernen
            $xmlContent = preg_replace('/<\?xml.*?\?>/','', $xmlContent);

            // Versuche, die Kodierung zu erkennen und ggf. zu konvertieren
            if (!mb_check_encoding($xmlContent, 'UTF-8')) {
                // Versuche explizit UTF-8 zu erzwingen
                $xmlContent = mb_convert_encoding($xmlContent, 'UTF-8', 'UTF-8, ISO-8859-1, ISO-8859-15, Windows-1252');
            }

            // Word-spezifische Tags durch Zeilenumbrüche ersetzen
            $xmlContent = str_replace(['</w:p>', '</w:br>', '</w:tab>'], ["\n", "\n", "\t"], $xmlContent);

            // Alle anderen XML-Tags entfernen
            $xmlContent = strip_tags($xmlContent);

            // Überflüssige Leerzeichen normalisieren
            $xmlContent = preg_replace('/[ \t]+/', ' ', $xmlContent);
            $xmlContent = preg_replace('/\s*\n\s*/', "\n", $xmlContent);

            $xmlContent = trim($xmlContent);

            if (file_exists($tempfile)) {
                unlink($tempfile);
            }

            // Entferne nicht druckbare Zeichen (außer Zeilenumbrüche und Tabs)
            $xmlContent = preg_replace('/[^\PC\s]/u', '', $xmlContent);

            return $xmlContent;
        }

        if (file_exists($tempfile)) {
            unlink($tempfile);
        }
        return false;

    }

    /**
     * Helper method for getting the default question category
     * @param int $courseid: The course ID to get the default question category for
     * @return int: The default question category ID
     */
    public function get_default_question_category($courseid) {
        global $DB;

        $course_context = \context_course::instance($courseid);

        // Figure out the ID of the "top" category for this course
        $sql = "SELECT id, name FROM {question_categories} WHERE contextid = ? ORDER BY id";
        $top_category_id_for_course = $DB->get_records_sql($sql, [$course_context->id]);
        $category_id = reset($top_category_id_for_course)->id;

        // If we can find a default category, use that instead (but this doesn't always exist)
        foreach ($top_category_id_for_course as $category) {
            if (strpos($category->name, "Default") !== false || strpos($category->name, "Standard") !== false) {
                $category_id = $category->id;
                break;
            }
        }

        return $category_id;
    }

    /**
     * Helper method for getting question categories for a course
     * @param int $courseid: The course ID to get the question categories for
     * @return array: An array of question categories
     */
    public function get_question_categories($courseid, $include_top = false) {
        global $DB;

        $course_context = \context_course::instance($courseid);
        $sql = "SELECT id, name FROM {question_categories} WHERE contextid = ? ORDER BY id";
        $categories = $DB->get_records_sql($sql, [$course_context->id]);

        // Convert to a format suitable for a select element
        $category_options = [];
        foreach ($categories as $category) {
            if (!$include_top && $category->name === 'top') {
                continue; // Skip the top category if not included
            }
            $category_options[$category->id] = $category->name;
        }

        return $category_options;
    }

    /**
     * Helper method for creating a new question category
     * @param int $courseid: The course ID to create the question category for
     * @param string $name: The name of the question category
     * @return int: The ID of the newly created question category
     */
    public function create_default_question_categories($courseid) {
        global $DB;

        $course_context = \context_course::instance($courseid);

        $parent = 0; // Default parent category ID

        // Prüfe, ob bereits eine Kategorie existiert
        if (!$existing = $DB->get_record('question_categories', ['contextid' => $course_context->id, 'name' => 'top'])) {
            $category = new stdClass();
            $category->contextid = $course_context->id;
            $category->name = 'top';
            $category->info = '';
            $category->infoformat = FORMAT_HTML; // Default format
            $category->stamp = make_unique_id_code();
            $category->parent = 0; // Top-level category
            $category->sortorder = 0; // Default sort order

            // Insert the category into the database
            if (!$category->id = $DB->insert_record('question_categories', $category)) {
                throw new \moodle_exception('errorcreatingcategory', 'qbank_kia_generator', '', $courseid);
            }
            $parent = $category->id; // Use the newly created category ID as parent
        }
        else {
            $parent = $existing->id; // Use existing category ID as parent
        }

        // check if subcategories (name != top) exist, if not create one
        $sql = "SELECT id FROM {question_categories} WHERE contextid = ? AND name != 'top'";
        if (!$subcategories = $DB->get_records_sql($sql, [$course_context->id])) {
            $subcategory = new stdClass();
            $subcategory->contextid = $course_context->id;
            $subcategory->name = 'AI Generated Questions';
            $subcategory->info = '';
            $subcategory->infoformat = FORMAT_HTML; // Default format
            $subcategory->stamp = make_unique_id_code();
            $subcategory->parent = $parent; // Set parent to the top category
            $subcategory->sortorder = 999; // Default sort order

            if (!$subcategory->id = $DB->insert_record('question_categories', $subcategory)) {
                throw new \moodle_exception('errorcreatingcategory', 'qbank_kia_generator', '', $courseid);
            }
        }
    }

    /**
     * Helper method for getting presets
     * @return array: An array of presets
     */
    public function get_presets() {
        $presets = [];
        for ($i = 1; $i <= 10; $i++) {
            if ($presetname = get_config('qbank_kia_generator', 'presetname' . $i)) {
                $presets['preset'.$i] = $presetname;
            }
        }
        return $presets;
    }

    /**
     * Helper method for importing questions from a string
     * @param string $questionstring: The question string to import
     * @param int $categoryid: The category ID to import the questions into
     * @param object $course: The course object to import the questions into
     * @param string $format: The format of the question string ('GIFT' or 'XML')
     * @throws moodle_exception if the format is invalid or import fails
     * @return true on success
     */
    public function import_questions_from_string($questionstring, $categoryid, $course, $format = 'GIFT') {
        global $DB, $CFG;
        $format = strtolower($format);
        $validformats = ['gift', 'xml'];
        if (!in_array($format, $validformats)) {
            throw new \moodle_exception('invalidformat', 'qbank_kia_generator', '', $format);
        }
        require_once($CFG->dirroot.'/question/format.php');
        require_once($CFG->dirroot.'/question/format/'.$format.'/format.php');
        //$context = context_course::instance($course->id);
        $category = $DB->get_record('question_categories', ['id' => $categoryid], '*', MUST_EXIST);

        $categorycontext = \context::instance_by_id($category->contextid);
        $category->context = $categorycontext;
        $contexts = new \core_question\local\bank\question_edit_contexts($categorycontext);

        $tempdir = make_request_directory();
        $tempfile = $tempdir . '/import_'.$format.'_'.uniqid('', true).'.txt';
        file_put_contents($tempfile, $questionstring);
        
        $qformatclassname = 'qformat_' . $format;
        $qformat = new $qformatclassname();
        
        // Load data into class.
        // look here: moodle/question/bank/importquestions/import.php
        $qformat->setCategory($category);
        $qformat->setContexts($contexts->having_one_edit_tab_cap('import'));
        $qformat->setCourse($course);
        $qformat->setFilename($tempfile);
        $qformat->setRealfilename('import_'.$format.'.txt');
        $qformat->setMatchgrades('error');
        $qformat->setCatfromfile(false);
        $qformat->setContextfromfile(false);
        $qformat->setStoponerror(1);

        // Do anything before that we need to.
        if (!$qformat->importpreprocess()) {
            throw new \moodle_exception('cannotimport');
        }

        // Process the uploaded file.
        if (!$qformat->importprocess()) {
            throw new \moodle_exception('cannotimport');
        }

        // istead of overwriting the function importpostprocess() we write our code here
        // so we don't have to create a new class for each format
        // This is where the questions are actually imported.
        foreach ($qformat->questionids as $questionid) {
            $question_version = $DB->get_record('question_versions', ['questionid' => $questionid], '*', MUST_EXIST);
            $question_version->status = 'draft'; // Set the status to draft
            $DB->update_record('question_versions', $question_version);
        }

        // In case anything needs to be done after.
        if (!$qformat->importpostprocess()) {
            throw new \moodle_exception('cannotimport');
        }

        // Clean up the temporary file.
        if (file_exists($tempfile)) {
            unlink($tempfile);
        }

        // Log the import into this category.
        $eventparams = [
                'contextid' => $qformat->category->contextid,
                'other' => ['format' => $format, 'categoryid' => $qformat->category->id],
        ];
        $event = \core\event\questions_imported::create($eventparams);
        $event->trigger();

        return true;
    }

}