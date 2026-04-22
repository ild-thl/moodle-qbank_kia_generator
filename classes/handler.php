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

/**
 * Class for handling question generation
 *
 * @package     qbank_kia_generator
 * @author      Jan Rieger, ISy, TH Lübeck
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

class handler {

    /** @var array */
    private array $sourcetext;
    /** @var int */
    private int $contextid;

    function __construct(array $sourcetext, int $contextid) {
        $this->sourcetext = $sourcetext;
        $this->contextid = $contextid;
    }

    /**
     * Fetch a GPT generation from a prompt
     * 
     * @param int number_of_questions (optional): The number of questions to try to generate
     * @param string format (optional): The format in which the questions should be generated (e.g. GIFT, XML)
     * @param string primer (optional): The primer to use for the question generation
     * @param string instructions (optional): The instructions to use for the question generation
     * @param string example (optional): The example to use for the question generation
     * @return string: The generated questions in the requested format
     */
    public function fetch_response($number_of_questions=3, $format = null, $primer = null, $instructions = null, $example = null) {
        if ($primer != null && $instructions != null && $example != null) {
            $presetmessages = $this->build_messages_from_presets($format, $primer, $instructions, $example);
            
            foreach ($this->sourcetext as $text) {
                // Source chunks are appended as system context so the model sees them as hard constraints.
                array_push($presetmessages, ["role" => "system", "content" => $text]);
            }
            array_push($presetmessages, ["role" => "user", "content" => "Now generate in total ".$number_of_questions." questions for me."]);
        }
        else {
            throw new \moodle_exception("preset_error");
        }
        $responsecontent = $this->make_api_request($presetmessages);
        
        if ($format == 'GIFT') {
            return $this->clean_gift($responsecontent);
        } elseif ($format == 'XML') {
            return $this->clean_xml($responsecontent);
        }
        throw new \moodle_exception("request_failed", "qbank_kia_generator", "", 'Unsupported format: '.$format);
    }

    /**
     * This function is used do build the messages that are sent to GPT.
     * It includes the chosen presets for primer, instructions and example.
     * @param int number_of_questions: The number of questions to generate
     * @param string format: The format in which the questions should be generated (e.g. GIFT, XML)
     * @param string primer: The primer to use for the question generation
     * @param string instructions: The instructions to use for the question generation
     * @param string example: The example to use for the question generation
     * @return Array: The array of messages to send to GPT
     */
    public function build_messages_from_presets($format, $primer, $instructions, $example) {
        $languagecode = current_language();
        $localized = get_string('thislanguage', 'langconfig', $languagecode);

        $messages = [
            ["role" => "system", "content" => $primer],
            ["role" => "system", /*"name" => "example_user",*/ "content" => "Generate questions in $localized language."],
            ["role" => "system", "content" => "Generate questions in valid $format format. Do not return normal text, just $format."],
            ["role" => "system", /*"name" => "example_user",*/ "content" => $instructions],
            ["role" => "system", /*"name" => "example_assistant",*/ "content" => $example],
            ["role" => "system", "content" => "Create questions based on the following text: "]
        ];
        return $messages;
    }

    private function clean_xml($xml) {
        // Remove any charactors before the XML declaration
        $pos = strpos($xml, '<?xml');
        if ($pos !== false) {
            $xml = substr($xml, $pos);
        }
        // Remove any charactors after "</quiz>"
        $pos = strrpos($xml, '</quiz>');
        if ($pos !== false) {
            $xml = substr($xml, 0, $pos + 7);
        }
        else {
            throw new \moodle_exception("gpt_format_error", "qbank_kia_generator", "", 'error: '.$xml);
        }
        
        libxml_use_internal_errors(true); // Fehler nicht direkt ausgeben
        $dom = new \DOMDocument();
        // Lade XML – versuche es zu reparieren
        $success = $dom->loadXML($xml, LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_NONET);
        
        if ($success) {
            $dom->formatOutput = true;
            return $dom->saveXML();
        } else {
            // If the XML format is not valid, run it through one more prompt
            $xml = $this->reprompt_xml($xml);
            // Lade XML – versuche es zu reparieren
            $success = $dom->loadXML($xml, LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_NONET);
            
            if ($success) {
                $dom->formatOutput = true;
                return $dom->saveXML();
            } else {
                throw new \moodle_exception("gpt_format_error", "qbank_kia_generator", "", 'error: '.$xml);
            }

        }
    }

    private function clean_gift($gift) {
        // validate the GIFT format
        if (strpos($gift, '::') === false or strpos($gift, '{') === false or strpos($gift, '}') === false) {
            $gift = $this->reprompt_gift($gift);
            if (strpos($gift, '::') === false or strpos($gift, '{') === false or strpos($gift, '}') === false) {
                throw new \moodle_exception("gift_format_error", "qbank_kia_generator", "", 'error: '.$gift);
            }
        }
        // Remove any charactors before first occurrence of '::'
        // This is to remove any leading text that is not part of the GIFT format
        $pos = strpos($gift, '::');
        if ($pos !== false) {
            $gift = substr($gift, $pos);
        }
        // Remove any charactors after the last question
        $pos = strrpos($gift, '}');
        if ($pos !== false) {
            $gift = substr($gift, 0, $pos + 1);
        }
        // convert the GIFT string to UTF-8 if it is not already
        $gift = mb_convert_encoding($gift, 'UTF-8', 'UTF-8');
        // force Unix breaks
        $gift = str_replace(["\r\n", "\r"], "\n", $gift);
        // Remove unnecessary control characters and invisible characters
        //$gift = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $gift); 
        $gift = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F\xA0]/u', '', $gift);
        
        return $gift;
    }

    /**
     * If GPT fails to provide valid XML, we run it through one more prompt to try to convert the data into something we can use
     * @param string responsetext: The text to convert into XML
     * @return string: The XML string
     */
    private function reprompt_xml($xml) {
        $messages = [
            ["role" => "system", "content" => "Please convert any given input (including plain text) into valid XML. The input does not need to be XML format. Do not return anything else except properly formatted XML based on the input."],
            ["role" => "user", "content" => $xml]
        ];

        return $this->make_api_request($messages);
    }

    /**
     * If GPT fails to provide valid GIFT, we run it through one more prompt to try to convert the data into something we can use
     * @param string responsetext: The text to convert into GIFT format
     * @return string: The GIFT string
     */
    private function reprompt_gift($gift) {
        $messages = [
            ["role" => "system", "content" => "Please convert any given input (including plain text) into valid GIFT format. The input does not need to be GIFT format. Do not return anything else except properly formatted GIFT based on the input."],
            ["role" => "user", "content" => $gift]
        ];

        return $this->make_api_request($messages);
    }

    /**
     * Helper method for making API requests
     * @param Array messages: The list of messages to send to OpenAI
     * @return Object: The parsed JSON response
     */
    private function make_api_request($messages) {
        global $USER;

        $prompt = $this->build_prompt_from_messages($messages);
        $action = new \aiprovider_myai\aiactions\generate_question(
            contextid: $this->contextid,
            userid: $USER->id,
            prompttext: $prompt,
        );
        $manager = \core\di::get(\core_ai\manager::class);
        $response = $manager->process_action($action);
        if (!$response->get_success()) {
            throw new \moodle_exception("openai_error", "qbank_kia_generator", "", $response->get_errormessage());
        }
        $responsecontent = (string)($response->get_response_data()['generatedcontent'] ?? '');
        if (trim($responsecontent) === '') {
            throw new \moodle_exception("request_failed", "qbank_kia_generator", "", 'Empty AI response');
        }
        return $responsecontent;
    }

    /**
     * Convert chat-style messages to a single prompt.
     *
     * @param array $messages
     * @return string
     */
    private function build_prompt_from_messages(array $messages): string {
        $promptparts = [];
        foreach ($messages as $message) {
            $role = strtoupper((string)($message['role'] ?? 'user'));
            $content = trim((string)($message['content'] ?? ''));
            if ($content === '') {
                continue;
            }
            // myai generate_question currently accepts one prompt string; preserve role boundaries explicitly.
            $promptparts[] = $role.":\n".$content;
        }
        return implode("\n\n", $promptparts);
    }
    
}
