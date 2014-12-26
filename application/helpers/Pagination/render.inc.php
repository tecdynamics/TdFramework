<?php

/*
 * Description of Class Services
 * Copyright (c) 2013 - 2014 Tec-Dynamics
 *
 * This Framework is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * @category   PHP
 * @package    Framework
 * @copyright  Copyright (c) 2013 - 2014 Tec-Dynamics L.T.D. (http://www.tec-dynamics.co.uk/webphp)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    0.1.5, 2014-12-22
 */
// total page count calculation
$tottalpages = ((int) ceil($total / $rpp));

// if it's an invalid page request
if ($current < 1) {
    return;
} elseif ($current > $tottalpages) {
    return;
}

// if there are pages to be shown
if ($tottalpages > 1 || $alwaysShowPagination === true) {

    echo '<div id="pgpagination">
            <ul class="pgul">';
    /**
     * Previous Link
     */
    $classes = array('pgcopy', 'pgprevious');
    $params = $get;
    $params[$key] = ($current - 1);
    $href = ($target) . '?' . http_build_query($params);
    $href = preg_replace(
            array('/=$/', '/=&/'), array('', '&'), $href
    );
    if ($current === 1) {
        $href = '#';
        array_push($classes, 'pgdisabled');
    }
    echo '<li class="' . implode(" ", $classes) . '"><a href="' . ($href) . '">' . ($previous) . '</a></li>';

    /**
     * if this isn't a clean output for pagination (eg. show numerical
     * links)
     */
    if (!$clean) {

        /**
         * Calculates the number of leading page crumbs based on the minimum
         *     and maximum possible leading pages.
         */
        $max = min($tottalpages, $crumbs);
        $limit = ((int) floor($max / 2));
        $leading = $limit;
        for ($x = 0; $x < $limit; ++$x) {
            if ($current === ($x + 1)) {
                $leading = $x;
                break;
            }
        }
        for ($x = $tottalpages - $limit; $x < $tottalpages; ++$x) {
            if ($current === ($x + 1)) {
                $leading = $max - ($tottalpages - $x);
                break;
            }
        }

        // calculate trailing crumb count based on inverse of leading
        $trailing = $max - $leading - 1;

        // generate/render leading crumbs
        for ($x = 0; $x < $leading; ++$x) {

            // class/href setup
            $params = $get;
            $params[$key] = ($current + $x - $leading);
            $href = ($target) . '?' . http_build_query($params);
            $href = preg_replace(
                    array('/=$/', '/=&/'), array('', '&'), $href
            );

            echo '<li class="pgnumber"><a data-pagenumber="' . ($current + $x - $leading) . '" href="' . ($href) . '">' . ($current + $x - $leading) . '</a></li>';
        }

        // print current page
        echo '<li class="pgnumber pgactive"><a data-pagenumber="' . ($current) . '" href="#">' . ($current) . '</a></li>';

        // generate/render trailing crumbs
        for ($x = 0; $x < $trailing; ++$x) {

            // class/href setup
            $params = $get;
            $params[$key] = ($current + $x + 1);
            $href = ($target) . '?' . http_build_query($params);
            $href = preg_replace(
                    array('/=$/', '/=&/'), array('', '&'), $href
            );
            echo '<li class="pgnumber"><a data-pagenumber="' . ($current + $x + 1) . '" href="' . ($href) . '">' . ($current + $x + 1) . '</a></li>';
        }
    }

    /**
     * Next Link
     */
    $classes = array('pgcopy', 'pgnext');
    $params = $get;
    $params[$key] = ($current + 1);
    $href = ($target) . '?' . http_build_query($params);
    $href = preg_replace(
            array('/=$/', '/=&/'), array('', '&'), $href
    );
    if ($current === $tottalpages) {
        $href = '#';
        array_push($classes, 'pgdisabled');
    }
    echo '<li class="' . implode(" ", $classes) . '"><a href="' . ($href) . '">' . ($next) . '</a></li>
                    </ul>
                </div>';
}
