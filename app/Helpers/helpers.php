<?php


function printRequired($text = '*', $title = 'Wajib Diisi!')
{
    return "<small class='text-danger' title='" . $title . "' data-toggle='tooltip' data-placement='top'>" . $text . "</small>";
}