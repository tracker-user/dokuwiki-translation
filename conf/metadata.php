<?php

/**
 * Options for the translation plugin
 *
 * @author Andreas Gohr <andi@splitbrain.org>
 */

$meta['translations']  = ['string', '_pattern' => '/^(|[a-zA-Z\- ,]+)$/'];
//$meta['translationns'] = ['string', '_pattern' => '/^(|[\w:\-]+)$/']; // currently broken
$meta['skiptrans']     = ['string'];
$meta['dropdown']      = ['onoff'];
$meta['display']       = ['multicheckbox',
                          '_choices' => ['langcode', 'name', 'flag', 'title']];
$meta['translateui']   = ['onoff'];
$meta['redirectstart'] = ['onoff'];
$meta['checkage']      = ['onoff'];
$meta['about']         = ['string', '_pattern' => '/^(|[\w:\-]+)$/'];
$meta['localabout']    = ['onoff'];
$meta['copytrans']     = ['onoff'];
$meta['show_path']     = ['onoff'];
