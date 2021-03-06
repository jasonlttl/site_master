<?php
namespace SiteMaster\Core\Auditor\Site\Page\Links;

use DB\RecordList;

class All extends RecordList
{
    public function __construct(array $options = array())
    {
        $this->options = $options + $this->options;

        $options['array'] = self::getBySQL(array(
            'sql'         => $this->getSQL(),
            'returnArray' => true
        ));

        parent::__construct($options);
    }

    public function getDefaultOptions()
    {
        $options = array();
        $options['itemClass'] = '\SiteMaster\Core\Auditor\Site\Page\Link';
        $options['listClass'] = __CLASS__;

        return $options;
    }

    public function getWhere()
    {
        return '';
    }

    public function getSQL()
    {
        //Build the list
        $sql = "SELECT scanned_page_links.id
                FROM scanned_page_links
                LEFT JOIN scanned_page ON (scanned_page.id = scanned_page_links.scanned_page_id)
                LEFT JOIN scans ON (scans.id = scanned_page.scans_id)
                " . $this->getWhere() . "
                ORDER BY scanned_page_links.date_created DESC
                " . $this->getLimit();

        return $sql;
    }

    /**
     * @return \SiteMaster\Core\Auditor\Site\Page\Link
     */
    public function current()
    {
        return parent::current();
    }

    /**
     * Get the limit for the SQL query
     * 
     * @return string
     */
    public function getLimit()
    {
        if (!isset($this->options['limit']) || $this->options['limit'] == -1) {
            return '';
        }

        return 'LIMIT ' . (int)$this->options['limit'];
    }
}
