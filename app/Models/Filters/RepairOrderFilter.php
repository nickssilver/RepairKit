<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class RepairOrderFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    /**
     * RepairOrder search query
     *
     * @param mixed $search query
     *
     * @return RepairOrderFilter
     */
    public function search($search): RepairOrderFilter
    {
        return $this->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('email', 'LIKE', '%' . $search . '%')
            ->orWhere('phone', 'LIKE', '%' . $search . '%')
            ->orWhere('tracking', 'LIKE', '%' . $search . '%')
            ->orWhere('serial_number', 'LIKE', '%' . $search . '%');
    }

    /**
     * Filtering by technician
     *
     * @param mixed $technician technician
     *
     * @return RepairOrderFilter
     */
    public function technician($technician): RepairOrderFilter
    {
        return $this->where('user_id', '=', $technician);
    }

    /**
     * Filtering by repair status
     *
     * @param mixed $status status
     *
     * @return RepairOrderFilter
     */
    public function status($status): RepairOrderFilter
    {
        return $this->where('repair_status_id', '=', $status);
    }

    /**
     * Filtering by repair priority
     *
     * @param mixed $priority priority
     *
     * @return RepairOrderFilter
     */
    public function priority($priority): RepairOrderFilter
    {
        return $this->where('repair_priority_id', '=', $priority);
    }

    /**
     * Filtering by payment status is paid or not
     *
     * @param mixed $payment payment_status
     *
     * @return RepairOrderFilter
     */
    public function payment($payment): RepairOrderFilter
    {
        return $this->where('payment_status', '=', $payment);
    }

    /**
     * Filtering by starting date
     *
     * @param      mixed            $startdate  The startdate
     *
     * @return     RepairOrderFilter  The repair order filter.
     */
    public function startdate($startdate): RepairOrderFilter
    {
        return $this->where('created_at', '>', $startdate);
    }

    /**
     * Filtering by ending date date
     *
     * @param      mixed        $period  The period
     *
     * @return     RepairOrderFilter  The repair order filter.
     */
    public function enddate($enddate): RepairOrderFilter
    {
        return $this->where('created_at', '<', $enddate);
    }

    /**
     * Determines whether the specified is device collected is device collected.
     *
     * @param      bool               $isDeviceCollected  Indicates if device collected
     *
     * @return     RepairOrderFilter  True if the specified is device collected is device collected, False otherwise.
     */
    public function isDeviceCollected($isDeviceCollected): RepairOrderFilter
    {
        return $this->where('is_device_collected', $isDeviceCollected);
    }

    /**
     * Determines whether the specified is manual is manual.
     *
     * @param      bool               $isManual  Indicates if manual
     *
     * @return     RepairOrderFilter  True if the specified is manual is manual, False otherwise.
     */
    public function isManual($isManual): RepairOrderFilter
    {
        return $this->where('is_manual', $isManual);
    }

    /**
     * Filtering by by day
     *
     * @param      mixed           $isDuration  The duration
     *
     * @return     RepairOrderFilter  The repair order filter.
     */
    public function isDuration($isDuration): RepairOrderFilter
    {
        if ('day' == $isDuration) {
            return $this->whereDay('created_at', '=', date('d'));
        }
        if ('month' == $isDuration) {
            return $this->whereMonth('created_at', '=', date('m'));
        }
        if ('year' == $isDuration) {
            return $this->whereYear('created_at', '=', date('Y'));
        }
        return $this;
    }

    public function isLock($isLock): RepairOrderFilter
    {
        return $this->where('is_lock', '=', $isLock);
    }

    public function isArchive($isArchive): RepairOrderFilter
    {
        return $this->where('is_archive', '=', $isArchive);
    }

    public function hasWarranty($hasWarranty): RepairOrderFilter
    {
        return $this->where('has_warranty', '=', $hasWarranty);
    }
}
