<?php defined('SYSPATH') or die('No direct script access.');

class Kohana extends Kohana_Core
{
    protected static $_paths = [APPPATH, COMPATH, SYSPATH];

    /**
     * Changes the currently enabled modules. Module paths may be relative
     * or absolute, but must point to a directory:
     *
     *     Kohana::modules(array('modules/foo', MODPATH.'bar'));
     *
     * @param   array   $modules    list of module paths
     * @throws Kohana_Exception
     * @return  array   enabled modules
     */
    public static function modules(array $modules = null)
    {
        if ($modules === null) {
            // Not changing modules, just return the current set
            return Kohana::$_modules;
        }

        // Start a new list of include paths, APPPATH first
        $paths = [APPPATH];

        try {
            $paths[] = COMPATH;
        } catch (Exception $e) {}

        foreach ($modules as $name => $path) {
            if (is_dir($path)) {
                // Add the module to include paths
                $paths[] = $modules[$name] = realpath($path).DIRECTORY_SEPARATOR;
            } else {
                // This module is invalid, remove it
                throw new Kohana_Exception('Attempted to load an invalid or missing module \':module\' at \':path\'', [
                    ':module' => $name,
                    ':path'   => Debug::path($path),
                ]);
            }
        }

        // Finish the include paths by adding SYSPATH
        $paths[] = SYSPATH;

        // Set the new include paths
        Kohana::$_paths = $paths;

        // Set the current module list
        Kohana::$_modules = $modules;

        foreach (Kohana::$_modules as $path) {
            $init = $path . 'init' . EXT;

            if (is_file($init)) {
                // Include the module initialization file once
                /** @noinspection PhpIncludeInspection */
                require_once $init;
            }
        }

        return Kohana::$_modules;
    }
}