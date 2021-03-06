<?php namespace ZN;
/**
 * ZN PHP Web Framework
 * 
 * "Simplicity is the ultimate sophistication." ~ Da Vinci
 * 
 * @package ZN
 * @license MIT [http://opensource.org/licenses/MIT]
 * @author  Ozan UYKUN [ozan@znframework.com]
 */

class Console
{
    /**
     * Default Project Name
     * 
     * @var string
     */
    protected static $project = DEFAULT_PROJECT;

    /**
     * Keep command
     * 
     * @var string
     */
    protected static $command;

    /**
     * Keep parameters
     * 
     * @var array
     */
    protected static $parameters;

    /**
     * Run commands
     * 
     * @param array $commands
     * 
     * @return void
     */
    public static function run($commands)
    {
        Helper::report('TerminalCommands', implode(' ', $commands), 'TerminalCommands');

        $realCommands = implode(' ', self::arrayRemoveFirst($commands, 3));

        array_shift($commands);

        if( ($commands[0] ?? NULL) !== 'project-name' )
        {
            array_unshift($commands, DEFAULT_PROJECT);
            array_unshift($commands, 'project-name');
        }

        self::$project = $commands[1] ?? DEFAULT_PROJECT;
        $command       = $commands[2] ?? NULL;
        self::$command = $commands[3] ?? NULL;

        if( $command === NULL )
        {
            new Commands\CommandList; exit;
        }

        self::$parameters = self::arrayRemoveFirst($commands, 4);

        switch( $command )
        {
            case 'run-uri'               :
            case 'run-controller'        : new Commands\Controller(self::$command); break;
            case 'run-model'             : 
            case 'run-class'             : new Commands\Library(self::$command, self::$parameters); break;
            case 'run-cron'              : new Commands\Cron(self::$command, self::$parameters); break;
            case 'cron-list'             : new Commands\CronList; break;
            case 'remove-cron'           : new Commands\RemoveCron(self::$parameters); break;
            case 'run-command'           : new Commands\Library(self::$command, self::$parameters, PROJECT_COMMANDS_NAMESPACE); break;
            case 'run-external-command'  : new Commands\Library(self::$command, self::$parameters, EXTERNAL_COMMANDS_NAMESPACE); break;
            case 'run-function'          : new Commands\Method(self::$command, self::$parameters); break;
            case 'upgrade'               : new Commands\Upgrade; break;
            case 'upgrade-files'         : new Commands\UpgradeFiles; break;
            case 'start-restoration'     : new Commands\StartRestoration(self::$command, self::$parameters); break;
            case 'end-restoration'       : new Commands\EndRestoration(self::$command); break;
            case 'end-restoration-delete': new Commands\EndRestorationDelete(self::$command); break;
            case 'create-project'        : new Commands\CreateProject(self::$command); break;
            case 'delete-project'        : new Commands\DeleteProject(self::$command); break;
            case 'create-controller'     : new Commands\CreateController(self::$command); break;
            case 'create-grand-model'    : new Commands\CreateGrandModel(self::$command); break;
            case 'create-grand-vision'   : new Commands\CreateGrandVision(self::$command); break;
            case 'delete-grand-vision'   : new Commands\DeleteGrandVision(self::$command); break;
            case 'create-model'          : new Commands\CreateModel(self::$command); break;
            case 'delete-controller'     : new Commands\DeleteController(self::$command); break;
            case 'delete-model'          : new Commands\DeleteModel(self::$command); break;
            case 'clean-cache'           : new Commands\CleanCache; break;
            # 5.3.5[added]
            case 'generate-databases'    : new Commands\GenerateDatabases; break;
            case 'command-list'          : new Commands\CommandList; break;
            default                      :
            # 5.3.5[added]
            if( strstr($realCommands, ':') )
            {
                new Commands\ShortCommand($realCommands);
            }
            else
            {
                new Commands\TerminalCommand($realCommands);
            }
        }
    }

    /**
     * Array Remove First
     * 
     * @param array & $array
     * @param int     $count = 1
     * 
     * @return array
     * 
     */
    protected static function arrayRemoveFirst(Array $array, Int $count = 1) : Array
    {
        for( $i = 0; $i < $count; $i++ )
        {
            array_shift($array);
        }

        return $array;
    }
}
