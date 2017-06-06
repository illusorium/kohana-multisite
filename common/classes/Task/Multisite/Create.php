<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Task_Multisite_Create
 *
 * Create structure for a new site (will be placed in ROOTPATH . sites/)
 */
class Task_Multisite_Create extends Minion_Task
{
    protected $path = null;

    protected $_options = [
        'site' => null,    // site name
        'docRoot' => 'www' // name of documentRoot directory: www, public_html, htdocs, etc.
    ];

    public function build_validation(Validation $validation)
    {
        return parent::build_validation($validation)
            ->rules(
                'site',
                [
                    ['not_empty'],
                    [
                        function(Validation $array, $field, $value) {
                            $path = ROOTPATH . 'sites' . DIRECTORY_SEPARATOR . $value;
                            if (!empty(glob($path))) {
                                $array->error($field, "Site $value already exists");
                            } else {
                                $this->path = $path;
                            }
                        },
                        [':validation', ':field', ':value']
                    ]
                ]
            )
            ->rule('docRoot', 'not_empty');
    }

    protected function _execute(array $params)
    {
        $params['docRoot'] = trim($params['docRoot'], '/ ');

        $index      = realpath(ROOTPATH . 'samples' . DIRECTORY_SEPARATOR . 'index.tpl.php');
        $bootstrap  = realpath(ROOTPATH . 'samples' . DIRECTORY_SEPARATOR . 'bootstrap.tpl.php');
        $controller = realpath(ROOTPATH . 'samples' . DIRECTORY_SEPARATOR . 'ControllerSample.tpl.php');

        if (empty($index) || empty($bootstrap)) {
            Minion_CLI::write(Minion_CLI::color('Could not find index.tpl.php or bootstrap.tpl.php in samples dir', 'red'));
            return;
        }

        mkdir($this->path, 0777, true);

        $dirs = [
            'application',
            'application/classes',
            'application/classes/Controller',
            'tmp',
            $params['docRoot']
        ];
        foreach ($dirs as $dir) {
            mkdir($this->path . DIRECTORY_SEPARATOR . $dir, 0777, true);
        }

        $umask = umask(0);
        $dirs777 = [
            'application/cache',
            'application/logs'
        ];
        foreach ($dirs777 as $dir) {
            mkdir($this->path . DIRECTORY_SEPARATOR . $dir);
        }
        umask($umask);

        copy($index, $this->path . DIRECTORY_SEPARATOR . $params['docRoot'] . DIRECTORY_SEPARATOR . 'index.php');
        copy($bootstrap, $this->path . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'bootstrap.php');
        copy(
            $controller,
            implode(DIRECTORY_SEPARATOR, [$this->path, 'application', 'classes', 'Controller', 'Sample.php'])
        );

        Minion_CLI::write(
            'Site structure is ready. You should also:' . PHP_EOL
            . '- create web server\'s virtual host with document root '
            . Minion_CLI::color($this->path . DIRECTORY_SEPARATOR . $params['docRoot'], 'yellow') . PHP_EOL
            . '- (if necessary) add an appropriate note into system\'s hosts file'
        );
    }
}