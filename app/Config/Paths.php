<?php

namespace Config;

/**
 * Paths
 *
 * Holds the paths that are used by the system to
 * locate the main directories, app, system, etc.
 *
 * Modifying these allows you to restructure your application,
 * share a system folder between multiple applications, and more.
 *
 * All paths are relative to the project's root folder.
 */

class Paths
{
	/**
	 * ---------------------------------------------------------------
	 * SYSTEM FOLDER NAME
	 * ---------------------------------------------------------------
	 *
	 * This must contain the name of your "system" folder. Include
	 * the path if the folder is not in the same directory as this file.
	 *
	 * @var string
	 */
	public $systemDirectory = __DIR__ . '/../../system';

	/**
	 * ---------------------------------------------------------------
	 * APPLICATION FOLDER NAME
	 * ---------------------------------------------------------------
	 *
	 * If you want this front controller to use a different "app"
	 * folder than the default one you can set its name here. The folder
	 * can also be renamed or relocated anywhere on your getServer. If
	 * you do, use a full getServer path.
	 *
	 * @see http://codeigniter.com/user_guide/general/managing_apps.html
	 *
	 * @var string
	 */
	public $appDirectory = __DIR__ . '/..';

	/**
	 * ---------------------------------------------------------------
	 * WRITABLE DIRECTORY NAME
	 * ---------------------------------------------------------------
	 *
	 * This variable must contain the name of your "writable" directory.
	 * The writable directory allows you to group all directories that
	 * need write permission to a single place that can be tucked away
	 * for maximum security, keeping it out of the app and/or
	 * system directories.
	 *
	 * @var string
	 */
	public $writableDirectory = __DIR__ . '/../../writable';

	/**
	 * ---------------------------------------------------------------
	 * TESTS DIRECTORY NAME
	 * ---------------------------------------------------------------
	 *
	 * This variable must contain the name of your "tests" directory.
	 *
	 * @var string
	 */
	public $testsDirectory = __DIR__ . '/../../tests';

	/**
	 * ---------------------------------------------------------------
	 * VIEW DIRECTORY NAME
	 * ---------------------------------------------------------------
	 *
	 * This variable must contain the name of the directory that
	 * contains the view files used by your application. By
	 * default this is in `app/Views`. This value
	 * is used when no value is provided to `Services::renderer()`.
	 *
	 * @var string
	 */
	public $viewDirectory = __DIR__ . '/../Views';
	
}
