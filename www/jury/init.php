<?php
/**
 * Include required files.
 *
 * $Id$
 *
 * Part of the DOMjudge Programming Contest Jury System and licenced
 * under the GNU GPL. See README and COPYING for details.
 */

// Sanity check whether webserver basic authentication (e.g in
// apache.conf) is configured correctly
if (empty($_SERVER['REMOTE_USER']) || $_SERVER['AUTH_TYPE'] != "Basic") {
	die("Authentication not enabled, check webserver config");
}

define('IS_JURY', TRUE);

require_once('../configure.php');

if( DEBUG & DEBUG_TIMINGS ) {
	require_once(LIBDIR . '/lib.timer.php');
}

require_once(LIBDIR . '/lib.error.php');

if ( !defined('WEBBASEURI') || WEBBASEURI == "" || stristr(WEBBASEURI, 'example.com') !== FALSE ) {
	error('WEBBASEURI not configured. ' .
		'Please set the WEBBASEURI in ' . htmlspecialchars(ETCDIR . '/domserver-config.php') .
		' to the full URI to your DOMjudge installation.');
}

require_once(LIBDIR . '/lib.misc.php');
require_once(LIBDIR . '/lib.dbconfig.php');
require_once(LIBDIR . '/use_db.php');

setup_database_connection('jury');

require_once(LIBWWWDIR . '/common.php');
require_once(LIBWWWDIR . '/print.php');

require_once(LIBWWWDIR . '/validate.jury.php');
require_once(LIBWWWDIR . '/common.jury.php');

$cdata = getCurContest(TRUE);
$cid = (int)$cdata['cid'];

$nunread_clars = $DB->q('VALUE SELECT COUNT(*) FROM clarification
                         WHERE sender IS NOT NULL AND cid = %i
                         AND answered = 0', $cid);
