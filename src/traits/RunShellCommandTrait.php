<?php
/**
 * Imager X plugin for Craft CMS
 *
 * Ninja powered image transforms.
 *
 * @link      https://www.spacecat.ninja
 * @copyright Copyright (c) 2020 André Elvan
 */

namespace spacecatninja\imagerx\traits;

use Craft;
use mikehaertl\shellcommand\Command;

trait RunShellCommandTrait
{
    /**
     * Runs a shell command through mikehaertl\shellcommand
     * 
     * @param $commandString
     *
     * @return string
     */
    private static function runShellCommand($commandString): string
    {
        $shellCommand = new Command();
        $shellCommand->setCommand($commandString);

        if ($shellCommand->execute()) {
            $result = $shellCommand->getOutput();
        } else {
            $result = $shellCommand->getError();
        }

        return $result;
    }
}
