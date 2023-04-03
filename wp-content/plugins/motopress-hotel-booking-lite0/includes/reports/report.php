<?php

namespace MPHB\Reports;

class Report {
    /**
     * @var array
     */
    public $atts;

    /**
     * @var object
     */
    public $report;

    /**
     *
     * @param array $atts
     */
    public function __construct( $atts = array() ) {
        $this->atts = array_merge(
            $atts,
            $this->getAttr()
        );

        $this->setUpReport();
    }

    /**
     *
     * @return array
     */
    protected function getAttr() {
        $reportType = !empty( $_GET['report_type'] ) && in_array( $_GET['report_type'], ReportFilters::REPORT_TYPES ) ? $_GET['report_type'] : ReportFilters::DEFAULT_REPORT_TYPE;

        $atts['report_type'] = $reportType;

        if( !empty( $_GET['range'] ) ) {
            $atts['range'] = sanitize_title( $_GET['range'] );
        }

        if( !empty( $_GET['date_from'] ) && strtotime( $_GET['date_from'] ) ) {
            $atts['date_from'] = $_GET['date_from'];
        }

        if( !empty( $_GET['date_to'] ) && strtotime( $_GET['date_to'] ) ) {
            $atts['date_to'] = $_GET['date_to'];
        }

        return $atts;
    }

    protected function setUpReport() {
        if( !empty( $this->atts['report_type'] ) ) {
            switch( $this->atts['report_type'] ) {
                case 'earnings':
                    $this->report = new EarningsReport( $this->atts );
                    break;
            }
        }
    }

    /**
     *
     * @return array
     */
    public function getAtts() {
        return $this->atts;
    }

    /**
     *
     * @return \EarningsReport
     */
    public function getReport() {
        return $this->report;
    }
}

?>
