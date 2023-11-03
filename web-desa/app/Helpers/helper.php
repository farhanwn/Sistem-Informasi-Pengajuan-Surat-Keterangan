<?php

if (!function_exists('status')) {
    /**
     * Print status
     *
     * Print status dari database dengan nama yang lebih mudah dipahami
     *
     * @param string|int $kode_status Kode status dari database
     * @return String
     **/
    function status(string|int $kode_status): string
    {
        $status = [
            0 => 'waiting',
            1 => 'approve',
            2 => 'reject',
            3 => 'revisi',
        ];

        return $status[$kode_status];
    }
}
