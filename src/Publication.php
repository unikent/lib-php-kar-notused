<?php
/**
 * KAR API for is-dev applications.
 *
 * @copyright  2014 Skylar Kelty <S.Kelty@kent.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace unikent\KAR;

/**
 * A publiction, as KAR sees them.
 */
class Publication
{
    /**
     * API.
     * 
     * @internal
     * @param object
     */
    private $_api;

    /**
     * Data.
     * 
     * @internal
     * @param array
     */
    private $_data;

    /**
     * People.
     * 
     * @internal
     * @param array
     */
    private $_people;

    /**
     * Divisions.
     * 
     * @internal
     * @param array
     */
    private $_divisions;

    /**
     * Constructor.
     *
     * @internal
     * @param object $api The API we are related to.
     */
    private function __construct($api) {
        $this->_api = $api;
        $this->_data = array();
        $this->_people = null;
        $this->_divisions = null;
    }

    /**
     * Create a publication from a JSON object.
     *
     * @internal
     * @param object $api The API we are related to.
     * @param object $data The data.
     */
    public static function create_from_api($api, $data) {
        $obj = new static($api);

        foreach ((array)$data as $k => $v) {
            if (in_array($k, array('authors', 'editors', 'reviewers', 'funders'))) {
                continue;
            }

            $obj->_data[$k] = $v;
        }

        return $obj;
    }

    /**
     * Get all people associated with this publication.
     */
    private function build_people_cache() {
        if ($this->_people !== null) {
            return;
        }

        $eprintid = $this->get_id();
        if (empty($eprintid)) {
            return;
        }

        $this->_people = array(
            'creator' => array(),
            'editor' => array(),
            'reviewer' => array(),
            'funder' => array()
        );

        // Grab people from the API.
        $people = $this->_api->get_people($eprintid);
        foreach ($people as $person) {
            $type = $person->get_type();
            $this->_people[$type][] = $person;
        }
    }

    /**
     * Get all authors.
     */
    public function get_authors() {
        $this->build_people_cache();
        return $this->_people['creator'];
    }

    /**
     * Get all editors.
     */
    public function get_editors() {
        $this->build_people_cache();
        return $this->_people['editor'];
    }

    /**
     * Get all reviewers.
     */
    public function get_reviewers() {
        $this->build_people_cache();
        return $this->_people['reviewer'];
    }

    /**
     * Get all funders.
     */
    public function get_funders() {
        $this->build_people_cache();
        return $this->_people['funder'];
    }

    /**
     * Returns the publication ID.
     */
    public function get_id() {
        return $this->_data['eprintid'];
    }

    /**
     * Returns the publication title.
     */
    public function get_title() {
        return $this->_data['title'];
    }

    /**
     * Returns the publication subtitle.
     */
    public function get_subtitle() {
        return $this->_data['subtitle'];
    }

    /**
     * Returns the publication abstract.
     */
    public function get_abstract() {
        return $this->_data['abstract'];
    }

    /**
     * Returns the publication.
     */
    public function get_publication() {
        return $this->_data['publication'];
    }

    /**
     * Returns the volume.
     */
    public function get_volume() {
        return $this->_data['volume'];
    }

    /**
     * Returns the number.
     */
    public function get_number() {
        return $this->_data['number'];
    }

    /**
     * Returns the page range.
     */
    public function get_page_range() {
        return $this->_data['pagerange'];
    }

    /**
     * Returns the publication publisher.
     */
    public function get_publisher() {
        return $this->_data['publisher'];
    }

    /**
     * Returns the publication issn.
     */
    public function get_isbn() {
        return $this->_data['isbn'];
    }

    /**
     * Returns the publication issn.
     */
    public function get_issn() {
        return $this->_data['issn'];
    }

    /**
     * Returns the publication year.
     */
    public function get_year() {
        return $this->_data['date_year'];
    }

    /**
     * Returns the publication type.
     */
    public function get_type() {
        return $this->_data['type'];
    }

    /**
     * Returns the publication location.
     */
    public function get_location() {
        return $this->_data['location'];
    }

    /**
     * Returns the id number.
     */
    public function get_id_number() {
        return $this->_data['id_number'];
    }

    /**
     * Returns the book title.
     */
    public function get_book_title() {
        return $this->_data['book_title'];
    }

    /**
     * Returns the series.
     */
    public function get_series() {
        return $this->_data['series'];
    }

    /**
     * Returns the place of publication.
     */
    public function get_place_of_pub() {
        return $this->_data['place_of_pub'];
    }

    /**
     * Returns the pages.
     */
    public function get_pages() {
        return $this->_data['pages'];
    }

    /**
     * Returns the event title.
     */
    public function get_event_title() {
        return $this->_data['event_title'];
    }

    /**
     * Returns the event dates.
     */
    public function get_event_dates() {
        return $this->_data['event_dates'];
    }

    /**
     * Returns the event location.
     */
    public function get_event_location() {
        return $this->_data['event_location'];
    }

    /**
     * Returns the monograph type.
     */
    public function get_monograph_type() {
        return $this->_data['monograph_type'];
    }

    /**
     * Returns the output media.
     */
    public function get_output_media() {
        return $this->_data['output_media'];
    }

    /**
     * Returns the size.
     */
    public function get_size() {
        return $this->_data['size'];
    }

    /**
     * Returns the performance type.
     */
    public function get_performance_type() {
        return $this->_data['performance_type'];
    }

    /**
     * Returns the num pieces.
     */
    public function get_num_pieces() {
        return $this->_data['num_pieces'];
    }

    /**
     * Returns the manufacturer.
     */
    public function get_manufacturer() {
        return $this->_data['manufacturer'];
    }

    /**
     * Returns the thesis type.
     */
    public function get_thesis_type() {
        return $this->_data['thesis_type'];
    }

    /**
     * Is it published?
     */
    public function get_ispublished() {
        return $this->_data['ispublished'];
    }

    /**
     * Returns the full text status.
     */
    public function get_full_text_status() {
        return $this->_data['full_text_status'];
    }

    /**
     * Returns the institution.
     */
    public function get_institution() {
        return $this->_data['institution'];
    }

    /**
     * Returns the patent applicant.
     */
    public function get_patent_applicant() {
        return $this->_data['patent_applicant'];
    }

    /**
     * Returns the reviewed item.
     */
    public function get_reviewed_item() {
        return $this->_data['reviewed_item'];
    }

    /**
     * Returns the official url.
     */
    public function get_official_url() {
        return $this->_data['official_url'];
    }

    /**
     * Get all divisions associated with this publication.
     */
    private function build_division_cache() {
        if ($this->_divisions !== null) {
            return;
        }

        $eprintid = $this->get_id();
        if (empty($eprintid)) {
            return;
        }

        // Grab divisions from the API.
        $this->_divisions = $this->_api->get_divisions($eprintid);
    }

    /**
     * Returns divisions this item belongs to.
     */
    public function get_divisions() {
        $this->build_division_cache();
        return $this->_divisions;
    }

    /**
     * Returns the publication's document's file name.
     */
    public function get_filename() {
        $fileinfo = $this->_data['fileinfo'];
        if (strpos($fileinfo, ';') === false) {
            return "";
        }

        $parts = explode(';', $fileinfo);
        $filename = array_pop($parts);

        return $filename;
    }

    /**
     * Returns the publication's document's URL.
     */
    public function get_file_url() {
        return $this->_api->get_url() . "/" . $this->get_filename();
    }

    /**
     * Returns the publication's document's Type.
     */
    public function get_file_type() {
        $filename = $this->get_filename();
        if (strpos($filename, '.') === false) {
            // Try and guess based on fileinfo.
            $fileinfo = $this->_data['fileinfo'];

            if (strpos($fileinfo, 'application_pdf') !== false) {
                return "pdf";
            }

            if (strpos($fileinfo, 'application_msword') !== false) {
                return "docx";
            }

            if (strpos($fileinfo, 'application_postscript') !== false) {
                return "ps";
            }

            if (strpos($fileinfo, 'ms-powerpoint') !== false) {
                return "pptx";
            }

            return "";
        }

        $filetype = substr($filename, strrpos($filename, '.') + 1);
        return strtolower($filetype);
    }

    /**
     * Returns the publication URL.
     */
    public function get_url() {
        return $this->_api->get_url() . "/" . $this->get_id();
    }

    /**
     * To String.
     */
    public function __toString() {
        $str = $this->get_title() . "\n";
        $authors = $this->get_authors();
        if (!empty($authors)) {
            $str .= "By " . implode(', ', $authors) . "\n";
        }
        $str .= "See " . $this->get_url();

        return $str;
    }

    /**
     * Return formatted citation in given reference style.
     */
    public function as_citation($csl = 'apa') {
        // Get parser for this citation format.
        $parser = $this->get_citeproc_parser($csl);

        // Return formatted citation.
        return $parser->render($this->get_for_citeproc());
    }

    /**
     * Format for CiteProc.
     * 
     * @internal
     */
    protected function get_for_citeproc() {
        // Format data in order to build
        $publication = new \stdClass();
        
        // Add basic params to pub object
        $publication->id = $this->get_id();
        $publication->type = $this->get_citeproc_type();

        $publication->DOI = $this->get_id_number();
        $publication->ISSN = $this->get_issn();
        $publication->ISBN = $this->get_isbn();

     
        $publication->abstract = $this->get_abstract();
        $publication->number = $this->get_number();
        $publication->page = $this->get_page_range();

        $publication->publisher = $this->get_publisher();
        $publication->{"publisher-place"} = $this->get_place_of_pub();

        $publication->title = $this->get_title();
        $publication->URL = $this->get_official_url();

        $publication->volume = $this->get_volume();
        $publication->issued = (object) array(
            "date-parts" => array(array($this->get_year())),
            "literal" => $this->get_year()
        );

        $publication->event = $this->get_event_title();
        $publication->{"event-date"} = $this->get_event_dates();
        $publication->{"event-place"} = $this->get_event_location();

        $publication->medium = $this->get_output_media();

        $publication->performance_type = $this->get_performance_type();

        $publication->{"container-title"} = $this->get_book_title();

        $publication->{"number-of-pages"} = $this->get_pages();

        // Convert author & editor fields
        $publication->author = array();
        $publication->editor = array();

        foreach ($this->get_authors() as $author) {
            $record = array(
                "given" => $author->get_firstname(),
                "family" => $author->get_lastname()
            );
            $publication->author[] = (object)$record;
        }

        foreach ($this->get_editors() as $editor) {
            $record = array(
                "given" => $editor->get_firstname(),
                "family" => $editor->get_lastname()
            );
            $publication->editor[] = (object)$record;
        }

        // Currently unused fields - left blank.
        $publication->{"citation-label"} = '';
       
        $publication->documents = array();
        $publication->edition = '';
        $publication->issue = '';
        $publication->note = '';

        return $publication;
    }

    /**
     * Converts KAR type to CiteProc type.
     * 
     * @return array Mappings.
     */
    public function get_citeproc_type() {
        $kartype = $this->get_type();

        switch ($kartype) {
            // Unsure.
            case 'artefact':
            case 'exhibition':
            case 'software':
            case 'scholarlyed':
                return "article";
            case 'audio':
                return "speech";
            case 'performance':
                return "song";
            case 'monograph':
                return "thesis";
            case 'design':
                return "figure";

            // "Probably" right.
            case 'article':
                return "article";
            case 'book':
            case 'edbook':
                return "book";
            case 'book_section';
                return "chapter";
            case 'composition':
                return "musical_score";
            case 'conference_item':
                return "paper-conference";
            case 'confidential_report':
                return "report";
            case 'dataset':
                return "dataset";
            case 'image':
                return "graphic";
            case 'internet':
                return "webpage";
            case 'patent':
                return "patent";
            case 'research_report':
                return "report";
            case 'review':
                return "review";
            case 'thesis':
                return "thesis";
            case 'video':
                return "motion_picture";

            // Return article as the default.
            case 'other':
            default:
                return "article";
        }
    }

    /**
     * Format for CiteProc
     * 
     * @internal
     * @param string $csl - reference format csl APA/IEEE etc
     * @return object $parser - Parser for given reference format
     */
    protected function get_citeproc_parser($csl) {
        static $parsers = array();

        if (!isset($parsers[$csl])) {
            $safecsl = preg_replace("([^a-z0-9\-])", '', $csl);

            $filename = dirname(__FILE__) . "/csls/" . $safecsl . ".csl";
            if (!file_exists($filename)) {
                throw new \Exception("Invalid CSL: " . $csl);
            }

            $csl = file_get_contents($filename);
            $parsers[$csl] = new \academicpuma\citeproc\CiteProc($csl);
        }

        return $parsers[$csl];
    }
}
