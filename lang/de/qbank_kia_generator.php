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
 * Plugin strings are defined here.
 *
 * @package     qbank_kia_generator
 * @category    string
 * @author      Jan Rieger, ISy, TH Lübeck
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['questioncategory'] = 'Fragen-Kategorie';
$string['defaultmodel'] = 'Default Modell';
$string['defaultmodellabel'] = 'Dieses KI Modell wird per Default verwendet. Das kann individuell im Kurs angepasst werden.';
$string['defaultmodelnotavailable'] = 'Das ausgewählte KI Modell ist nicht verfügbar. Bitte wähle ein anderes Modell aus der Liste der verfügbaren Modelle.';
$string['editpreset'] = 'Preset bearbeiten bevor Anfrage gesendet wird';
$string['emptypythonpathwarning'] = 'Warnung: Der Python-Pfad ist nicht konfiguriert. Bitte setze ihn in <a href="search.php?query=pathtopython">der Site-Administration</a>.<br>Ohne diesen Pfad kann der KIA KI Fragen Generator keine Inhalte aus PDF verarbeiten.<br>Mögliche Python-Pfade sind:<br>Linux: /usr/bin/python3<br>Windows: C:\laragon\bin\python\python-3.13\python.exe';
$string['errorprocessingpdf'] = 'Fehler beim Verarbeiten der PDF-Datei. Möglicherweise ist das Python-Paket "PyMuPDF" nicht installiert. Bitte installiere es mit dem Befehl "pip install PyMuPDF".';
$string['kia_generator:generatequestions'] = 'Fragen generieren';

$string['mistral_api_key'] = 'Mistral API Key';
$string['mistral_api_key_desc'] = 'Mistral wird benötigt, um die Inhalte aus PDF-Dateien zu extrahieren. Logge dich auf <a href="https://https://mistral.ai/">mistral.ai</a> ein und erstelle einen API Key unter "Try the API".';
$string['pluginname'] = 'KIA KI Fragen Generator';
$string['preset'] = 'Preset';
$string['presetname'] = 'Name des Presets';
$string['presetnamedesc'] = 'Name des Presets, das in den Kursen angezeigt wird.';
$string['presetnamedefault1'] = 'Multiple-Choice (GIFT)';
$string['presetnamedefault2'] = 'True/False (GIFT)';
$string['presetnamedefault3'] = 'Shortanswer (GIFT)';
$string['presetnamedefault4'] = 'Matrix (XML)';
$string['presetnamedefault5'] = 'Cloze (XML)';
$string['presetnamedefault6'] = 'Ddwtos (XML)';
$string['presetnamedefault7'] = '';
$string['presetnamedefault8'] = '';
$string['presetnamedefault9'] = '';
$string['presetnamedefault10'] = '';
$string['presetformat'] = 'Preset Format';
$string['presetformatdesc'] = 'Format, in dem die Fragen generiert werden sollen. Dies kann z.B. GIFT oder XML sein. GIFT ist das Standardformat für Moodle-Fragen und ermöglicht die einfache Integration in die Moodle-Fragesammlung.';
$string['presetformatdefault1'] = 'GIFT';
$string['presetformatdefault2'] = 'GIFT';
$string['presetformatdefault3'] = 'GIFT';
$string['presetformatdefault4'] = 'XML';
$string['presetformatdefault5'] = 'XML';
$string['presetformatdefault6'] = 'XML';
$string['presetformatdefault7'] = '';
$string['presetformatdefault8'] = '';
$string['presetformatdefault9'] = '';
$string['presetformatdefault10'] = '';
$string['presetprimer'] = 'Preset primer';
$string['presetprimerdesc'] = 'Erste Information, die an die KI gesendet wird, um den Kontext für die Generierung der Fragen zu setzen. Dies kann z.B. eine kurze Beschreibung des Themas sein, zu dem Fragen generiert werden sollen.';
$string['presetprimerdefault1'] = 'You are a helpful teacher\'s assistant that creates multiple choice questions based on the topics given by the user.';
$string['presetprimerdefault2'] = 'You are a helpful teacher\'s assistant that creates truefalse questions based on the topics given by the user.';
$string['presetprimerdefault3'] = 'You are a helpful teacher\'s assistant that creates shortanswer questions based on the topics given by the user.';
$string['presetprimerdefault4'] = 'Erstelle Aussagen zu einem Text, den ich extra angebe, die entweder wahr oder falsch sind.';
$string['presetprimerdefault5'] = 'Erstelle eine Aussage zu einem Text, den ich extra angebe. Wir wollen eine Dropdown-Auswahlmöglichkeit erzeugen.';
$string['presetprimerdefault6'] = 'Erstelle einen Text zur Erklärung eines Inhaltes, den ich extra angebe.';
$string['presetprimerdefault7'] = '';
$string['presetprimerdefault8'] = '';
$string['presetprimerdefault9'] = '';
$string['presetprimerdefault10'] = '';
$string['presetinstructions'] = 'Preset instructions';
$string['presetinstructionsdesc'] = 'Anweisungen, die an die KI gesendet werden, um den Fragetyp und die Struktur der Fragen zu definieren. Dies kann z.B. Anweisungen sein, wie die Fragen formuliert werden sollen oder welche Informationen sie enthalten sollen.';
$string['presetinstructionsdefault1'] = 'Please write a multiple choice question in English language in GIFT format on a topic I will specify to you separately GIFT format use equal sign for right answer and tilde sign for wrong answer at the beginning of answers. For example: \'::Question title:: Question text { =right answer#feedback ~wrong answer#feedback ~wrong answer#feedback ~wrong answer#feedback }\' Please have a blank line between questions. Do not include the question title in the beginning of the question text.';
$string['presetinstructionsdefault2'] = 'Please write a true/false question in GIFT format on a topic I will specify to you separately. In GIFT format, use the character T for a true answer and the character F for a false answer inside the curly braces. For example: \'::Question title::Question text{T}\' or \'::Question title::Question text{F}\'. Please have a blank line between questions. Do not include the question title in the beginning of the question text. The following is an example of how your output should look like.';
$string['presetinstructionsdefault3'] = 'Please write a short answer question in GIFT format on a topic I will specify to you separately. In GIFT format, use the equal sign inside the curly braces to specify the correct answer(s). You can provide multiple correct answers by listing them with separate equal signs inside the curly braces. Answers are case-insensitive by default. For example: \'::Question title::Question text{=correct answer =another correct answer}\'. Please have a blank line between questions. Do not include the question title in the beginning of the question text. Please choose answers that are short and simple, to minimize the chance of errors while the user is entering the correct answer. The following is an example of how your output should look like.';
$string['presetinstructionsdefault4'] = 'Schreibe jede Aussage an die entsprechende Stelle <shorttext>Aussage 1,2,3 oder 4</shorttext> und ersetze das Wort Aussage 1,2,3 oder 4. Adaptiere die auf jede Aussage folgende Zeilen <weight-of-col>0</weight-of-col> und schreibe dort in die erste Zeile eine 1 und in die darauffolgende Spalte eine 0, bei einer wahren Aussage. Bei einer falschen Aussage vertauscht Du die 1 und 0. Für die richtige Antwort jeweils unter Feedback ein. Nutze folgendes Template und fülle dies aus:';
$string['presetinstructionsdefault5'] = 'Entferne dazu den wichtigen Teil der Aussage und schreibe den unwichtigen Teil an die Stelle STATEMENT. Ersetze in dem Template die Stellen FILL 1,2,3 mit zwei falschen Vervollständigungen der Aussage und einmal mit der richigen Aussage. Vor jede falsche Vervollständigung kommt eine Tilde "~" und vor die richtige Vervollständigung eine Tilde und ein Gleichheitszeichen "~=" Die Ersetzung soll hinter dem Wort "MULTICHOICE:" beginnen. Schreibe jeweils direkt hinter eine Vervollständigung an die Stelle FEEDBACK 1,2,3 in dem Template eine Aussage, warum die Ergänzung richtig oder falsch ist. Mache zwischen Vervollständigung und Feedback eine Raute "#".';
$string['presetinstructionsdefault6'] = 'Lasse dabei Schlüsselwoerter aus und ersetze diese durch aufsteigende Zahlen in doppelten eckigen Klammern "[[1]]". Schreibe diesen Text in folgendes Template an die Stelle TEXT. Schreibe die Schluesselwoerter in der richtigen Reihenfolge ihres Auftretens jeweils in ein dragbox xml-statement. Die Zahl der Group soll immer 1 sein. Füge am Ende noch drei weitere Schlüsselworter, welche nicht exakt in den Text passen, in gleicher Weise an. Keine Zahl darf doppelt auftreten.';
$string['presetinstructionsdefault7'] = '';
$string['presetinstructionsdefault8'] = '';
$string['presetinstructionsdefault9'] = '';
$string['presetinstructionsdefault10'] = '';
$string['presetexample'] = 'Preset example';
$string['presetexampledesc'] = 'Beispiel für eine Frage, die an die KI gesendet wird, um den Fragetyp und die Struktur der Fragen zu definieren. Dies kann z.B. ein Beispiel für eine Multiple-Choice-Frage im GIFT-Format sein.';
$string['presetexampledefault1'] = '::Indexicality and iconicity 1:: Imagine that you are standing on a lake shore. A wind rises, creating waves on the lake surface. According to C.S. Peirce, in what way the waves signify the wind? { =The relationship is both indexical and iconical.#Correct. There is a connection of spatio-temporal contiguity between the wind and the waves, which is a determining feature of indexicality. There is also a formal resemblance between wind direction and the direction of the waves, which is a determining feature of iconicity.  ~The relationship is indexical.#Almost correct. There is a connection of spatio-temporal contiguity between the wind and the waves, which, according to Peirce, is a determining feature of indexicality. However, there is additional signification taking place as well. ~There is no sign phenomena betweem the wind and the waves, they are two separate signs.#Incorrect. The movement of the waves is determined by the wind. ~The relationship between the wind and the waves is symbolic.#Incorrect. The movement of the waves is not arbitrary, which would be the case if the relationship was symbolic. }';
$string['presetexampledefault2'] = '::Wahre Aussage über Grant::Grant wurde in einem Grab in New York City bestattet.{T}';
$string['presetexampledefault3'] = '::Solar System 1::What is the name of the planet closest to the Sun?{=Mercury}

::Solar System 2::Name a gas giant in our solar system.{=Jupiter =Saturn =Uranus =Neptune}';
$string['presetexampledefault4'] = '<?xml version="1.0" encoding="UTF-8"?>
    <quiz>
      <question type="matrix">
        <name>
          <text>Question name</text>
        </name>
        <questiontext format="html">
          <text><![CDATA[<p dir="ltr" style="text-align: left;">Taskdescription</p>]]></text>
        </questiontext>
        <generalfeedback format="html">
          <text></text>
        </generalfeedback>
        <defaultgrade>4</defaultgrade>
       <penalty>0</penalty>
        <hidden>0</hidden>
        <idnumber></idnumber>
        <use_dnd_ui>0</use_dnd_ui>
        <row>
            <shorttext>Aussage 1</shorttext>
            <feedback format="html">
          <text></text>
            </feedback>
        </row>
        <weights-of-row>
        <weight-of-col>0</weight-of-col>
        <weight-of-col>1</weight-of-col>
        </weights-of-row>
        <row>
            <shorttext>Aussage 2</shorttext>
            <feedback format="html">
          <text></text>
            </feedback>
        </row>
        <weights-of-row>
        <weight-of-col>1</weight-of-col>
        <weight-of-col>0</weight-of-col>
        </weights-of-row>
        <row>
            <shorttext>Aussage 3</shorttext>
            <feedback format="html">
          <text></text>
            </feedback>
        </row>
        <weights-of-row>
        <weight-of-col>1</weight-of-col>
        <weight-of-col>0</weight-of-col>
        </weights-of-row>
        <row>
            <shorttext>Aussage 4</shorttext>
            <feedback format="html">
          <text></text>
            </feedback>
        </row>
        <weights-of-row>
        <weight-of-col>0</weight-of-col>
        <weight-of-col>1</weight-of-col>
        </weights-of-row>
        <col>
            <shorttext>Wahr</shorttext>
            <description format="html">
          <text></text>
            </description>
        </col>
        <col>
            <shorttext>Falsch</shorttext>
            <description format="html">
          <text></text>
            </description>
        </col>
        <grademethod>all</grademethod>
        <shuffleanswers>1</shuffleanswers>
        <multiple>0</multiple>
        <renderer>matrix</renderer>
      </question>
    </quiz>';
$string['presetexampledefault5'] = '<?xml version="1.0" encoding="UTF-8"?>
<quiz>
  <question type="cloze">
    <name>
      <text>TITLE</text>
    </name>
    <questiontext format="html">
      <text><!\[CDATA\[<p dir="ltr" style="text-align: left;">STATEMENT {1:MULTICHOICE: FILL 1#FEEDBACK 1\~FILL 2#FEEDBACK 2\~=FILL 3#FEEDBACK 3}<br /></p><p></p>\]\]></text>
    </questiontext>
    <generalfeedback format="html">
      <text></text>
    </generalfeedback>
    <penalty>0.3333333</penalty>
    <hidden>0</hidden>
    <idnumber></idnumber>
  </question>
</quiz>';
$string['presetexampledefault6'] = '<?xml version="1.0" encoding="UTF-8"?>
<quiz>
  <question type="ddwtos">
    <name>
      <text>TITLE</text>
    </name>
    <questiontext format="html">
      <text>TEXT</text>
    </questiontext>
    <generalfeedback format="html">
      <text></text> 
    </generalfeedback> 
    <defaultgrade>3</defaultgrade> 
    <penalty>1</penalty> 
    <hidden>0</hidden> 
    <idnumber></idnumber> 
    <shuffleanswers>1</shuffleanswers> 
    <correctfeedback format="html"> 
      <text>Die Antwort ist richtig.</text> 
    </correctfeedback> 
    <partiallycorrectfeedback format="html"> 
      <text>Die Antwort ist teilweise richtig.</text> 
    </partiallycorrectfeedback> 
    <incorrectfeedback format="html"> 
      <text>Die Antwort ist falsch.</text> 
    </incorrectfeedback> 
    <shownumcorrect/> 
    <dragbox> 
      <text>FILLTEXT</text> 
      <group>1</group> 
    </dragbox> 
  </question> 
</quiz>';
$string['presetexampledefault7'] = '';
$string['presetexampledefault8'] = '';
$string['presetexampledefault9'] = '';
$string['presetexampledefault10'] = '';
$string['presets']  = 'Presets';
$string['presetsdesc']  = 'Hier können bis zu 10 Presets vorkonfiguriert werden und sind dann in den Kursen verfügbar.';
$string['presethelp_help'] = 'Die Presets sind vorkonfigurierte Einstellungen, mit denen unter Anderem der Fragetyp bestimmt wird. Jedes Preset enthält Anweisungen, Beispiele und Formatierungen, die an die KI gesendet werden, um die gewünschten Fragen zu erstellen.';

$string['settings'] = 'KIA KI Fragen Generator Settings';
$string['title'] = 'KIA KI Fragen generieren';

$string['privacy:metadata'] = 'Der KIA KI Fragen Generator speichert keine persönlichen Nutzerdaten noch werden solche an Dritte gesendet. Allerdings werden werden alle Daten, die von Trainer:innen übermittelt werden um Fragen zu generieren, komplett an externe Systeme gesendet. Dort unterliegen sie den Datenschutzbestimmungen der entsprechenden Anbieter, wie z.B. OpenAI (https://openai.com/api/policies/privacy/). Der so generierte Fragentext kann dann auf diesem System gespeichert werden.';

$string['model'] = 'Modell';
$string['modellabel'] = 'Modell, das zum generieren der Fragen verwendet werden soll';

$string['sourcetext'] = 'Inhalt';
$string['qtype'] = 'Fragetyp';
$string['qtype_help'] = 'Die Fragetypen sind nach ihrer Komplexität geordnet. Komplexere Fragetypen reduziert die Fähigkeit der GPT\'s Anweisungen zu folgen oder sinnvolle Fragen zu gerieren.';
$string['qtype_prompt_multichoice'] = 'Multiple-Choice';
$string['qtype_prompt_multichoice_descr'] = 'Beispiel einer Frage vom Typ Multiple-Choice im JSON Format.';
$string['qtype_prompt_multichoice_default'] = '[{"question": "On what date did construction start?", "answers": {"A": "1882", "B": "1893", "C": "1926", "D": "1918"}, "correct": "A"}, {"question": "Who was the original architect of the basilica?", "answers": {"A": "Antoni Gaudi", "B": "Francsico de Goya", "C": "Francisco de Paula del Villar", "D": "Louis Sullivan"}, "correct": "C"}, {"question": "How much of the basilica was finished when Gaudi died?", "answers": {"A": "Over a third", "B": "Nearly all of it", "C": "Around half", "D": "Less than a quarter"}, "correct": "D"}]';
$string['qtype_prompt_shortanswer'] = 'Kurzantwort';
$string['qtype_prompt_shortanswer_descr'] = 'Beispiel einer Frage vom Typ Kurzantwort im JSON Format.';
$string['qtype_prompt_shortanswer_default'] = '[{"question": "On what date did construction start?", "answers": {"A": "19 March 1882"}}, {"question": "Who was the original architect of the basilica?", "answers": {"A": "Francisco de Paula del Villar"}}, {"question": "How much of the project was completed when Gaudi died?", "answers": {"A": "Less than a quarter"}}]';
$string['qtype_prompt_truefalse'] = 'Wahr/Falsch';
$string['qtype_prompt_truefalse_descr'] = 'Beispiel einer Frage vom Typ Wahr/Falsch im JSON Format.';
$string['qtype_prompt_truefalse_default'] = '[{"question": "Construction started on 19 March 1882", "answers": {"A": "True"}}, {"question": "The original architect was Antoni Gaudi", "answers": {"A": "False"}}, {"question": "Over half of the basilica was finished when Gaudi died.", "answers": {"A": "False"}}]';
$string['modselection'] = 'Wähle Aktivitäten als Inhalt';
$string['numquestions'] = 'Wie viele Fragen sollen generiert werden?';
$string['numquestions_help'] = 'Die Anzahl der generierten Fragen kann von der gewünschten Anzahl abweichen wenn der Inhaltstext größer oder der Fragetyp komplexer wird.';
$string['notanumber'] = 'Muss einen Wert zwischen 1 und 10 betragen';
$string['sourcetextcharlength'] = 'Anzahl der Zeichen muss zwischen 100 und 64000 liegen';
$string['sourcetextorcheckboxes'] = 'Bitte entweder den Inhaltstext eingeben oder eine oder mehrere Aktivitäten auswählen, die als Inhalt verwendet werden sollen. Inhaltstexte sollten zwischen 100 und 64000 Zeichen lang sein.';

$string['editquestions'] = 'Fragen bearbeiten';
$string['numbermismatch'] = "Die Anzahl der generierten Fragen entspricht nicht der Anzahl aus der Anfrage. Das kann verschiedene Gründe haben (zu viele Fragen gewünscht, zu langer Text, zu komplexer Fragetyp). Wenn das weiterhin passiert, könnte ein anderes Modell besser geeignet sein.";
$string['markascorrect'] = "Richtige Antwort";
$string['addtoqbank'] = "Zur Fragesammlung hinzufügen";
$string['cancel'] = "Abbrechen";

$string['error_capability'] = 'Keine Berechtigung zum generieren von Fragen in diesem Kurs.';
$string['error_gpt_format'] = "GPT konnte keine Fragen im richtigen Format liefern. Es gibt leider keine andere Möglichkeit, als erneut zu versuchen, die Fragen zu generieren. Dazu reicht es, diese Seite neu zu laden (strg + r).";
$string['herestheresponse'] = "\n\nGPT-Antwort:\n\"";

$string['confirmdelete_question'] = 'Diese Frage löschen?';
$string['wait'] = 'Bitte warten...';
$string['pathtopdftoppm'] = 'Pfad zu pdftoppm';
$string['pathtopdftoppm_desc'] = 'Absoluter Pfad zur pdftoppm-Datei, die fuer das Rendern von PDF-Seiten in Bilder verwendet wird (z. B. /usr/bin/pdftoppm).';
