<?php
/**
 *  Thai Date and Time
 * Author:  Yuttapong Napikun
 * Email: yuttaponk@gmail.com
 * Date: 18/11/2559
 * Time: 15:26
 */


/**
 * Date
 *
 * short : 18/11/2559
 * medium : 18 พ.ย. 2559
 * long : 18 พฤศจิกายน 2559
 * full : วันศุกร์ที่ 18 พฤศจิกายน พ.ศ. 2559
 * --------------------------------------------------------------------
 *
 *
 * Date and time
 *
 * short : 18/11/2559 18.30 น.
 * medium : 18 พ.ย. 2559
 * long : 18 พฤศจิกายน 2559
 * full : วันศุกร์ที่ 18 พฤศจิกายน พ.ศ. 2559, เวลา 18.30 น.
 * */

/**
 * ตัวอย่างการใช้งาน - How to use
 *
 *  echo ThaiDate::widget([
 *   'timestamp' => time(),
 *   'type' => ThaiDate::TYPE_LONG,
 *   'showTime' => true
 *  ]);
 *
 *
 */

namespace common\siricenter\thaiformatter;

use yii\base\Widget;

class ThaiDate extends Widget
{
    const TYPE_SHORT = 'short';
    const TYPE_MEDIUM = 'medium';
    const TYPE_LONG = 'long';
    const TYPE_FULL = 'full';


    public $timestamp;
    public $datetime;
    public $type = self::TYPE_SHORT;
    public $showTime = false;

    private $_dayName = ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัส', 'ศุกร์', 'เสาร์'];

    private $_monthNameFull = [
        '', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
    ];

    private $_monthNameShort = [
        '', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'
    ];


    private $_timestamp;
    private $_year;
    private $_month;
    private $_date;
    private $_day;
    private $_hour;
    private $_minute;
    private $_datetime;


    public function init()
    {
        parent::init();

        if (is_numeric($this->timestamp)) {
            $formatdate = date('Y-m-d H:i:s', $this->timestamp);
            $this->_timestamp = new \DateTime($formatdate);
        } else {
            $formatdate = date('Y-m-d H:i:s', strtotime($this->timestamp));
            $this->_timestamp = new \DateTime($formatdate);
        }
        $this->_date = $this->_timestamp->format('d');
        $this->_month = $this->_timestamp->format('n');
        $this->_year = $this->_timestamp->format('Y') + 543;
        $this->_hour = $this->_timestamp->format('H');
        $this->_minute = $this->_timestamp->format('i');
        $this->_day = $this->_timestamp->format('w');
        $this->_datetime = $this->_timestamp->format("Y-m-d H:i:s");
    }

    public function run()
    {
        if ( ! empty($this->timestamp) && checkdate($this->_month, $this->_date, $this->_year)) {

            // short
            if ($this->type == ThaiDate::TYPE_SHORT) {
                if ($this->showTime)
                    return $this->shortDateTime();
                else
                    return $this->shortDate();
            }

            // medium
            if ($this->type == ThaiDate::TYPE_MEDIUM) {
                if ($this->showTime)
                    return $this->mediumDateTime();
                else
                    return $this->mediumDate();
            }

            // long
            if ($this->type == ThaiDate::TYPE_LONG) {
                if ($this->showTime)
                    return $this->longDateTime();
                else
                    return $this->longDate();
            }


            // full
            if ($this->type == ThaiDate::TYPE_FULL) {
                if ($this->showTime)
                    return $this->fullDateTime();
                else
                    return $this->fullDate();
            }
        } else {
            return;
        }
    }


    /**
     * short : 18/11/2559
     * @return string
     */
    private function shortDate()
    {
        return "{$this->_date}/{$this->_month}/{$this->_year}";
    }


    /**
     * medium : 18 พ.ย. 2559
     * @return string
     */
    private function mediumDate()
    {
        return "{$this->_date} {$this->_monthNameShort[$this->_month]} {$this->_year}";
    }


    /**
     * long : 18 พฤศจิกายน 2559
     * @return string
     */
    private function longDate()
    {
        return "{$this->_date} {$this->_monthNameFull[$this->_month]} {$this->_year}";
    }


    /**
     * full : วันศุกร์ที่ 18 พฤศจิกายน พ.ศ. 2559
     * @return string
     */
    private function fullDate()
    {
        return "วัน{$this->_dayName[$this->_day]}ที่ {$this->_date} {$this->_monthNameFull[$this->_month]} พ.ศ. {$this->_year}";
    }


    /**
     * short : 18/11/2559
     * @return string
     */
    private function shortDateTime()
    {
        return "{$this->_date}/{$this->_month}/{$this->_year}, {$this->_hour}.{$this->_minute} น.";
    }


    /**
     * medium : 18 พ.ย. 2559
     * @return string
     */
    private function mediumDateTime()
    {
        return "{$this->_date} {$this->_monthNameShort[$this->_month]} {$this->_year}, {$this->_hour}.{$this->_minute} น.";
    }


    /**
     * long : 18 พฤศจิกายน 2559
     * @return string
     */
    private function longDateTime()
    {
        return "{$this->_date} {$this->_monthNameFull[$this->_month]} {$this->_year}, {$this->_hour}.{$this->_minute} น.";
    }


    /**
     * full : วันศุกร์ที่ 18 พฤศจิกายน พ.ศ. 2559
     * @return string
     */
    private function fullDateTime()
    {
        // echo $this->_timestamp->format('w');
        return "วัน{$this->_dayName[$this->_day]}ที่ {$this->_date} {$this->_monthNameFull[$this->_month]} พ.ศ. {$this->_year}, เวลา {$this->_hour}.{$this->_minute} น.";
    }


}